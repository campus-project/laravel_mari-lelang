<?php

namespace App\Http\Controllers;

use App\Entities\Topup;
use App\Entities\Transaction;
use App\Entities\User;
use App\Http\Resources\TopupResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TopupCreateRequest;
use App\Http\Requests\TopupUpdateRequest;
use App\Repositories\TopupRepository;
use App\Validators\TopupValidator;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Class TopupsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TopupsController extends Controller
{
    /**
     * @var TopupRepository
     */
    protected $repository;

    /**
     * @var TopupValidator
     */
    protected $validator;

    /**
     * TopupsController constructor.
     *
     * @param TopupRepository $repository
     * @param TopupValidator $validator
     */
    public function __construct(TopupRepository $repository, TopupValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TopupCreateRequest $request
     *
     * @return TopupResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TopupCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            Topup::where('user_id', Auth::user()->id)->where('token', null)->delete();

            $request->merge([
                'user_id' => Auth::user()->id
            ]);

            $topup = $this->repository->create($request->all());
            DB::commit();

            return ($this->show($topup->id))->additional(['success' => true, 'message' => 'Topup created.']);
        } catch (ValidatorException $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    /**
     * Verification topup
     *
     * @param  TopupUpdateRequest $request
     *
     * @return TopupResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function verification(TopupUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $topup = Topup::where('user_id', Auth::user()->id)->where('token', null)->with('user')->first();

            $token = md5(uniqid(rand(), true));
            $topup->token = $token;
            $topup->save();

            $filename = $token . '.' . $request->photo->getClientOriginalExtension();
            $path = 'images/slip-transfer/' . $filename;
            Image::make($request->photo->getRealPath())->save($path);

            $path = public_path($path);

            Telegram::sendPhoto([
                'chat_id' => config('app.telegram_id'),
                'photo' => InputFile::create($path, $filename),
                'caption' => $topup->user->name
                    . PHP_EOL . 'Topup: IDR ' . number_format($topup->amount, 2)
                    . PHP_EOL . 'Konfirmasi -> Klik ' . route('topup.approve', ['token' => $token])
            ]);

            Transaction::create([
                'name' => 'Topup',
                'amount' => $topup->amount,
                'status' => 'On Process',
                'user_id' => Auth::user()->id,
                'token' => $token
            ]);
            DB::commit();

            return ($this->show($topup->id))->additional(['success' => true, 'message' => 'Topup waiting for verification.']);
        } catch (ValidatorException $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    /**
     * The method use for verification administrator to topup wallet user
     *
     * @param null $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve($token = null)
    {
        try {
            if (!empty($token)) {
                DB::beginTransaction();

                $topup = Topup::where('token', $token)->first();
                if (!empty($topup)) {
                    $user = User::findOrFail($topup->user_id);
                    $user->wallet_balance += $topup->amount;
                    $user->save();
                    $topup->delete();

                    $transaction = Transaction::where('token', $token)->first();
                    $transaction->status = 'Success';
                    $transaction->save();
                    DB::commit();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Balance added.'
                ]);
            }
        } catch (ValidatorException $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return TopupResource
     */
    public function show($id)
    {
        $topup = $this->repository->with(['user'])
            ->find($id);

        return new TopupResource($topup);
    }
}

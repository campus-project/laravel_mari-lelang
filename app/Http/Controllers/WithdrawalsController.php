<?php

namespace App\Http\Controllers;

use App\Entities\Transaction;
use App\Entities\User;
use App\Entities\Withdrawal;
use App\Http\Resources\WithdrawalResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\WithdrawalCreateRequest;
use App\Http\Requests\WithdrawalUpdateRequest;
use App\Repositories\WithdrawalRepository;
use App\Validators\WithdrawalValidator;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Class WithdrawalsController.
 *
 * @package namespace App\Http\Controllers;
 */
class WithdrawalsController extends Controller
{
    /**
     * @var WithdrawalRepository
     */
    protected $repository;

    /**
     * @var WithdrawalValidator
     */
    protected $validator;

    /**
     * WithdrawalsController constructor.
     *
     * @param WithdrawalRepository $repository
     * @param WithdrawalValidator $validator
     */
    public function __construct(WithdrawalRepository $repository, WithdrawalValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WithdrawalCreateRequest $request
     *
     * @return WithdrawalResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(WithdrawalCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $token = md5(uniqid(rand(), true));
            $request->merge([
                'user_id' => Auth::user()->id,
                'token' => $token
            ]);

            $withdrawal = $this->repository->create($request->all());

            Telegram::sendMessage([
                'chat_id' => config('app.telegram_id'),
                'text' => $withdrawal->user->name . ' (' . $withdrawal->user->id . ')'
                    . PHP_EOL . ' (Withdrawal: IDR ' . number_format($request->amount, 2)
                    . PHP_EOL . 'Konfirmasi -> Klik ' . route('withdrawal.approve', ['token' => $token])
            ]);

            Transaction::create([
                'name' => 'Withdrawal',
                'amount' => $withdrawal->amount,
                'status' => 'On Process',
                'user_id' => Auth::user()->id,
                'token' => $token
            ]);

            $user = User::find(Auth::user()->id);
            $user->wallet_balance -= $withdrawal->amount;
            $user->save();

            DB::commit();

            return ($this->show($withdrawal->id))->additional(['success' => true, 'message' => 'Withdrawal created.']);
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
     * @return WithdrawalResource
     */
    public function show($id)
    {
        $withdrawal = $this->repository->with(['user'])
            ->find($id);

        return new WithdrawalResource($withdrawal);
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

                $withdrawal = Withdrawal::where('token', $token)->first();
                if (!empty($withdrawal)) {
                    $withdrawal->delete();

                    $transaction = Transaction::where('token', $token)->first();
                    $transaction->status = 'Success';
                    $transaction->save();
                    DB::commit();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Balance reducted.'
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
}

<?php

namespace App\Http\Controllers;

use App\Entities\AuctionProduct;
use App\Entities\Transaction;
use App\Entities\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BidCreateRequest;
use App\Http\Requests\BidUpdateRequest;
use App\Repositories\BidRepository;
use App\Validators\BidValidator;

/**
 * Class BidsController.
 *
 * @package namespace App\Http\Controllers;
 */
class BidsController extends Controller
{
    /**
     * @var BidRepository
     */
    protected $repository;

    /**
     * @var BidValidator
     */
    protected $validator;

    /**
     * BidsController constructor.
     *
     * @param BidRepository $repository
     * @param BidValidator $validator
     */
    public function __construct(BidRepository $repository, BidValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BidCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BidCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $token = md5(uniqid(rand(), true));
            $request->merge([
                'user_id' => Auth::user()->id,
                'token' => $token
            ]);

            $this->repository->create($request->all());

            $user = User::find(Auth::user()->id);
            $user->wallet_balance -= ($request->amount + 5000);
            $user->save();

            $product = AuctionProduct::find($request->auction_product_id);

            Transaction::create([
                'name' => 'Bid Charge ' . $product->name,
                'amount' => 5000,
                'status' => 'Success',
                'user_id' => Auth::user()->id
            ]);

            Transaction::create([
                'name' => 'Bid ' . $product->name ,
                'amount' => $request->amount,
                'status' => 'On Process',
                'user_id' => Auth::user()->id,
                'token' => $token
            ]);

            DB::commit();

            return response()->json([
                'success'   => true,
                'message' => 'Bid created.'
            ]);
        } catch (ValidatorException $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message' => $e->getMessageBag()
            ]);
        }
    }

}

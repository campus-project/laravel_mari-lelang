<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\WithdrawalCreateRequest;
use App\Http\Requests\WithdrawalUpdateRequest;
use App\Repositories\WithdrawalRepository;
use App\Validators\WithdrawalValidator;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $withdrawals = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $withdrawals,
            ]);
        }

        return view('withdrawals.index', compact('withdrawals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WithdrawalCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(WithdrawalCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $withdrawal = $this->repository->create($request->all());

            $response = [
                'message' => 'Withdrawal created.',
                'data'    => $withdrawal->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $withdrawal = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $withdrawal,
            ]);
        }

        return view('withdrawals.show', compact('withdrawal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $withdrawal = $this->repository->find($id);

        return view('withdrawals.edit', compact('withdrawal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WithdrawalUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(WithdrawalUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $withdrawal = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Withdrawal updated.',
                'data'    => $withdrawal->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Withdrawal deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Withdrawal deleted.');
    }
}

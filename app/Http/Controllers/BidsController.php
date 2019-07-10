<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $bids = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bids,
            ]);
        }

        return view('bids.index', compact('bids'));
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

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bid = $this->repository->create($request->all());

            $response = [
                'message' => 'Bid created.',
                'data'    => $bid->toArray(),
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
        $bid = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bid,
            ]);
        }

        return view('bids.show', compact('bid'));
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
        $bid = $this->repository->find($id);

        return view('bids.edit', compact('bid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BidUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BidUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bid = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Bid updated.',
                'data'    => $bid->toArray(),
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
                'message' => 'Bid deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Bid deleted.');
    }
}

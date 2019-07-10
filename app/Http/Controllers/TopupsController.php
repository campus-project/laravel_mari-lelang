<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TopupCreateRequest;
use App\Http\Requests\TopupUpdateRequest;
use App\Repositories\TopupRepository;
use App\Validators\TopupValidator;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $topups = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $topups,
            ]);
        }

        return view('topups.index', compact('topups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TopupCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TopupCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $topup = $this->repository->create($request->all());

            $response = [
                'message' => 'Topup created.',
                'data'    => $topup->toArray(),
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
        $topup = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $topup,
            ]);
        }

        return view('topups.show', compact('topup'));
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
        $topup = $this->repository->find($id);

        return view('topups.edit', compact('topup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TopupUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TopupUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $topup = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Topup updated.',
                'data'    => $topup->toArray(),
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
                'message' => 'Topup deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Topup deleted.');
    }
}

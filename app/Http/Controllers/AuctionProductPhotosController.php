<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AuctionProductPhotoCreateRequest;
use App\Http\Requests\AuctionProductPhotoUpdateRequest;
use App\Repositories\AuctionProductPhotoRepository;
use App\Validators\AuctionProductPhotoValidator;

/**
 * Class AuctionProductPhotosController.
 *
 * @package namespace App\Http\Controllers;
 */
class AuctionProductPhotosController extends Controller
{
    /**
     * @var AuctionProductPhotoRepository
     */
    protected $repository;

    /**
     * @var AuctionProductPhotoValidator
     */
    protected $validator;

    /**
     * AuctionProductPhotosController constructor.
     *
     * @param AuctionProductPhotoRepository $repository
     * @param AuctionProductPhotoValidator $validator
     */
    public function __construct(AuctionProductPhotoRepository $repository, AuctionProductPhotoValidator $validator)
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
        $auctionProductPhotos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $auctionProductPhotos,
            ]);
        }

        return view('auctionProductPhotos.index', compact('auctionProductPhotos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AuctionProductPhotoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AuctionProductPhotoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $auctionProductPhoto = $this->repository->create($request->all());

            $response = [
                'message' => 'AuctionProductPhoto created.',
                'data'    => $auctionProductPhoto->toArray(),
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
        $auctionProductPhoto = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $auctionProductPhoto,
            ]);
        }

        return view('auctionProductPhotos.show', compact('auctionProductPhoto'));
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
        $auctionProductPhoto = $this->repository->find($id);

        return view('auctionProductPhotos.edit', compact('auctionProductPhoto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AuctionProductPhotoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AuctionProductPhotoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $auctionProductPhoto = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'AuctionProductPhoto updated.',
                'data'    => $auctionProductPhoto->toArray(),
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
                'message' => 'AuctionProductPhoto deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'AuctionProductPhoto deleted.');
    }
}

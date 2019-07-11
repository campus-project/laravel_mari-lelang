<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuctionProductPhotoResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
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
     * Store a newly created resource in storage.
     *
     * @param  AuctionProductPhotoCreateRequest $request
     *
     * @return AuctionProductPhotoResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AuctionProductPhotoCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            foreach($request->file as $file) {
                $filename = md5(uniqid(rand(), true)) . '.' . $file->getClientOriginalExtension();
                $path = 'images/products/' . $filename;
                if (Image::make($file->getRealPath())->save($path)) {
                    $request->merge(['photo_url' => $path]);
                }
            }

            $auctionProductPhoto = $this->repository->create($request->all());
            DB::commit();

            return ($this->show($auctionProductPhoto->id))->additional(['success' => true, 'message' => 'Auction Product Photo uploaded.']);
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
     * @return AuctionProductPhotoResource
     */
    public function show($id)
    {
        $auctionProductPhoto = $this->repository->with(['auctionProduct'])
            ->find($id);

        return new AuctionProductPhotoResource($auctionProductPhoto);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function mock($id)
    {
        $auctionProductPhoto = $this->repository->find($id);
        $path = public_path($auctionProductPhoto->photo_url);
        if (!File::exists($path)) {
            abort(404);
        }

        return Response::json([
           'success' => true,
           'data' => [
               'name' => File::name($path) . '.' .File::extension($path),
               'size' => File::size($path),
               'url' => config('app.url') . '/' .$auctionProductPhoto->photo_url
           ]
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Entities\AuctionProduct;
use App\Entities\AuctionProductPhoto;
use App\Http\Resources\AuctionProductResource;
use App\Http\Resources\AuctionProductSelectResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AuctionProductCreateRequest;
use App\Http\Requests\AuctionProductUpdateRequest;
use App\Repositories\AuctionProductRepository;
use App\Validators\AuctionProductValidator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class AuctionProductsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AuctionProductsController extends Controller
{
    /**
     * @var AuctionProductRepository
     */
    protected $repository;

    /**
     * @var AuctionProductValidator
     */
    protected $validator;

    /**
     * AuctionProductsController constructor.
     *
     * @param AuctionProductRepository $repository
     * @param AuctionProductValidator $validator
     */
    public function __construct(AuctionProductRepository $repository, AuctionProductValidator $validator)
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
        return view('auctionProducts.index');
    }

    /**
     * The method handle request for select
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select(Request $request) {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $auctionProducts = $this->repository->paginate($request->per_page);

        return AuctionProductSelectResource::collection($auctionProducts);
    }

    /**
     * The method handler request for datatable
     *
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $auctionProducts = AuctionProduct::with('city.province', 'createdBy', 'productType', 'auctionProductPhotos')
        ->where(function($query) {
            if (!Auth::user()->is_admin) {
                $query->where('created_by', Auth::user()->id);
            }
        })
        ->orderBy('created_at', 'desc');

        return DataTables::of($auctionProducts)
            ->addIndexColumn()
            ->addColumn('photo', function($row) {
                return '<img class="mr-3 rounded-circle bx-shadow-lg" src="' . $row->auctionProductPhotos[0]->photo_url .'" alt="'. $row->name .'" style="width: 50px; height: 50px;">';
            })
            ->addColumn('start_auction', function($row) {
                return Carbon::parse($row->start_date)->format('d-m-Y');
            })
            ->addColumn('end_auction', function($row) {
                return Carbon::parse($row->end_date)->format('d-m-Y');
            })
            ->addColumn('product_type', function($row) {
                return $row->productType->name;
            })
            ->addColumn('province', function($row) {
                return $row->city->province->name;
            })
            ->addColumn('city', function($row) {
                return $row->city->name;
            })
            ->addColumn('created_by', function($row) {
                return $row->createdBy->name;
            })
            ->addColumn('action', function($row) {
                $button = '';

                if ($row->can_update) {
                    $button .= '<button type="button" class="btn btn-icon btn-warning waves-effect waves-light" onclick="handlerUpdate(' . $row->id . ')"> <i class="mdi mdi-circle-edit-outline"></i> </button> ';
                }

                if ($row->can_delete) {
                    $button .= '<button type="button" class="btn btn-icon btn-danger waves-effect waves-light" onclick="handlerDelete(' . $row->id . ')"> <i class="mdi mdi-trash-can-outline"></i> </button>';
                }

                return $button;
            })->rawColumns(['photo', 'action'])->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AuctionProductCreateRequest $request
     *
     * @return AuctionProductResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AuctionProductCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $request->merge([
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ]);

            $auctionProduct = $this->repository->create($request->all());

            foreach($request->auction_product_photos as $photo) {
                $filename = md5(uniqid(rand(), true)) . '.' . $photo->getClientOriginalExtension();
                $path = 'images/products/' . $filename;
                if (Image::make($photo->getRealPath())->save($path)) {
                    AuctionProductPhoto::create([
                        'auction_product_id' =>  $auctionProduct->id,
                        'photo_url' => $path,
                        'name' => $filename,
                        'type' => 'image/' . $photo->getClientOriginalExtension()
                    ]);
                }
            }

            DB::commit();

            return ($this->show($auctionProduct->id))->additional(['success' => true, 'message' => 'Auction Product created.']);
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
     * @return AuctionProductResource
     */
    public function show($id)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $auctionProduct = $this->repository->with(['city.province', 'createdBy', 'productType', 'auctionProductPhotos'])->find($id);

        return new AuctionProductResource($auctionProduct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AuctionProductUpdateRequest $request
     * @param  string            $id
     *
     * @return AuctionProductResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AuctionProductUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $request->merge([
                'updated_by' => Auth::user()->id
            ]);

            $auctionProduct = $this->repository->update($request->all(), $id);

            $photos = $auctionProduct->auctionProductPhotos->pluck('name')->toArray();
            $photoFromUpdate = [];
            foreach($request->auction_product_photos as $photo) {
                if (!is_file($photo)) {
                    array_push($photoFromUpdate, $photo);
                }
            }

            foreach($photos as $photo) {
                $path = public_path('/images/products/' . $photo);
                if (!in_array($photo, $photoFromUpdate) && file_exists($path)) {
                    unlink($path);
                    AuctionProductPhoto::where('name', $photo)->delete();
                }
            }

            foreach($request->auction_product_photos as $photo) {
                if (is_file($photo)) {
                    $filename = md5(uniqid(rand(), true)) . '.' . $photo->getClientOriginalExtension();
                    $path = 'images/products/' . $filename;
                    if (Image::make($photo->getRealPath())->save($path)) {
                        AuctionProductPhoto::create([
                            'auction_product_id' =>  $auctionProduct->id,
                            'photo_url' => $path,
                            'name' => $filename,
                            'type' => 'image/' . $photo->getClientOriginalExtension()
                        ]);
                    }
                }
            }

            DB::commit();

            return ($this->show($auctionProduct->id))->additional(['success' => true, 'message' => 'Auction Product updated.']);
        } catch (ValidatorException $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message' => $e->getMessageBag()
            ]);
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
        try {
            DB::beginTransaction();
            $this->repository->delete($id);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Auction Product deleted.'
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

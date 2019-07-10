<?php

namespace App\Http\Controllers;

use App\Entities\ProductType;
use App\Http\Resources\ProductTypeResource;
use App\Http\Resources\ProductTypeSelectResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProductTypeCreateRequest;
use App\Http\Requests\ProductTypeUpdateRequest;
use App\Repositories\ProductTypeRepository;
use App\Validators\ProductTypeValidator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class ProductTypesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProductTypesController extends Controller
{
    /**
     * @var ProductTypeRepository
     */
    protected $repository;

    /**
     * @var ProductTypeValidator
     */
    protected $validator;

    /**
     * ProductTypesController constructor.
     *
     * @param ProductTypeRepository $repository
     * @param ProductTypeValidator $validator
     */
    public function __construct(ProductTypeRepository $repository, ProductTypeValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return view('productTypes.index');
    }

    /**
     * The method handle request for select
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select(Request $request) {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $productTypes = $this->repository->paginate($request->per_page);

        return ProductTypeSelectResource::collection($productTypes);
    }

    /**
     * The method handler request for datatable
     *
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        return DataTables::of(ProductType::query())
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $button = '';

                if ($row->can_update) {
                    $button .= '<button type="button" class="btn btn-icon btn-warning waves-effect waves-light" onclick="handlerUpdate(' . $row->id . ')"> <i class="mdi mdi-circle-edit-outline"></i> </button> ';
                }

                if ($row->can_delete) {
                    $button .= '<button type="button" class="btn btn-icon btn-danger waves-effect waves-light" onclick="handlerDelete(' . $row->id . ')"> <i class="mdi mdi-trash-can-outline"></i> </button>';
                }

                return $button;
            })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductTypeCreateRequest $request
     *
     * @return ProductTypeResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProductTypeCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $productType = $this->repository->create($request->all());
            DB::commit();

            return ($this->show($productType->id))->additional(['success' => true, 'message' => 'Product Type created.']);
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
     * @return ProductTypeResource
     */
    public function show($id)
    {
        $productType = $this->repository->find($id);

        return new ProductTypeResource($productType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return ProductTypeResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProductTypeUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $productType = $this->repository->update($request->all(), $id);
            DB::commit();

            return ($this->show($productType->id))->additional(['success' => true, 'message' => 'Product Type updated.']);
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
                'message' => 'Product Type deleted.'
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

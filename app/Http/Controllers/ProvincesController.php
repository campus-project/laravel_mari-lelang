<?php

namespace App\Http\Controllers;

use App\Entities\Province;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\ProvinceSelectResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProvinceCreateRequest;
use App\Http\Requests\ProvinceUpdateRequest;
use App\Repositories\ProvinceRepository;
use App\Validators\ProvinceValidator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class ProvincesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProvincesController extends Controller
{
    /**
     * @var ProvinceRepository
     */
    protected $repository;

    /**
     * @var ProvinceValidator
     */
    protected $validator;

    /**
     * ProvincesController constructor.
     *
     * @param ProvinceRepository $repository
     * @param ProvinceValidator $validator
     */
    public function __construct(ProvinceRepository $repository, ProvinceValidator $validator)
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
        return view('provinces.index');
    }

    /**
     * The method handle request for select
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select(Request $request) {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $provinces = $this->repository->paginate($request->per_page);

        return ProvinceSelectResource::collection($provinces);
    }

    /**
     * The method handler request for datatable
     *
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        return DataTables::of(Province::query())
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
     * @param  ProvinceCreateRequest $request
     *
     * @return ProvinceResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProvinceCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $province = $this->repository->create($request->all());
            DB::commit();

            return ($this->show($province->id))->additional(['success' => true, 'message' => 'Province created.']);
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
     * @return ProvinceResource
     */
    public function show($id)
    {
        $province = $this->repository->with(['cities'])
            ->find($id);

        return new ProvinceResource($province);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProvinceUpdateRequest $request
     * @param  string            $id
     *
     * @return ProvinceResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProvinceUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $province = $this->repository->update($request->all(), $id);
            DB::commit();

            return ($this->show($province->id))->additional(['success' => true, 'message' => 'Province updated.']);
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
                'message' => 'Province deleted.'
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

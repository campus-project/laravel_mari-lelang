<?php

namespace App\Http\Controllers;

use App\Entities\City;
use App\Http\Resources\CityResource;
use App\Http\Resources\CitySelectResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CityCreateRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Repositories\CityRepository;
use App\Validators\CityValidator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class CitiesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CitiesController extends Controller
{
    /**
     * @var CityRepository
     */
    protected $repository;

    /**
     * @var CityValidator
     */
    protected $validator;

    /**
     * CitiesController constructor.
     *
     * @param CityRepository $repository
     * @param CityValidator $validator
     */
    public function __construct(CityRepository $repository, CityValidator $validator)
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
        return view('cities.index');
    }

    /**
     * The method handle request for select
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select(Request $request) {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $cities = $this->repository->paginate($request->per_page);

        return CitySelectResource::collection($cities);
    }

    /**
     * The method handler request for datatable
     *
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        return DataTables::of(City::with('province'))
            ->addIndexColumn()
            ->addColumn('province', function($row) {
                return $row->province->name;
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
            })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CityCreateRequest $request
     *
     * @return CityResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CityCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $city = $this->repository->create($request->all());
            DB::commit();

            return ($this->show($city->id))->additional(['success' => true, 'message' => 'City created.']);
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
     * @return CityResource
     */
    public function show($id)
    {
        $productType = $this->repository->with(['province'])
            ->find($id);

        return new CityResource($productType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CityUpdateRequest $request
     * @param  string            $id
     *
     * @return CityResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CityUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $city = $this->repository->update($request->all(), $id);
            DB::commit();

            return ($this->show($city->id))->additional(['success' => true, 'message' => 'City updated.']);
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
                'message' => 'City deleted.'
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

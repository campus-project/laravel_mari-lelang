<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductTypeRepository;
use App\Entities\ProductType;
use App\Validators\ProductTypeValidator;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ProductTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductTypeRepositoryEloquent extends BaseRepository implements ProductTypeRepository
{
    use CacheableRepository;

    /**
     * The variabel use for define searchable column
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProductTypeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

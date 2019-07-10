<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AuctionProductRepository;
use App\Entities\AuctionProduct;
use App\Validators\AuctionProductValidator;

/**
 * Class AuctionProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AuctionProductRepositoryEloquent extends BaseRepository implements AuctionProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AuctionProduct::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AuctionProductValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

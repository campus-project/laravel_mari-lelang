<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AuctionProductPhotoRepository;
use App\Entities\AuctionProductPhoto;
use App\Validators\AuctionProductPhotoValidator;

/**
 * Class AuctionProductPhotoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AuctionProductPhotoRepositoryEloquent extends BaseRepository implements AuctionProductPhotoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AuctionProductPhoto::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AuctionProductPhotoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

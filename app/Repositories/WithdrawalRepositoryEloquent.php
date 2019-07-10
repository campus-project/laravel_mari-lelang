<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WithdrawalRepository;
use App\Entities\Withdrawal;
use App\Validators\WithdrawalValidator;

/**
 * Class WithdrawalRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WithdrawalRepositoryEloquent extends BaseRepository implements WithdrawalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Withdrawal::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return WithdrawalValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

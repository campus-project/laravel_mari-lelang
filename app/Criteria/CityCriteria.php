<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CityCriteria.
 *
 * @package namespace App\Criteria;
 */
class CityCriteria implements CriteriaInterface
{
    protected $province;

    public function __construct($province=null){
        $this->province = $province;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = empty($this->province) ? $model->where('id', 0) : $model->where('province_id', $this->province);

        return $model;
    }
}

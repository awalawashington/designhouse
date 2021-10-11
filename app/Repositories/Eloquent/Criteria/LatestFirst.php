<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\InterfaceCriterion;


class LatestFirst implements InterfaceCriterion
{
    public function apply($model){
        return $model->latest();
    }
}
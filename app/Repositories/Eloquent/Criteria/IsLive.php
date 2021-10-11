<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\InterfaceCriterion;


class IsLive implements InterfaceCriterion
{
    public function apply($model){
        return $model->where('is_live', true);
    }
}
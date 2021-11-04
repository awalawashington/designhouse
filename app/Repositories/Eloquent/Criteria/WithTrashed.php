<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\InterfaceCriterion;


class WithTrashed implements InterfaceCriterion
{
    public function apply($model){
        return $model->withTrashed();
    }
}
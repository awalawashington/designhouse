<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\InterfaceCriterion;


class EagerLoad implements InterfaceCriterion
{
    protected $relationships;

    public function __construct($relationships)
    {
        $this->relationships = $relationships;
    }

    public function apply($model){
        return $model->with($this->relationships);
    }
}
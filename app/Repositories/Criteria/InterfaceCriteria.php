<?php

namespace App\Repositories\Criteria;


interface InterfaceCriteria
{
    public function withCriteria(... $criteria);
}
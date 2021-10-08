<?php

namespace App\Repositories\Eloquent;

use App\Models\Models\Design;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\DesignInterface;

class DesignRepository extends BaseRepository implements DesignInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\Design'
        return Design::class;
    }
}
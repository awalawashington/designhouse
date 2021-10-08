<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserInterface;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\User'
        return User::class;
    }
}
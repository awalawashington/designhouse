<?php

namespace App\Repositories\Eloquent;

use App\Models\Models\Team;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\TeamInterface;

class TeamRepository extends BaseRepository implements TeamInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\Team'
        return Team::class;
    }

    public function fetchUserTeams(){
        $teams = auth()->user()->teams();
    }

}
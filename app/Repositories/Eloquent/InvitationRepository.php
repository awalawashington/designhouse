<?php

namespace App\Repositories\Eloquent;

use App\Models\Models\Invitation;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\InvitationInterface;

class InvitationRepository extends BaseRepository implements InvitationInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\Invitation'
        return Invitation::class;
    }

    public function addUserToTeam($team, $user_id){
        $team->members()->attach($user_id);
    }

    public function removeUserFromTeam($team, $user_id){
        $team->members()->detach($user_id);
    }


}
<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Repositories\Contracts\TeamInterface;
use App\Repositories\Contracts\UserInterface;
use App\Repositories\Contracts\InvitationInterface;

class TeamsController extends Controller
{
    protected $teams;
    protected $users;
    protected $invitations;

    public function __construct(TeamInterface $teams, UserInterface $users, InvitationInterface $invitations)
    {
        $this->teams = $teams;
        $this->users = $users;
        $this->invitations = $invitations;
        
    }

    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:80', 'unique:teams,name']
        ]);

        //create team in database
        $team = $this->teams->create([
            'owner_id' => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return new TeamResource($team);
    }

    public function update(Request $request, $id)
    {
        $team = $this->teams->find($id);
        $this->authorize('update', $team);

        $this->validate($request,[
            'name' => ['required', 'string', 'max:80', 'unique:teams,name,'.$id]       
        ]);

        //update team
        $this->teams->update($id, [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        $team = $team->refresh();

        return new TeamResource($team);
        
    }

    public function findById($id)
    {
        $team = $this->teams->find($id);
        return new TeamResource($team);
    }

    public function fetchUserTeams()
    {
        $teams = $this->teams->fetchUserTeams();
        return TeamResource::collection($teams);
    }

    public function findBySlug($slug)
    {
        $team = $this->teams->findWhereFirst('slug', $slug);
        return new TeamResource($team);
    }

    public function destroy($id)
    {
        $team = $this->teams->find($id);
        $this->authorize('delete', $team);

        $this->teams->delete($id);

        return response()->json(['message' => 'Team deleted'], 200);

    }

    public function removeFromTeam($teamId, $userId)
    {
        //get the team
        $team = $this->teams->find($teamId);
        $user = $this->users->find($userId);

        //check that the user is not the owner
        if ($user->isOwnerOfTeam($team)) {
            return response()->json(['message' => 'You are the team owner'], 401);
        }

        //check that the request senedr is the owner of the team or the person who wants to leave the team
        if (!auth()->user()->isOwnerOfTeam($team) && auth()->id() !== $user->id) {
            return response()->json(['message' => 'You cannot do this'], 401);
        }

        $this->invitations->removeUserFromTeam($team, $userId);
        return response()->json(['message' => 'Success'], 200);
    }
}

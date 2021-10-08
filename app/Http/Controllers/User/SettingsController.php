<?php

namespace App\Http\Controllers\User;


use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Rules\CheckSamePassword;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class SettingsController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $this->validate($request,[
            "name" => 'required',
            "tagline" => 'required',
            "about" => 'required|string|min:20',
            "formatted_address" => 'required',
            "location.latitude" => 'required|numeric|min:-90|max:90',
            "location.longitude" => 'required|numeric|min:-180|max:180'
            ]);

        $location = new Point($request->location['latitude'], $request->location['longitude']);

        $user->update([
            "name" => $request->name,
            "tagline" => $request->tagline,
            "about" => $request->about,
            "formatted_address" => $request->formatted_address,
            "available_to_hire" => $request->available_to_hire,
            "location" => $location
        ]);

        return new UserResource($user);

    }

    public function updatePassword(Request $request)
    {
        
        //current password
        //new password
        //password confirmation
        
        $this->validate($request,[
            'current_password' => ['required',new MatchOldPassword],
            'password' => ['required', 'string', 'min:8', 'confirmed', new CheckSamePassword]
            ]);

            $request->user()->update([
                "password" => bcrypt($request->password) 
            ]);

            return response()->json(
                ['message' => 'Password successfully updated'], 200
            );

    }

    
}

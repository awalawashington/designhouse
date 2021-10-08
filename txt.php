<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class Profile_editController extends Controller
{
    public function index($id)
    {
        if (! (Gate::allows('is_admin')) && ! ($id == auth()->user()->id)) {
            abort(403);
        }
        $profile = User::findOrFail($id);
        return view('users.profile_edit', ['profile' => $profile]);
    }

    public function update($id)
    {
        return "string
    }

    public function destroy()
    {
        
    }
}

url("/posts/{$post->id}")

/edit_user/{{$profile->id}} XXXXX

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

<form method="POST" action="{{ url('/reset_password_without_token') }}">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

Nationality drop down
Address Drop down
Activation Badge
User can add more photos

public function country()
    {
        return $this->belongsTo(Country::class, 'nationality', 'id');
    }

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            https://youtu.be/rZvxRQmnw18       collections

            https://youtu.be/7i1epKxxbd8

            https://youtu.be/X_lwGduaLM4

            <div class="col">
                            <div class="form-group">
                              <label>Nationality</label>
                              <select class="form-control" id="exampleFormControlSelect1" name="nationality">
                                @foreach($countries as $key => $country)
                                  <option value="">{{$country['name']}}</option>
                                @endforeach
                              </select>
                              @error('nationality')
                                  <small class="text-danger">{{ $message }}</small>
                              @enderror
                            </div>
                          </div>




/edit_user/{{$profile->id}}


$visitorTraffic = PageView::select('id', 'title', 'created_at')
    ->get()
    ->groupBy(function($date) {
        return Carbon::parse($date->created_at)->format('Y'); // grouping by years
        //return Carbon::parse($date->created_at)->format('m'); // grouping by months
    });
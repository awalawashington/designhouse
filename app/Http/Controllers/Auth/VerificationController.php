<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;
use App\Repositories\Contracts\UserInterface;
//use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $users;

    public function __construct(UserInterface $users)
    {
        //$this->middleware('signed')->only('verify');
        $this->users = $users;
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user)
    {
        //check if url is a valid signature url
        if (! URL::hasValidSignature($request) ) {
            return response()->json([
                'errors' => ['message' => 'Invalid verification link']
            ], 422);
        }

        //check if user has already verified account
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'errors' => ['message' => 'Email has already verified']
            ], 422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json([
            'message' => 'Email Succesfully Verified'
        ], 200);

    }

    public function resend(Request $request)
    {
        $this->validate($request, [
            ['email', ['email' => 'required']]
        ]);

        $user = $this->users->findWhereFirst('email', $request->email);
        if (!$user) {
            return response()->json(['errors' => [
                'email' => 'no user could be found with this email'
            ]], 422);
        }

        //check if user has already verified account
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'errors' => ['message' => 'Email has already verified']
            ], 422);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification link resent']);
    }


}

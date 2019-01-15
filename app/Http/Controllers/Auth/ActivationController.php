<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    public function activate(Request $request)
    {
        $user = User::byActivationColumns($request->email, $request->verifyToken)->firstOrFail();

        $user->update([
            'status' => true,
            'verifyToken' => null
        ]);

        Auth::loginUsingId($user->id);

        if(Auth::user()->isSeeker()){
            $user->update(['ava' => 'seeker.png']);
            $user->seekers()->create(['user_id' => $user->id]);

            return back()->with('activated', 'You`re now signed in as Job Seeker.');

        } elseif (Auth::user()->isAgency()) {
            $user->update(['ava' => 'agency.png']);
            $user->agencies()->create(['user_id' => $user->id]);

            return back()->with('activated', 'You`re now signed in as Job Agency.');
        }
    }
}

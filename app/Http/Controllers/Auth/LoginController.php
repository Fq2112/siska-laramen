<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Perform login process for seekers and agencies
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
            Rule::exists('users')->where(function ($query) {
                $query->where('status', true);
            })
        ]);

        $request->remember = (is_null($request->remember)) ? false : $request->remember;

        try {
            $user = User::where('email',$request->email)->firstOrFail();

            if(!Hash::check($request->password, $user->password)) {
                return back()->with([
                    'error' => 'Your email or password is incorrect.'
                ]);
            }
            if($user->status == false){
                return back()->with([
                    'error' => 'Your account has not been activated! Please activate first.'
                ]);
            }

            $request->session()->regenerate();
            Auth::login($user);

            if(Auth::user()->isRoot()){
                return back()->with('signed', 'You`re now signed in as Root.');
            }
            if(Auth::user()->isAdmin()){
                return back()->with('signed', 'You`re now signed in as Admin.');
            }
            if(Auth::user()->isSeeker()){
                return back()->with('signed', 'You`re now signed in as Job Seeker.');
            }
            if(Auth::user()->isAgency()){
                return back()->with('signed', 'You`re now signed in as Job Agency.');
            }
        }
        catch (ModelNotFoundException $e) {
            return back()->with([
                'error' => 'Your email or password is incorrect.'
            ]);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if(Auth::guard('web')->check()){
            $request->session()->invalidate();
            Auth::guard('web')->logout();

            return redirect()->route('home-seeker')->with('logout', 'You`re now signed out.');
        }
    }
}
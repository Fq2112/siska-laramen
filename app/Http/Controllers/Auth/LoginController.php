<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Support\Facades\GlobalAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectTo()
    {
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->isInterviewer()) {
                return redirect()->route('dashboard.interviewer')->with('signed', 'You`re now signed in.');
            } else {
                return redirect()->route('home-admin')->with('signed', 'You`re now signed in.');
            }
        }

        return back()->with('signed', 'You`re now signed in.');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest:admin', 'guest:web'])->except('logout');
    }

    /**
     * Perform login process for users & admins
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        if (GlobalAuth::login(['email' => $request->email, 'password' => $request->password])) {
            if (session()->has('intended')) {
//                $this->redirectTo = session('intended');
                session()->forget('intended');
            }

            return $this->redirectTo();
        }

        return back()->withInput(Input::all())->with([
            'error' => 'Your email or password is incorrect.'
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();

        GlobalAuth::logout();

        return redirect()->route('home-seeker')->with('logout', 'You`re now signed out.');
    }
}
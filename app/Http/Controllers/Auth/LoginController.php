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
     * @var string
     */
    protected $redirectTo = '/';

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
                $this->redirectTo = session('intended');
                session()->forget('intended');
            }
            if (Auth::user()->isRoot()) {
                return back()->with('signed', 'You`re now signed in as Root.');
            }
            if (Auth::user()->isAdmin()) {
                return back()->with('signed', 'You`re now signed in as Admin.');
            }
            if (Auth::user()->isSeeker()) {
                return back()->with('signed', 'You`re now signed in as Job Seeker.');
            }
            if (Auth::user()->isAgency()) {
                return back()->with('signed', 'You`re now signed in as Job Agency.');
            }
        }

        return back()->withInput(Input::all())->with([
            'error' => 'Your email or password is incorrect.'
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        GlobalAuth::logout();

        return redirect()->route('home-seeker')->with('logout', 'You`re now signed out.');
    }
}
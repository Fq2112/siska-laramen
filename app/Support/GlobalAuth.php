<?php
/**
 * Created by PhpStorm.
 * User: fiqy_
 * Date: 10/1/2018
 * Time: 8:38 PM
 */

namespace App\Support;

use App\Admin;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class GlobalAuth
{
    /**
     * login process
     *
     * @param array $credentials
     * @return boolean
     */
    public function login($credentials)
    {
        if ($this->isUser($credentials['email'])) {
            $user = User::where('email', $credentials['email'])->first();
            if ($user->status == false) {
                return back()->withInput(Input::all())->with([
                    'inactive' => 'Your account has not been activated! Please activate first.'
                ]);
            } else {
                $guard = 'web';
            }
        } else if ($this->isAdmin($credentials['email'])) {
            $guard = 'admin';
        } else {
            return false;
        }

        if (Auth::guard($guard)->attempt($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * logout process
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard($this->getAttemptedGuard())->logout();
    }

    /**
     * Check whether one of the guard is login
     *
     * @return boolean
     */
    public function check()
    {
        $guard = $this->getAttemptedGuard();
        return !is_null($guard);
    }

    /**
     * get user who's logged in from one of the guard
     *
     * @return \App\User|\App\Admin
     */
    public function user()
    {
        if ($this->getAttemptedGuard() === 'admin')
            return Auth::guard('admin')->user();
        return Auth::guard('web')->user();
    }

    /**
     * get guard who's logged in as a string
     *
     * @return string|null
     */
    public function getAttemptedGuard()
    {
        if (Auth::guard('web')->check()) {
            return 'web';
        }
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }
        return null;
    }

    /**
     * Check whether the intended email was found in the user table
     *
     * @param string $email
     * @return boolean
     */
    private function isUser($email)
    {
        return !is_null(User::where('email', $email)->first());
    }

    /**
     * Check whether the intended email was found in the admin table
     *
     * @param [type] $email
     * @return boolean
     */
    private function isAdmin($email)
    {
        return !is_null(Admin::where('email', $email)->first());
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        if ($this->isUser($request->email)) {
            $resetter = 'users';

        } elseif ($this->isAdmin($request->email)) {
            $resetter = 'admins';

        } else {
            return back()->with('resetLink_failed', 'We can\'t find a user with that e-mail address.');
        }

        $response = $this->broker($resetter)->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return back()->with('resetLink', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->with('resetLink_failed', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @param string $resetter
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker($resetter)
    {
        return Password::broker($resetter);
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
     * @param string $email
     * @return boolean
     */
    private function isAdmin($email)
    {
        return !is_null(Admin::where('email', $email)->first());
    }
}

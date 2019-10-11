<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\PartnerCredential;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return back()->with('reset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset the given user's password.
     *
     * @param string $resetter
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        if ($this->isUser($request->email)) {
            $guard = 'web';
            $resetter = 'users';

        } elseif ($this->isAdmin($request->email)) {
            $guard = 'admin';
            $resetter = 'admins';

        } else {
            return back()->withInput($request->all())
                ->with('recover_failed', 'We can\'t find a user with that e-mail address.');
        }

        $response = $this->broker($resetter)->reset(
            $this->credentials($request), function ($user, $password) use ($guard) {
            $this->resetPassword($user, $password, $guard);
        }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     * @param string $guard
     * @return void
     */
    protected function resetPassword($user, $password, $guard)
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        if ($guard == 'web') {
            $findUser = User::find($user->id);
            if ($findUser->isSeeker()) {
                $data = array('email' => $findUser->email, 'password' => $findUser->password);
                $this->updatePartners($data, 'password');
            }
        }

        $this->guard($guard)->logout();
    }

    /**
     *
     * Reset seeker's password for SiskaLTE.
     * @param array $data
     * @param string $check
     * @return void
     */
    private function updatePartners($data, $check)
    {
        $partners = PartnerCredential::where('status', true)->where('isSync', true)
            ->whereDate('api_expiry', '>=', today())->get();

        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $client = new Client([
                    'base_uri' => $partner->uri,
                    'defaults' => [
                        'exceptions' => false
                    ]
                ]);

                try {
                    $client->put($partner->uri . '/api/SISKA/seekers/update', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'check_form' => $check,
                            'seeker' => $data,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }
        }
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        return back()->with('recovered', trans($response) . ' Please, sign in with your new password.');
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->all())
            ->with('recover_failed', trans($response));
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
     * Get the guard to be used during password reset.
     *
     * @param string $guard
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard($guard)
    {
        return Auth::guard($guard);
    }
}

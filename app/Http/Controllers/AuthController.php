<?php

namespace App\Http\Controllers;

use App\Accepting;
use App\Seekers;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Sodium\crypto_box_seed_keypair;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verifyUser', 'recover']]);
    }

    /**
     * Register API With JWT
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $name = $obj['name'];
        $email = $obj['email'];
        $password = $obj['password'];
        $repassword = $obj['repassword'];
//
//        if($validator->fails()) {
//            return response()->json([
//                'status' => 'warning',
//                'success'=> false,
//                'error'=> $validator->messages()]);
//        }

        if ($name == null || $email == null || $password == null || $repassword == null) { //check All input not null
            return response()->json([
                'status' => 'warning',
                'success' => false,
                'error' => 'Some input is not filled yet!!'
            ]);
        } else {
            $check = User::where('email', $email)->count();
            if ($check < 1) {// check email is available

                if ($password != $repassword) {//check Password Match or not wit repassword
                    return response()->json([
                        'status' => 'warning',
                        'success' => false,
                        'error' => 'Password doesn\'t match!!'
                    ]);
                } else {
                    $user = User::create([
                        'ava' => 'seeker.png',
                        'name' => $name,
                        'email' => $email,
                        'password' => bcrypt($password),
                        'role' => 'seeker',
                        'status' => false,
                        'verifyToken' => Str::random(255),
                    ]);

                    //$verification_code = str_random(30); //Generate verification code

                    //DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);

                    $subject = "Please verify your email address.";
                    Mail::send('emails.auth.verify', ['name' => $name, 'email' => $user->email, 'verification_code' => $user->verifyToken],
                        function ($mail) use ($email, $name, $subject) {
                            $mail->from(getenv('Ilham Saputra'), "ilham.puji100@gmail.com");
                            $mail->to($email, $name);
                            $mail->subject($subject);
                        });
                    return response()->json([
                        'status' => 'success',
                        'success' => true,
                        'message' => 'Thanks for signing up! Please check your email to complete your registration.']);
                }

            } else {
                return response()->json([
                    'status' => 'warning',
                    'success' => false,
                    'error' => 'Email already taken!!!'
                ]);
            }
        }
    }

    /**
     * Verify Token user
     *
     * @param $verification_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser($verification_code)
    {
        //$check = DB::table('user_verifications')->where('token',$verification_code)->first();
        $check = User::where('verifyToken', $verification_code)->first();
        if (!is_null($check)) {
            $user = User::find($check->id);
            if ($user->status == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account already verified..'
                ]);
            }
            $user->update([
                'status' => true,
                'verifyToken' => null
            ]);
            Seekers::create([
                'user_id' => $user->id
            ]);
            //DB::table('user_verifications')->where('token',$verification_code)->delete();
            return response()->json([
                'success' => true,
                'message' => 'You have successfully verified your email address.'
            ]);
        }
        return response()->json(['success' => false, 'error' => "Verification code is invalid."]);
    }

    /**
     * Login With JWT API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $email = $obj['email'];
        $password = $obj['password'];

        if ($email == null || $password == null) {
            return response()->json([
                'status' => 'warning',
                'success' => false,
                'error' => 'Data not filled yet!!'
            ]);
        }

        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 401);
        }

        $credentials['status'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'],
                    404);
            }

//            if ( $token = $this->guard()->attempt($credentials)) {
//                return $this->respondWithToken($token);
//            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return $this->respondWithToken($token);
    }

    /**
     *  Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message' => "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }


    /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email' => $error_message]], 401);
        }
        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Your Password Reset Link');
            });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'data' => ['message' => 'A reset email has been sent! Please check your email.']
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Get Current User
     *
     * @return mixed
     */
    public function seeker($user_id)
    {
        $seeker = Seekers::where('user_id', $user_id)->get();
        return $seeker;
    }

    /**
     * Create Apply in Accepting table
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiApply()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $vacancy_id = $obj['vacancy_id'];
        $seeker = $this->seeker(Auth::user()->id);

        $check = Accepting::where('vacancy_id', $vacancy_id)
            ->where('seeker_id', $seeker->id);

        if ($check->count() > 1) {
            return response()->json([
                'status' => 'warning',
                'success' => false,
                'error' => 'Already applied!!'
            ]);
        } else {
            Accepting::create([
                'seeker_id' => $seeker->id,
                'vacancy_id' => $vacancy_id,
                'isApply' => true,
            ]);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'error' => 'Vacancy is successfully applied!!'
            ]);
        }
    }

    /**
     * Abort Vacancy
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiAbortApply()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json,false);

        $vacancy_id = $obj['vacancy_id'];
        $seeker = $this->seeker(Auth::user()->id);

        $vacancy = Accepting::where('seeker_id',$seeker->id)->where('vacancy_id',$vacancy_id)->first();
        $vacancy->delete();

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Vacancy is successfully aborted!!'
        ]);
    }

    /**
     * Bookmark vacancy
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiBookmark()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $vacancy_id = $obj['vacancy_id'];
        $seeker = $this->seeker(Auth::user()->id);

        $check = Accepting::where('vacancy_id', $vacancy_id)
            ->where('seeker_id', $seeker->id)->first();

        if ($check->count() > 1) {
            if ($check->isApply == true) {
                $check->update([
                    'isBookmark' => false
                ]);
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'error' => 'Bookmarks successfully remove!!'
                ]);
            } elseif ($check->isApply == false) {
                $check->delete();
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'error' => 'Bookmarks successfully remove!!'
                ]);
            }

        } else {
            Accepting::create([
                'seeker_id' => $seeker->id,
                'vacancy_id' => $vacancy_id,
                'isBookmark' => true,
            ]);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'error' => 'Vacancy is successfully applied!!'
            ]);
        }
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

}

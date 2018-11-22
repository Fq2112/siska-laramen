<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','verifyUser','recover']]);
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
        $obj = json_decode($json,true);

        $name = $obj['name'];
        $email =  $obj['email'];
        $password = $obj['password'];
        $repassword = $obj['repassword'];
//
//        if($validator->fails()) {
//            return response()->json([
//                'status' => 'warning',
//                'success'=> false,
//                'error'=> $validator->messages()]);
//        }

        if($name == null || $email == null || $password == null || $repassword ==null){ //check All input not null
            return response()->json([
                'status' => 'warning',
                'success' => false,
                'error' => 'Some input is not filled yet!!'
            ]);
        }else {
            $check = User::where('email',$email)->count();
            if ($check < 1) {// check email is available

                if($password != $repassword){//check Password Match or not wit repassword
                    return response()->json([
                        'status' => 'warning',
                        'success' => false,
                        'error' => 'Password doesn\'t match!!'
                    ]);
                }
                else {
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

            }else {
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
        $check = User::where('verifyToken',$verification_code)->first();
        if(!is_null($check)){
            $user = User::find($check->id);
            if($user->status == 1){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Account already verified..'
                ]);
            }
            $user->update([
                'status' => true,
                'verifyToken' => null
            ]);
            //DB::table('user_verifications')->where('token',$verification_code)->delete();
            return response()->json([
                'success'=> true,
                'message'=> 'You have successfully verified your email address.'
            ]);
        }
        return response()->json(['success'=> false, 'error'=> "Verification code is invalid."]);
    }

    /**
     * Login With JWT API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 401);
        }

        $credentials['status'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
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
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
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
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
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
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
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

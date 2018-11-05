<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {

        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $username = $obj['username'];
        $email =  $obj['email'];
        $password = $obj['password'];
        $repassword = $obj['repassword'];

        $check = User::where('email',$email)->count();
        if ($check<1) {
            if($password != $repassword)
            {
//                echo json_encode("Password Doesn't Match!!!");
                return response()->json([
                    'status' => 'Warning',
                    'message' => 'Password Doesn\'t Match!!'
                ]);
            }
            else {
                $user = new User([
                    'name' => $username,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'role' => 'seeker',
                    'status' => false,
                    'verifyToken' => Str::random(255),
                ]);

                $user->save();
//                echo json_encode("User Successfully Created");
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Successfully created user!'
                ], 201);
            }
        }
        else
//           echo json_encode("Email Already Taken!!!");
        return response()->json([
           'status' => 'Warning',
            'message' => 'Email Already Taken!!'
        ]);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
//        dd($request);
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);}
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}

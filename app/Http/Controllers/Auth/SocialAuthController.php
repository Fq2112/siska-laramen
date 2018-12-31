<?php

namespace App\Http\Controllers\Auth;

use App\PartnerCredential;
use App\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;

class SocialAuthController extends Controller
{

    /**
     * Redirect the user to the social providers authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from each Social Provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $userSocial = Socialite::driver($provider)->user();

            $checkUser = User::where('email', $userSocial->email)->first();

            if (!$checkUser) {
                Storage::disk('local')
                    ->put('public/users/' . $userSocial->getId() . ".jpg", file_get_contents($userSocial->getAvatar()));

                $user = User::firstOrCreate([
                    'ava' => $userSocial->getId() . ".jpg",
                    'email' => $userSocial->getEmail(),
                    'name' => $userSocial->getName(),
                    'password' => bcrypt(str_random(15)),
                    'status' => true,
                    'role' => 'seeker'
                ]);

                $user->seekers()->create(['user_id' => $user->id]);

                $user->socialProviders()->create([
                    'provider_id' => $userSocial->getId(),
                    'provider' => $provider
                ]);

                Auth::loginUsingId($user->id);

            } else {
                $user = $checkUser;
            }

            if ($user->ava == "seeker.png" || $user->ava == "") {
                Storage::disk('local')
                    ->put('public/users/' . $userSocial->getId() . ".jpg", file_get_contents($userSocial->getAvatar()));

                $user->update(['ava' => $userSocial->getId() . ".jpg"]);
            }

            if ($user->isSeeker()) {
                $data = array('name' => $user->name, 'email' => $user->email, 'password' => $user->password,
                    'provider_id' => $userSocial->getId());
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
                        $client->post($partner->uri . '/api/SISKA/seekers/' . $provider, [
                            'form_params' => [
                                'key' => $partner->api_key,
                                'secret' => $partner->api_secret,
                                'seeker' => $data,
                            ]
                        ]);
                    }
                }
            }

            Auth::loginUsingId($user->id);

            return redirect()->route('home-seeker')->with('signed', 'You`re now signed in as a Job Seeker.');

        } catch (\Exception $e) {
            return back()->with('unknown', 'Please, login/register with SISKA account.');
        }
    }
}

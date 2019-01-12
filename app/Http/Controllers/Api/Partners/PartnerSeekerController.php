<?php

namespace App\Http\Controllers\Api\Partners;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerSeekerController extends Controller
{
    public function createSeekers(Request $request)
    {
        $data = $request->seeker;
        $checkSeeker = User::where('email', $data['email'])->first();
        if (!$checkSeeker) {
            $user = User::firstOrCreate([
                'ava' => 'seeker.png',
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'seeker',
                'status' => true
            ]);

            $user->seekers()->create(['user_id' => $user->id]);
        }
    }

    public function seekersSocialite($provider, Request $request)
    {
        $data = $request->seeker;
        $checkSeeker = User::where('email', $data['email'])->first();
        if (!$checkSeeker) {
            $user = User::firstOrCreate([
                'ava' => 'seeker.png',
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'seeker',
                'status' => true
            ]);

            $user->seekers()->create(['user_id' => $user->id]);

            $user->socialProviders()->create([
                'provider_id' => $data['provider_id'],
                'provider' => $provider
            ]);
        }
    }

    public function updateSeekers(Request $request)
    {
        $data = $request->seeker;
        $user = User::where('email', $data['email'])->first();

        if ($user != null) {
            if ($request->check_form == 'password') {
                $user->update(['password' => $data['password']]);

            } elseif ($request->check_form == 'contact') {
                $user->seekers->update([
                    'phone' => $data['input']['phone'],
                    'address' => $data['input']['address'],
                    'zip_code' => $data['input']['zip_code'],
                ]);

            } elseif ($request->check_form == 'personal') {
                $user->update(['name' => $data['input']['name']]);
                $user->seekers->update([
                    'birthday' => $data['input']['birthday'],
                    'gender' => $data['input']['gender'],
                    'relationship' => $data['input']['relationship'],
                    'nationality' => $data['input']['nationality'],
                    'website' => $data['input']['website'],
                    'lowest_salary' => str_replace(',', '', $data['input']['lowest']),
                    'highest_salary' => str_replace(',', '', $data['input']['highest']),
                ]);

            } elseif ($request->check_form == 'summary') {
                $user->seekers->update(['summary' => $data['summary']]);
            }
        }
    }

    public function deleteSeekers(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $user->forceDelete();
        }
    }
}

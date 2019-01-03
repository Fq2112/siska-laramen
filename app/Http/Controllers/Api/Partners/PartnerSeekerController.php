<?php

namespace App\Http\Controllers\Api\Partners;

use App\PartnerCredential;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerSeekerController extends Controller
{
    public function updateSeekers(Request $request)
    {
        $data = $request->seeker;
        $user = User::where('email', $data['email'])->first();
        $partners = PartnerCredential::where('status', true)->where('isSync', true)
            ->whereDate('api_expiry', '>=', today())->where('id', '!=', $request->partner->id)->get();

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

            $this->updatePartners($partners, $data, $request->check_form);
        }
    }

    private function updatePartners($partners, $data, $check)
    {
        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $client = new Client([
                    'base_uri' => $partner->uri,
                    'defaults' => [
                        'exceptions' => false
                    ]
                ]);
                $client->put($partner->uri . '/api/SISKA/seekers/update', [
                    'form_params' => [
                        'key' => $partner->api_key,
                        'secret' => $partner->api_secret,
                        'check_form' => $check,
                        'seeker' => $data,
                    ]
                ]);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Seekers;

use App\PsychoTestInfo;
use App\Vacancies;
use Illuminate\Support\Facades\Auth;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use App\Http\Controllers\Controller;

class PsychoTestController extends Controller
{
    protected $sid;
    protected $token;
    protected $key;
    protected $secret;

    public function __construct()
    {
        $this->middleware('admin')->except('joinPsychoTestRoom');
        $this->middleware(['auth', 'seeker'])->only('joinPsychoTestRoom');

        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->key = config('services.twilio.key');
        $this->secret = config('services.twilio.secret');
    }

    public function joinPsychoTestRoom($roomName)
    {
        $psychoTest = PsychoTestInfo::where('room_code', $roomName)->first();
        $vacancy = $psychoTest->getVacancy;
        $userAgency = $vacancy->agencies->user;

        $identity = Auth::user()->email;

        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);

        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        $token->addGrant($videoGrant);

        return view('_seekers.psychoTest-room', ['accessToken' => $token->toJWT(), 'roomName' => $roomName,
            'vacancy' => $vacancy, 'userAgency' => $userAgency]);
    }
}

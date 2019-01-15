<?php

namespace App\Http\Controllers;

use App\Carousel;
use App\Feedback;
use App\PartnerCredential;
use App\Provinces;
use App\PsychoTestInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('interviewer')->only('dashboardInterviewer');
    }

    public function infoSISKA()
    {
        $provinces = Provinces::all();
        $carousels = Carousel::all();

        return view('info-siska', compact('provinces', 'carousels'));
    }

    public function postContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'string|min:3',
            'message' => 'required'
        ]);
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'bodymessage' => $request->message
        );
        Feedback::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['bodymessage']
        ]);
        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('jquinn211215@gmail.com');
            $message->subject($data['subject']);
        });

        return back()->with('contact', 'Thank you for leaving us a message! Because, every comment or criticism ' .
            'that you have sent, it will make us better.');
    }

    public function joinPartnership(Request $request)
    {
        $check = PartnerCredential::where('name', $request->name)->where('email', $request->email)->first();
        if ($check == null) {
            PartnerCredential::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'uri' => $request->uri,
            ]);

            return 0;

        } else {
            if ($check->api_expiry != null) {
                if (today() <= $check->api_expiry) {
                    return 1;

                } elseif (today() > $check->api_expiry) {
                    $check->update(['status' => false]);
                    return 2;
                }
            }
        }
        return 3;
    }

    public function dashboardInterviewer()
    {
        $infos = PsychoTestInfo::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('auth.interviewers.interviewer', compact('infos'));
    }
}

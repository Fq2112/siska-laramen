<?php

namespace App\Http\Controllers;

use App\Carousel;
use App\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
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
        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('jquinn211215@gmail.com');
            $message->subject($data['subject']);
        });
        return back()->with('contact', 'Thank you for leaving us a message! Because, every comment or criticism that you have sent, it will make us better.');
    }
}

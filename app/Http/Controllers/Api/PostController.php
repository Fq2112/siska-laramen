<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    public function feedback(Request $request)
    {

        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $message = $obj['message'];

       Feedback::create([
           'name' => 'ilham Puji',
           'email' => 'ilham.puji100@gmail.com',
           'subject' => 'testi',
           'message' => $message
       ]);

        echo  json_encode('Thanks for the feed');
    }

    public function test()
    {
        
    }
}

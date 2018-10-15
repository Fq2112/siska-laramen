<?php

namespace App\Http\Controllers\Admins;

use App\Accepting;
use App\Agencies;
use App\Blog;
use App\ConfirmAgency;
use App\Http\Controllers\Controller;
use App\Seekers;

class AdminController extends Controller
{
    public function index()
    {
        $newSeeker = Seekers::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newApp = Accepting::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        $newAgency = Agencies::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newJobPost = ConfirmAgency::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        $blogs = Blog::all();

        return view('_admins.home-admin', compact('newSeeker', 'newApp', 'newAgency', 'newJobPost', 'blogs'));
    }

    public function showInbox()
    {
        return view('_admins.inbox');
    }
}

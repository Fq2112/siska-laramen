<?php

namespace App\Http\Controllers\Admins;

use App\Accepting;
use App\Agencies;
use App\ConfirmAgency;
use App\Http\Controllers\Controller;
use App\Seekers;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();

        $newSeeker = Seekers::where('created_at', '>=', today()->subWeek()->toDateTimeString())->count();
        $newApp = Accepting::where('created_at', '>=', today()->subWeek()->toDateTimeString())->count();

        $newAgency = Agencies::where('created_at', '>=', today()->subWeek()->toDateTimeString())->count();
        $newJobPost = ConfirmAgency::where('created_at', '>=', today()->subWeek()->toDateTimeString())->count();

        return view('_admins.home-admin', compact('admin', 'newSeeker', 'newApp',
            'newAgency', 'newJobPost'));
    }

    public function showInbox()
    {
        $admin = Auth::guard('admin')->user();

        return view('_admins.inbox', compact('admin'));
    }
}

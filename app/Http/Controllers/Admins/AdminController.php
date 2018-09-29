<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
//        $this->middleware('admin');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();

        return view('_admins.home-admin', compact('admin'));
    }
}

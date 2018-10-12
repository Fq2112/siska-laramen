<?php

namespace App\Http\Controllers\Admins;

use App\Accepting;
use App\Agencies;
use App\ConfirmAgency;
use App\Http\Controllers\Controller;
use App\Seekers;
use App\User;
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

        $newSeeker = Seekers::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newApp = Accepting::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        $newAgency = Agencies::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newJobPost = ConfirmAgency::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        return view('_admins.home-admin', compact('admin', 'newSeeker', 'newApp',
            'newAgency', 'newJobPost'));
    }

    public function showInbox()
    {
        $admin = Auth::guard('admin')->user();

        return view('_admins.inbox', compact('admin'));
    }

    public function showUsersTable()
    {
        $admin = Auth::guard('admin')->user();

        return view('_admins.tables.users.user-table', compact('admin'));
    }

    public function detailUsers($id)
    {
        $admin = Auth::guard('admin')->user();
        $user = User::find($id);

        return view('_admins.tables.users.user-detail', compact('admin', 'user'));
    }

    public function deleteUsers($id)
    {
        $user = User::find(decrypt($id));
        $user->delete();

        return back()->with('delete', '' . $user->name . ' is successfully deleted!');
    }
}

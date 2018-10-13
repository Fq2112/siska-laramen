<?php

namespace App\Http\Controllers\Admins;

use App\Accepting;
use App\Admin;
use App\Agencies;
use App\ConfirmAgency;
use App\Http\Controllers\Controller;
use App\Industri;
use App\Jurusanpend;
use App\Seekers;
use App\Tingkatpend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $newSeeker = Seekers::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newApp = Accepting::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        $newAgency = Agencies::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newJobPost = ConfirmAgency::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        return view('_admins.home-admin', compact('newSeeker', 'newApp',
            'newAgency', 'newJobPost'));
    }

    public function showInbox()
    {
        return view('_admins.inbox');
    }

    public function showAdminsTable()
    {
        $admins = Admin::all();

        return view('_admins.tables.admin-table', compact('admins'));
    }

    public function detailAdmins($id)
    {
        $findAdmin = Admin::find($id);

        return view('_admins.details.user-detail', compact('findAdmin'));
    }

    public function createAdmins(Request $request)
    {
        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required'
        ]);

        if ($request->hasfile('ava')) {
            $name = $request->file('ava')->getClientOriginalName();
            $request->file('ava')->storeAs('public/admins', $name);

        } else {
            $name = 'avatar.png';
        }

        Admin::create([
            'ava' => $name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);
        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updateAdmins(Request $request)
    {
        $admin = Admin::find($request->id);
        $img = $request->file('ava');

        if ($img == null) {
            $this->validate($request, [
                'password' => 'required|string|min:6',
                'new_password' => 'required|string|min:6',
                'password_confirmation' => 'required|same:new_password',
            ]);

            if (!Hash::check($request->password, $admin->password)) {
                return back()->with('error', 'Your current password is incorrect!');

            } else {
                if ($request->new_password != $request->password_confirmation) {
                    return back()->with('error', 'Your password confirmation doesn\'t match!');

                } else {
                    $admin->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($request->new_password),
                        'role' => $request->role
                    ]);
                    return back()->with('success', '' . $admin->name . ' is successfully updated!');
                }
            }

        } else {
            $this->validate($request, [
                'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            ]);

            if ($request->hasFile('ava')) {
                $name = $img->getClientOriginalName();

                if ($admin->ava != '') {
                    Storage::delete('public/admins/' . $admin->ava);
                }

                if ($img->isValid()) {
                    $request->ava->storeAs('public/admins', $name);
                    $admin->update(['ava' => $name]);
                }
            }

            return back()->with('success', '' . $admin->name . '\'s ava is successfully updated!');
        }
    }

    public function deleteAdmins($id)
    {
        $admin = Admin::find(decrypt($id));
        if ($admin->ava != '') {
            Storage::delete('public/admins/' . $admin->ava);
        }
        $admin->forceDelete();

        return back()->with('success', '' . $admin->name . ' is successfully deleted!');
    }

    public function showUsersTable()
    {
        $users = User::all();

        return view('_admins.tables.user-table', compact('users'));
    }

    public function detailUsers($id)
    {
        $user = User::find($id);

        return view('_admins.details.user-detail', compact('user'));
    }

    public function deleteUsers($id)
    {
        $user = User::find(decrypt($id));
        $user->forceDelete();

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }

    public function showDegreesTable()
    {
        $degrees = Tingkatpend::all();

        return view('_admins.tables.degree-table', compact('degrees'));
    }

    public function createDegrees(Request $request)
    {
        Tingkatpend::create(['name' => $request->name]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updateDegrees(Request $request)
    {
        $degree = Tingkatpend::find($request->id);
        $degree->update(['name' => $request->name]);

        return back()->with('success', '' . $degree->name . ' is successfully updated!');
    }

    public function deleteDegrees($id)
    {
        $degree = Tingkatpend::find(decrypt($id));
        $degree->delete();

        return back()->with('success', '' . $degree->name . ' is successfully deleted!');
    }

    public function showMajorsTable()
    {
        $majors = Jurusanpend::all();

        return view('_admins.tables.major-table', compact('majors'));
    }

    public function createMajors(Request $request)
    {
        Jurusanpend::create(['name' => $request->name]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updateMajors(Request $request)
    {
        $major = Jurusanpend::find($request->id);
        $major->update(['name' => $request->name]);

        return back()->with('success', '' . $major->name . ' is successfully updated!');
    }

    public function deleteMajors($id)
    {
        $major = Jurusanpend::find(decrypt($id));
        $major->delete();

        return back()->with('success', '' . $major->name . ' is successfully deleted!');
    }

    public function showIndustriesTable()
    {
        $industries = Industri::all();

        return view('_admins.tables.industry-table', compact('industries'));
    }

    public function createIndustries(Request $request)
    {
        $this->validate($request, [
            'icon' => 'required|image|mimes:jpg,jpeg,gif,png,svg|max:200',
            'nama' => 'required|string|max:191',
        ]);

        $name = $request->file('icon')->getClientOriginalName();
        $request->file('icon')->move(public_path('images\industries'), $name);

        Industri::create([
            'icon' => $name,
            'nama' => $request->nama
        ]);

        return back()->with('success', '' . $request->nama . ' is successfully created!');
    }

    public function updateIndustries(Request $request)
    {
        $industry = Industri::find($request->id);

        $this->validate($request, [
            'icon' => 'image|mimes:jpg,jpeg,gif,png,svg|max:200',
            'nama' => 'required|string|max:191',
        ]);

        if ($request->hasfile('icon')) {
            $name = $request->file('icon')->getClientOriginalName();
            if ($industry->icon != '') {
                unlink(public_path('images\industries/' . $industry->icon));
            }
            $request->file('icon')->move(public_path('images\industries'), $name);

        } else {
            $name = $industry->icon;
        }

        $industry->update([
            'icon' => $name,
            'nama' => $request->nama
        ]);

        return back()->with('success', '' . $industry->nama . ' is successfully updated!');
    }

    public function deleteIndustries($id)
    {
        $industry = Industri::find(decrypt($id));
        if ($industry->icon != '') {
            unlink(public_path('images\industries/' . $industry->icon));
        }
        $industry->delete();

        return back()->with('success', '' . $industry->nama . ' is successfully deleted!');
    }
}

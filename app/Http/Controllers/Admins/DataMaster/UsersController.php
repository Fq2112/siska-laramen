<?php

namespace App\Http\Controllers\Admins\DataMaster;

use App\Agencies;
use App\Seekers;
use App\User;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function showAdminsTable()
    {
        $admins = Admin::all();

        return view('_admins.tables.users.admin-table', compact('admins'));
    }

    public function detailAdmins($id)
    {
        $findAdmin = Admin::find($id);

        return view('_admins.details.admin-detail', compact('findAdmin'));
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

        return view('_admins.tables.users.user-table', compact('users'));
    }

    public function deleteUsers($id)
    {
        $user = User::find(decrypt($id));
        $user->forceDelete();

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }

    public function showAgenciesTable()
    {
        $agencies = Agencies::all();

        return view('_admins.tables.users.agency-table', compact('agencies'));
    }

    public function deleteAgencies($id)
    {
        $agency = Agencies::find(decrypt($id));
        $user = User::find($agency->user_id);
        $user->forceDelete();

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }

    public function showSeekersTable()
    {
        $seekers = Seekers::all();

        return view('_admins.tables.users.seeker-table', compact('seekers'));
    }

    public function deleteSeekers($id)
    {
        $seeker = Seekers::find(decrypt($id));
        $user = User::find($seeker->user_id);
        $user->forceDelete();

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }
}

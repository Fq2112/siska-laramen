<?php

namespace App\Http\Controllers\Admins\DataMaster;

use App\Agencies;
use App\PartnerCredential;
use App\Seekers;
use App\User;
use App\Admin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    public function showAdminsTable()
    {
        $admins = Admin::all();

        return view('_admins.tables.accounts.admin-table', compact('admins'));
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

    public function updateProfileAdmins(Request $request)
    {
        $admin = Admin::find($request->id);
        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);
        if ($request->hasFile('ava')) {
            $name = $request->file('ava')->getClientOriginalName();
            if ($admin->ava != '' || $admin->ava != 'avatar.png') {
                Storage::delete('public/admins/' . $admin->ava);
            }
            $request->file('ava')->storeAs('public/admins', $name);

        } else {
            $name = $admin->ava;
        }
        $admin->update([
            'ava' => $name,
            'name' => $request->name
        ]);

        return back()->with('success', 'Successfully update ' . $admin->name . '\'s profile!');
    }

    public function updateAccountAdmins(Request $request)
    {
        $admin = Admin::find($request->id);

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', '' . $admin->name . '\'s current password is incorrect!');

        } else {
            if ($request->new_password != $request->password_confirmation) {
                return back()->with('error', '' . $admin->name . '\'s password confirmation doesn\'t match!');

            } else {
                $admin->update([
                    'email' => $request->email,
                    'password' => bcrypt($request->new_password),
                    'role' => $request->role == null ? 'root' : $request->role
                ]);
                return back()->with('success', 'Successfully update ' . $admin->name . '\'s account!');
            }
        }
    }

    public function deleteAdmins($id)
    {
        $admin = Admin::find(decrypt($id));
        if ($admin->ava != '' || $admin->ava != 'avatar.png') {
            Storage::delete('public/admins/' . $admin->ava);
        }
        $admin->forceDelete();

        return back()->with('success', '' . $admin->name . ' is successfully deleted!');
    }

    public function showUsersTable()
    {
        $users = User::all();

        return view('_admins.tables.accounts.user-table', compact('users'));
    }

    public function deleteUsers($id)
    {
        $user = User::find(decrypt($id));
        if ($user->ava != '' || $user->ava != 'seeker.png' || $user->ava != 'agency.png') {
            Storage::delete('public/users/' . $user->ava);
        }
        $user->forceDelete();
        if ($user->isAgency()) {
            $this->deletePartnersAgencies($user);

        } elseif ($user->isSeeker()) {
            $this->deletePartnersSeekers($user);
        }

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }

    public function showAgenciesTable()
    {
        $agencies = Agencies::all();

        return view('_admins.tables.accounts.agency-table', compact('agencies'));
    }

    public function deleteAgencies($id)
    {
        $agency = Agencies::find(decrypt($id));
        $user = User::find($agency->user_id);
        if ($user->ava != '' || $user->ava != 'agency.png') {
            Storage::delete('public/users/' . $user->ava);
        }
        $user->forceDelete();
        $this->deletePartnersAgencies($user);

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }

    private function deletePartnersAgencies($user)
    {
        $data = array('email' => $user->email, 'judul' => null);
        $partners = PartnerCredential::where('status', true)->where('isSync', true)
            ->whereDate('api_expiry', '>=', today())->get();
        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $client = new Client([
                    'base_uri' => $partner->uri,
                    'defaults' => [
                        'exceptions' => false
                    ]
                ]);

                try {
                    $client->delete($partner->uri . '/api/SISKA/vacancies/delete', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'check_form' => 'agency',
                            'agencies' => $data,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }

        }
    }

    public function showSeekersTable()
    {
        $seekers = Seekers::all();

        return view('_admins.tables.accounts.seeker-table', compact('seekers'));
    }

    public function deleteSeekers($id)
    {
        $seeker = Seekers::find(decrypt($id));
        $user = User::find($seeker->user_id);
        if ($user->ava != '' || $user->ava != 'seeker.png') {
            Storage::delete('public/users/' . $user->ava);
        }
        $user->forceDelete();
        $this->deletePartnersSeekers($user);

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }

    private function deletePartnersSeekers($user)
    {
        $partners = PartnerCredential::where('status', true)->where('isSync', true)
            ->whereDate('api_expiry', '>=', today())->get();
        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $client = new Client([
                    'base_uri' => $partner->uri,
                    'defaults' => [
                        'exceptions' => false
                    ]
                ]);

                try {
                    $client->delete($partner->uri . '/api/SISKA/seekers/delete', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'email' => $user->email,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }
        }
    }
}

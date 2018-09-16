<?php

namespace App\Http\Controllers\Agencies;

use App\Agencies;
use App\FungsiKerja;
use App\Gallery;
use App\Industri;
use App\Invitation;
use App\JobLevel;
use App\JobType;
use App\Provinces;
use App\Salaries;
use App\User;
use App\Vacancies;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function showDashboard(Request $request)
    {
        return 'agency dashboard here';
    }

    public function invitedSeeker(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        $time = $request->time;
        if ($request->has('time')) {
            if ($time == 2) {
                $invited = Invitation::where('agency_id', $agency->id)->where('isInvite', true)
                    ->whereDate('created_at', Carbon::today())
                    ->orderByDesc('id')->paginate(5);
            } elseif ($time == 3) {
                $invited = Invitation::where('agency_id', $agency->id)->where('isInvite', true)
                    ->whereDate('created_at', '>', Carbon::today()->subWeek()->toDateTimeString())
                    ->orderByDesc('id')->paginate(5);
            } elseif ($time == 4) {
                $invited = Invitation::where('agency_id', $agency->id)->where('isInvite', true)
                    ->whereDate('created_at', '>', Carbon::today()->subMonth()->toDateTimeString())
                    ->orderByDesc('id')->paginate(5);
            } else {
                $invited = Invitation::where('agency_id', $agency->id)->where('isInvite', true)
                    ->orderByDesc('id')->paginate(5);
            }
        } else {
            $invited = Invitation::where('agency_id', $agency->id)->where('isInvite', true)
                ->orderByDesc('id')->paginate(5);
        }

        return view('auth.agencies.dashboard-invitedSeeker', compact('user', 'agency', 'invited', 'time'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $industry = Industri::find($agency->industri_id);
        $galleries = Gallery::where('agency_id', $agency->id)->get();

        return view('auth.agencies.editprofile-agency', compact('user', 'agency', 'industry',
            'galleries'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        if ($request->check_form == 'personal_data') {

            $user->update(['name' => $request->name]);
            $agency->update([
                'kantor_pusat' => $request->kantor_pusat,
                'industri_id' => $request->industri_id,
                'link' => $request->link,
                'hari_kerja' => $request->start_day . ' - ' . $request->end_day,
                'jam_kerja' => $request->start_time . ' - ' . $request->end_time,
            ]);

        } elseif ($request->check_form == 'address') {
            $address = str_replace(" ", "+", $request->alamat);
            $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address");

            $lat = json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

            $agency->update([
                'alamat' => $request->alamat,
                'lat' => $lat,
                'long' => $long,
            ]);

        } elseif ($request->check_form == 'about') {

            $agency->update([
                'tentang' => $request->tentang,
                'alasan' => $request->alasan,
            ]);

        }

        return back()->with('update', 'Successfully updated!');
    }

    public function createGalleries(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $total_files = count($request->file('galleries'));

        $this->validate($request, [
            'galleries' => 'required|array',
            'galleries.*' => 'mimes:jpg,jpeg,gif,png|max:5120'
        ]);

        if ($request->hasfile('galleries')) {
            foreach ($request->file('galleries') as $file) {
                $name = $file->getClientOriginalName();
                $file->storeAs('public/users/agencies/galleries', $name);

                Gallery::create([
                    'agency_id' => $agency->id,
                    'image' => $name,
                ]);
            }
        }

        return back()->with('add', 'Successfully added ' . $total_files . ' picture(s)!');
    }

    public function deleteGallery(Request $request)
    {
        $ids = $request->input('gallery_cbs', []);
        $images = Gallery::whereIn('id', $ids)->get()->pluck('image')->toArray();

        Gallery::whereIn("id", $ids)->delete();
        foreach ($images as $image) {
            Storage::delete('public/users/agencies/galleries/' . $image);
        }

        return back()->with('delete', '' . count($images) . ' file(s) are successfully deleted!');
    }

    public function accountSettings()
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $industry = Industri::find($agency->industri_id);

        return view('auth.agencies.settings-agency', compact('user', 'agency', 'industry'));
    }

    public function updateAccount(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $img = $request->file('ava');

        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);

        if ($img == null) {
            $input = $request->all();
            if (!Hash::check($input['password'], $user->password)) {
                return 0;
            } else {
                if ($input['new_password'] != $input['password_confirmation']) {
                    return 1;
                } else {
                    $user->update(['password' => bcrypt($input['new_password'])]);
                    return 2;
                }
            }
        } else {
            if ($request->hasFile('ava')) {
                $name = $img->getClientOriginalName();

                if ($user->ava != '') {
                    Storage::delete('public/users/' . $user->ava);
                }

                if ($img->isValid()) {
                    $request->ava->storeAs('public/users', $name);
                    $user->update(['ava' => $name]);
                    return asset('storage/users/' . $name);
                }
            }
        }
    }

    public function showVacancyStatus()
    {
        return 'vacancy status here...';
    }

    public function showVacancy()
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('agency_id', $agency->id)->orderByDesc('id')->get();

        $provinces = Provinces::all();
        $job_functions = FungsiKerja::all();
        $industries = Industri::all();
        $job_levels = JobLevel::all();
        $job_types = JobType::all();
        $salaries = Salaries::all();

        return view('auth.agencies.editVacancy', compact('user', 'agency', 'vacancies', 'provinces',
            'job_functions', 'industries', 'job_levels', 'job_types', 'salaries'));
    }

    public function createVacancy(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        Vacancies::create([
            'judul' => $request->judul,
            'cities_id' => $request->cities_id,
            'syarat' => $request->syarat,
            'tanggungjawab' => $request->tanggungjawab,
            'pengalaman' => 'At least ' . $request->pengalaman . ' years',
            'jobtype_id' => $request->jobtype_id,
            'industry_id' => $request->industri_id,
            'joblevel_id' => $request->joblevel_id,
            'salary_id' => $request->salary_id,
            'agency_id' => $agency->id,
            'tingkatpend_id' => $request->tingkatpend_id,
            'jurusanpend_id' => $request->jurusanpend_id,
            'fungsikerja_id' => $request->fungsikerja_id,
            'interview' => $request->interview,
            'aktif_sampai' => Carbon::parse($request->created_at)->addDays(+30),
        ]);

        return back()->with('add', 'Successfully added a vacancy (' . $request->judul . ')!');
    }

    public function editVacancy($id)
    {
        $findVacancy = Vacancies::find(decrypt($id));
        return $findVacancy;
    }

    public function updateVacancy($id, Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        $findVacancy = Vacancies::find(decrypt($id));

        $findVacancy->update([
            'judul' => $request->judul,
            'cities_id' => $request->cities_id,
            'syarat' => $request->syarat,
            'tanggungjawab' => $request->tanggungjawab,
            'pengalaman' => 'At least ' . $request->pengalaman . ' years',
            'jobtype_id' => $request->jobtype_id,
            'industry_id' => $request->industri_id,
            'joblevel_id' => $request->joblevel_id,
            'salary_id' => $request->salary_id,
            'agency_id' => $agency->id,
            'tingkatpend_id' => $request->tingkatpend_id,
            'jurusanpend_id' => $request->jurusanpend_id,
            'fungsikerja_id' => $request->fungsikerja_id,
            'interview' => $request->interview,
            'aktif_sampai' => Carbon::parse($request->created_at)->addDays(+30),
        ]);

        return back()->with('update', '' . $request->judul . ' is successfully updated!');
    }

    public function deleteVacancy($id, $judul)
    {
        Vacancies::destroy(decrypt($id));
        return back()->with('delete', '' . $judul . ' is successfully deleted!');
    }
}

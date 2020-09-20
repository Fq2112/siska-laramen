<?php

namespace App\Http\Controllers\Agencies;

use App\Accepting;
use App\Agencies;
use App\ConfirmAgency;
use App\Education;
use App\Experience;
use App\FungsiKerja;
use App\Gallery;
use App\Industri;
use App\Invitation;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\PartnerCredential;
use App\Plan;
use App\Provinces;
use App\Salaries;
use App\Seekers;
use App\Support\RomanConverter;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'agency']);
    }

    public function showDashboard()
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('agency_id', $agency->id)->where('isPost', true)->get();

        return view('auth.agencies.dashboard', compact('user', 'agency', 'vacancies'));
    }

    public function getAccSeeker(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $result = Accepting::where('vacancy_id', $request->vacancy_id)->where('isApply', true)
            ->whereBetween('created_at', [$start, $end])->orderByDesc('id')->paginate(6)->toArray();

        $result = $this->array_AccInv_seekers($result);

        return $result;
    }

    public function recommendedSeeker(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('agency_id', $agency->id)->get();

        $keyword = $request->q;
        $page = $request->page;

        return view('auth.agencies.dashboard-recommendedSeeker', compact('user', 'agency', 'vacancies',
            'keyword', 'page'));
    }

    public function getRecommendedSeeker(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('agency_id', $agency->id)->where('isPost', true)->get();

        $reqExp = array();
        $reqEdu = array();
        foreach ($vacancies as $vacancy) {
            $reqExp[] = filter_var($vacancy->pengalaman, FILTER_SANITIZE_NUMBER_INT);
            $reqEdu[] = $vacancy->tingkatpend_id;
        }

        $keyword = $request->q;
        $result = Seekers::whereHas('user', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->whereHas('educations', function ($query) use ($reqEdu) {
            foreach ($reqEdu as $edu) {
                $query->orWhere('tingkatpend_id', '>=', $edu);
            }
        })->where(function ($query) use ($reqExp) {
            foreach ($reqExp as $exp) {
                $query->orWhere('total_exp', '>=', $exp);
            }
        })->orderByDesc('total_exp')->paginate(6)->appends($request->only('q'))->toArray();

        $result = $this->array_seekers($result);
        return $result;
    }

    private function array_seekers($result)
    {
        $i = 0;
        foreach ($result['data'] as $row) {
            $userSeeker = User::find($row['user_id']);

            $filename = $userSeeker->ava == "seeker.png" || $userSeeker->ava == "" ?
                asset('images/seeker.png') : asset('storage/users/' . $userSeeker->ava);

            $job_title = Experience::where('seeker_id', $row['id'])->where('end_date', null)
                ->orderby('id', 'desc')->take(1);
            $last_edu = Education::where('seeker_id', $row['id'])->wherenotnull('end_period')
                ->orderby('tingkatpend_id', 'desc')->take(1);
            $ava['seeker'] = array('ava' => $filename, 'name' => $userSeeker->name, 'email' => $userSeeker->email,
                'id' => $row['id'], 'low' => $row['lowest_salary'] / 1000000, 'high' => $row['highest_salary'] / 1000000);
            $exp = array('jobTitle' => $job_title->count() ? 'Current Title: ' . $job_title->first()->job_title :
                'Current Status: Looking for a Job');
            $totalExp = array('total_exp' => is_null($row['total_exp']) ? 0 : $row['total_exp']);
            $edu['edu'] = array(
                'last_deg' => $last_edu->count() ? Tingkatpend::find($last_edu->first()->tingkatpend_id)->name : '-',
                'last_maj' => $last_edu->count() ? Jurusanpend::find($last_edu->first()->jurusanpend_id)->name : '-'
            );
            $created_at = array('created_at' => Carbon::parse($row['created_at'])->format('j F Y'));
            $update_at = array('updated_at' => Carbon::parse($row['updated_at'])->diffForHumans());
            $inv = array('inv' => Invitation::where('seeker_id', $row['id'])->first());

            $result['data'][$i] = array_replace($ava, $result['data'][$i], $exp, $totalExp, $edu, $created_at,
                $update_at, $inv);
            $i = $i + 1;
        }

        return $result;
    }

    public function detailRecommendedSeeker($id)
    {
        $seeker = Seekers::find($id);
        $userSeeker = User::find($seeker->user_id);
        if ($userSeeker->ava == "seeker.png" || $userSeeker->ava == "") {
            $filename = asset('images/seeker.png');
        } else {
            $filename = asset('storage/users/' . $userSeeker->ava);
        }
        $job_title = Experience::where('seeker_id', $id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);
        $last_edu = Education::where('seeker_id', $id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        $ava['user'] = array('ava' => $filename, 'name' => $userSeeker->name, 'email' => $userSeeker->email);
        $exp = array('jobTitle' => $job_title->count() ? 'Current Title: ' . $job_title->first()->job_title :
            'Current Status: Looking for a Job');
        $totalExp = array('total_exp' => is_null($seeker->total_exp) ? 0 : $seeker->total_exp);
        $edu['edu'] = array(
            'last_deg' => $last_edu->count() ? Tingkatpend::find($last_edu->first()->tingkatpend_id)->name : '-',
            'last_maj' => $last_edu->count() ? Jurusanpend::find($last_edu->first()->jurusanpend_id)->name : '-'
        );
        $created_at = array('created_at' => Carbon::parse($userSeeker->created_at)->format('j F Y'));
        $update_at = array('updated_at' => $userSeeker->updated_at->diffForHumans());
        $result = array_replace($ava, $seeker->toArray(), $exp, $totalExp, $edu, $created_at, $update_at);

        return $result;
    }

    public function invitedSeeker()
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('agency_id', $agency->id)->where('isPost', true)->get();

        return view('auth.agencies.dashboard-invitedSeeker', compact('user', 'agency', 'vacancies'));
    }

    public function getInvitedSeeker(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        $start = $request->start_date;
        $end = $request->end_date;

        $result = Invitation::where('agency_id', $agency->id)->where('vacancy_id', $request->vacancy_id)
            ->whereBetween('created_at', [$start, $end])->orderByDesc('id')->paginate(6)->toArray();

        $result = $this->array_AccInv_seekers($result);

        return $result;
    }

    private function array_AccInv_seekers($result)
    {
        $i = 0;
        foreach ($result['data'] as $row) {
            $seeker = Seekers::find($row['seeker_id']);

            $filename = $seeker->user->ava == "seeker.png" || $seeker->user->ava == "" ?
                asset('images/seeker.png') : asset('storage/users/' . $seeker->user->ava);

            $job_title = Experience::where('seeker_id', $row['seeker_id'])->where('end_date', null)
                ->orderby('id', 'desc')->take(1);
            $last_edu = Education::where('seeker_id', $row['seeker_id'])->wherenotnull('end_period')
                ->orderby('tingkatpend_id', 'desc')->take(1);

            $ava['seeker'] = array('ava' => $filename, 'name' => $seeker->user->name, 'email' => $seeker->user->email,
                'phone' => $seeker->phone,
                'low' => $seeker->lowest_salary / 1000000, 'high' => $seeker->highest_salary / 1000000,
                'jobTitle' => $job_title->count() ? 'Current Title: ' . $job_title->first()->job_title :
                    'Current Status: Looking for a Job',
                'total_exp' => is_null($seeker->total_exp) ? 0 : $seeker->total_exp,
                'last_deg' => $last_edu->count() ? Tingkatpend::find($last_edu->first()->tingkatpend_id)->name : '-',
                'last_maj' => $last_edu->count() ? Jurusanpend::find($last_edu->first()->jurusanpend_id)->name : '-',
                'created_at' => Carbon::parse($seeker->created_at)->format('j F Y'),
                'updated_at' => Carbon::parse($seeker->updated_at)->diffForHumans()
            );

            $created_at = array('created_at' => Carbon::parse($row['created_at'])->format('j F Y'));

            $result['data'][$i] = array_replace($ava, $result['data'][$i], $created_at);
            $i = $i + 1;
        }

        return $result;
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
                'phone' => $request->phone,
                'hari_kerja' => $request->start_day . ' - ' . $request->end_day,
                'jam_kerja' => $request->start_time . ' - ' . $request->end_time,
            ]);

        } elseif ($request->check_form == 'address') {
            $address = str_replace(" ", "+", $request->alamat);
            $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" .
                $address . "&key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68");

            $request->request->add([
                'lat' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
                'long' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}
            ]);

            $agency->update([
                'alamat' => $request->alamat,
                'lat' => $request->lat,
                'long' => $request->long,
            ]);

        } elseif ($request->check_form == 'about') {
            $agency->update([
                'tentang' => $request->tentang,
                'alasan' => $request->alasan,
            ]);
        }

        $data = array('email' => $user->email, 'input' => $request->toArray());
        $this->updatePartners($data, $request->check_form);

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
                $name = $agency->id . str_random(6) . '.' . $file->getClientOriginalExtension();
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
            $name = $img->getClientOriginalName();

            if ($user->ava != '' || $user->ava != 'agency.png') {
                Storage::delete('public/users/' . $user->ava);
            }

            if ($img->isValid()) {
                $request->ava->storeAs('public/users', $name);
                $user->update(['ava' => $name]);
                return asset('storage/users/' . $name);
            }

        }
    }

    public function showVacancyStatus(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        $req_id = $request->id;
        $req_invoice = $request->invoice;
        $findConfirm = $req_id != null ? ConfirmAgency::find(decrypt($req_id)) : '';

        return view('auth.agencies.dashboard-vacancyStatus', compact('user', 'agency',
            'req_id', 'req_invoice', 'findConfirm'));
    }

    public function getVacancyStatus(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $result = ConfirmAgency::where('agency_id', $request->agency_id)
            ->whereBetween('created_at', [$start, $end])->orderByDesc('id')->paginate(6)->toArray();

        $i = 0;
        foreach ($result['data'] as $row) {
            $id['encryptID'] = encrypt($row['id']);
            $date = Carbon::parse($row['created_at']);
            $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
                RomanConverter::numberToRoman($date->format('m'));

            $filename = $row['isPaid'] == true ? asset('images/stamp_paid.png') :
                asset('images/stamp_unpaid.png');

            $plan = Plan::find($row['plans_id']);

            $vacancies['vacancy_ids'] = Vacancies::whereIn('id', $row['vacancy_ids'])
                ->select('id', 'judul', 'isPost')->get()->toArray();

            $paid = array('ava' => $filename);
            $invoice = array('invoice' => '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $row['id']);
            $pl = array('plan' => $plan->name);
            $pm = array('pm' => $row['payment_name']);
            $pc = array('pc' => strtoupper(str_replace('_',' ',$row['payment_type'])));
            $created_at = array('created_at' => Carbon::parse($row['created_at'])->diffForHumans());
            $created_at1DayAdd = array('add_day' => Carbon::parse($row['created_at'])->addDay());
            $status = array('expired' => now() >= Carbon::parse($row['created_at'])->addDay() ? true : false);
            $deadline = array('deadline' => Carbon::parse($row['created_at'])->addDay()->format('l, j F Y') .
                ' at ' . Carbon::parse($row['created_at'])->addDay()->format('H:i'));

            $orderDate = array('date_order' => Carbon::parse($row['created_at'])->format('l, j F Y'));
            $paidDate = array('date_payment' => Carbon::parse($row['date_payment'])->format('l j F Y'));

            $result['data'][$i] = array_replace($paid, $id, $invoice, $result['data'][$i], $pl, $pm, $pc,
                $created_at, $created_at1DayAdd, $orderDate, $paidDate, $deadline, $vacancies, $status);
            $i = $i + 1;
        }

        return $result;
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

        return view('auth.agencies.dashboard-vacancyEdit', compact('user', 'agency', 'vacancies',
            'provinces', 'job_functions', 'industries', 'job_levels', 'job_types', 'salaries'));
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
            'pengalaman' => $request->pengalaman,
            'jobtype_id' => $request->jobtype_id,
            'industry_id' => $request->industri_id,
            'joblevel_id' => $request->joblevel_id,
            'salary_id' => $request->salary_id,
            'agency_id' => $agency->id,
            'tingkatpend_id' => $request->tingkatpend_id,
            'jurusanpend_id' => $request->jurusanpend_id,
            'fungsikerja_id' => $request->fungsikerja_id,
        ]);

        return back()->with('add', 'Successfully added a vacancy (' . $request->judul . ')!');
    }

    public function editVacancy($id)
    {
        $findVacancy = Vacancies::find($id);
        return $findVacancy;
    }

    public function updateVacancy($id, Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        if ($request->check_form == 'schedule') {
            if ($request->quizDate_start == "" && $request->psychoTestDate_start == "") {
                $this->validate($request, [
                    'recruitmentDate_start' => 'required|date',
                    'recruitmentDate_end' => 'required|date|after_or_equal:recruitmentDate_start',
                    'interview_date' => 'required|date|after_or_equal:recruitmentDate_end',
                ]);
            } elseif ($request->quizDate_start != "" && $request->psychoTestDate_start == "") {
                $this->validate($request, [
                    'recruitmentDate_start' => 'required|date',
                    'recruitmentDate_end' => 'required|date|after_or_equal:recruitmentDate_start',
                    'quizDate_start' => 'required|date|after_or_equal:recruitmentDate_end',
                    'quizDate_end' => 'required|date|after_or_equal:quizDate_start',
                    'interview_date' => 'required|date|after_or_equal:quizDate_end',
                ]);
            } elseif ($request->quizDate_start != "" && $request->psychoTestDate_start != "") {
                $this->validate($request, [
                    'recruitmentDate_start' => 'required|date',
                    'recruitmentDate_end' => 'required|date|after_or_equal:recruitmentDate_start',
                    'quizDate_start' => 'required|date|after_or_equal:recruitmentDate_end',
                    'quizDate_end' => 'required|date|after_or_equal:quizDate_start',
                    'psychoTestDate_start' => 'required|date|after_or_equal:quizDate_end',
                    'psychoTestDate_end' => 'required|date|after_or_equal:psychoTestDate_start',
                    'interview_date' => 'required|date|after_or_equal:psychoTestDate_end',
                ]);
            }

            $request->request->add(['isPost' => true]);
        }

        $findVacancy = Vacancies::find($id);
        $data = array('email' => $user->email, 'judul' => $findVacancy->judul, 'input' => $request->toArray());
        $this->updatePartners($data, $request->check_form);

        if ($request->check_form == 'vacancy') {
            $findVacancy->update([
                'judul' => $request->judul,
                'cities_id' => $request->cities_id,
                'syarat' => $request->syarat,
                'tanggungjawab' => $request->tanggungjawab,
                'pengalaman' => $request->pengalaman,
                'jobtype_id' => $request->jobtype_id,
                'industry_id' => $request->industri_id,
                'joblevel_id' => $request->joblevel_id,
                'salary_id' => $request->salary_id,
                'agency_id' => $agency->id,
                'tingkatpend_id' => $request->tingkatpend_id,
                'jurusanpend_id' => $request->jurusanpend_id,
                'fungsikerja_id' => $request->fungsikerja_id,
            ]);

        } elseif ($request->check_form == 'schedule') {
            $findVacancy->update([
                'interview_date' => $request->interview_date,
                'recruitmentDate_start' => $request->recruitmentDate_start,
                'recruitmentDate_end' => $request->recruitmentDate_end,
                'quizDate_start' => $request->quizDate_start,
                'quizDate_end' => $request->quizDate_end,
                'psychoTestDate_start' => $request->psychoTestDate_start,
                'psychoTestDate_end' => $request->psychoTestDate_end,
            ]);
        }

        return back()->with('update', '' . $findVacancy->judul . ' is successfully updated!');
    }

    private function updatePartners($data, $check)
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
                    $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'check_form' => $check,
                            'agencies' => $data,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }
        }
    }

    public function deleteVacancy($id, $judul)
    {
        $vacancy = Vacancies::find(decrypt($id));
        $vacancy->delete();

        $data = array('email' => $vacancy->agencies->user->email, 'judul' => $judul);
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
                            'check_form' => 'vacancy',
                            'agencies' => $data,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }
        }

        return back()->with('delete', '' . $judul . ' is successfully deleted!');
    }
}

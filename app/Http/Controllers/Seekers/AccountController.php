<?php

namespace App\Http\Controllers\Seekers;

use App\Accepting;
use App\Attachments;
use App\Education;
use App\Experience;
use App\FungsiKerja;
use App\Industri;
use App\Invitation;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\Languages;
use App\Nations;
use App\Organization;
use App\Salaries;
use App\Seekers;
use App\Skills;
use App\Tingkatpend;
use App\Training;
use App\User;
use App\Provinces;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'seeker']);
    }

    public function editProfile()
    {
        $user = Auth::user();
        $nations = Nations::all();
        $provinces = Provinces::all();
        $job_functions = FungsiKerja::all();
        $industries = Industri::all();
        $job_levels = JobLevel::all();
        $job_types = JobType::all();
        $salaries = Salaries::all();
        $degrees = Tingkatpend::all();
        $majors = Jurusanpend::all();

        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $attachments = Attachments::where('seeker_id', $seeker->id)->orderby('created_at', 'desc')->get();
        $experiences = Experience::where('seeker_id', $seeker->id)->orderby('id', 'desc')->get();
        $educations = Education::where('seeker_id', $seeker->id)->orderby('tingkatpend_id', 'desc')->get();
        $trainings = Training::where('seeker_id', $seeker->id)->orderby('id', 'desc')->get();
        $organizations = Organization::where('seeker_id', $seeker->id)->orderby('id', 'desc')->get();
        $languages = Languages::where('seeker_id', $seeker->id)->orderby('id', 'desc')->get();
        $skills = Skills::where('seeker_id', $seeker->id)->orderby('id', 'desc')->get();

        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        $totalApp = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)->count();
        $totalBook = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->count();
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->count();

        return view('auth.seekers.profile', compact(
            'user', 'nations', 'provinces', 'job_functions', 'industries', 'job_levels', 'job_types',
            'salaries', 'degrees', 'majors', 'seeker', 'seeker_degree', 'seeker_major', 'attachments',
            'experiences', 'educations', 'trainings', 'organizations', 'languages', 'skills', 'job_title',
            'last_edu', 'totalApp', 'totalBook', 'totalInvToApply'
        ));
    }

    private function updateContact($seeker, $input)
    {
        $seeker->update([
            'phone' => $input['phone'],
            'address' => $input['address'],
            'zip_code' => $input['zip_code'],
        ]);
    }

    private function updatePersonal($user, $seeker, $input)
    {
        $user->update([
            'name' => $input['name']
        ]);
        $seeker->update([
            'birthday' => $input['birthday'],
            'gender' => $input['gender'],
            'relationship' => $input['relationship'],
            'nationality' => $input['nationality'],
            'website' => $input['website'],
            'lowest_salary' => str_replace(',', '', $input['lowest']),
            'highest_salary' => str_replace(',', '', $input['highest']),
        ]);
    }

    private function updateVideoSummary($seeker, $request)
    {
        $this->validate($request, [
            'video_summary' => 'mimetypes:video/mp4,video/ogg,video/webm|max:30720',
        ]);

        if ($request->hasFile('video_summary')) {
            $video = $request->file('video_summary');
            $name = $video->getClientOriginalName();
            if ($seeker->video_summary != '') {
                Storage::delete('public/users/seekers/video/' . $seeker->video_summary);
            }
            if ($video->isValid()) {
                $request->video_summary->storeAs('public/users/seekers/video', $name);
                $seeker->update([
                    'video_summary' => $name
                ]);
            }
        }
    }

    private function deleteVideoSummary($seeker)
    {
        if ($seeker->video_summary != '') {
            Storage::delete('public/users/seekers/video/' . $seeker->video_summary);
        }
        $seeker->update([
            'video_summary' => null
        ]);
    }

    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $check = $input['check_form'];
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        if ($check == 'contact') {
            $this->updateContact($seeker, $input);

        } elseif ($check == 'personal') {
            $this->updatePersonal($user, $seeker, $input);

        } elseif ($check == 'summary') {
            $seeker->update([
                'summary' => $input['summary']
            ]);

        } elseif ($check == 'video_summary') {
            $this->updateVideoSummary($seeker, $request);
            return asset('storage/users/seekers/video/' . $seeker->video_summary);

        } elseif ($check == 'delete_video_summary') {
            $this->deleteVideoSummary($seeker);
        }

        return back()->with('update', 'Successfully updated!');
    }

    public function accountSettings()
    {
        $user = Auth::user();
        $provinces = Provinces::all();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        $totalApp = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)->count();
        $totalBook = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->count();
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->count();

        return view('auth.seekers.settings', compact('user', 'provinces', 'seeker', 'job_title',
            'last_edu', 'totalApp', 'totalBook', 'totalInvToApply'));
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

                if ($user->ava != '' || $user->ava != 'seeker.png') {
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

    public function updateBackground(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->first();
        $img = $request->file('background');

        $this->validate($request, [
            'background' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);

        if ($request->hasFile('background')) {
            $name = $img->getClientOriginalName();

            if ($seeker->background != '') {
                Storage::delete('public/users/seekers/background/' . $seeker->background);
            }

            if ($img->isValid()) {
                $request->background->storeAs('public/users/seekers/background', $name);
                $seeker->update(['background' => $name]);

                return asset('storage/users/seekers/background/' . $name);
            }
        }
    }

    public function createAttachments(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $total_files = count($request->file('attachments'));

        $this->validate($request, [
            'attachments' => 'required|array',
            'attachments.*' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120'
        ]);

        if ($request->hasfile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $name = $file->getClientOriginalName();
                $file->storeAs('public/users/seekers/attachments', $name);

                Attachments::create([
                    'seeker_id' => $seeker->id,
                    'files' => $name,
                ]);
            }
        }

        return back()->with('add', 'Successfully added ' . $total_files . ' attachment(s)!');
    }

    public function deleteAttachments(Request $request)
    {
        $ids = $request->input('attachments_cbs', []);
        $files = Attachments::whereIn('id', $ids)->get()->pluck('files')->toArray();

        Attachments::whereIn("id", $ids)->delete();
        foreach ($files as $file) {
            Storage::delete('public/users/seekers/attachments/' . $file);
        }

        return back()->with('delete', '' . count($files) . ' file(s) are successfully deleted!');
    }

    public function createExperiences(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $input = $request->all();

        if ($input['end_date'] != "") {
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'date|after_or_equal:start_date'
            ]);
        }

        Experience::create([
            'seeker_id' => $seeker->id,
            'job_title' => $input['job_title'],
            'joblevel_id' => $input['joblevel_id'],
            'company' => $input['company'],
            'fungsikerja_id' => $input['fungsikerja_id'],
            'industri_id' => $input['industri_id'],
            'city_id' => $input['city_id'],
            'salary_id' => $input['salary_id'],
            'start_date' => $input['start_date'],
            'end_date' => $input['end_date'],
            'jobtype_id' => $input['jobtype_id'],
            'report_to' => $input['report_to'],
            'job_desc' => $input['job_desc']
        ]);

        $exp = Experience::where('seeker_id', $seeker->id)->get();
        $totalExp = 0;
        foreach ($exp as $row) {
            $totalExp += Carbon::parse($row->start_date)->diffInYears(Carbon::parse($row->end_date));
        }
        $seeker->update([
            'total_exp' => $totalExp
        ]);

        return back()->with('add', 'Successfully added an experience (' . $input['job_title'] . ')!');
    }

    public function editExperiences($id)
    {
        $findExp = Experience::find(decrypt($id));
        return $findExp;
    }

    public function updateExperiences($id, Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $findExp = Experience::find(decrypt($id));
        $input = $request->all();

        if ($input['end_date'] != "") {
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'date|after_or_equal:start_date'
            ]);
        }

        $findExp->update([
            'job_title' => $input['job_title'],
            'joblevel_id' => $input['joblevel_id'],
            'company' => $input['company'],
            'fungsikerja_id' => $input['fungsikerja_id'],
            'industri_id' => $input['industri_id'],
            'city_id' => $input['city_id'],
            'salary_id' => $input['salary_id'],
            'start_date' => $input['start_date'],
            'end_date' => $input['end_date'],
            'jobtype_id' => $input['jobtype_id'],
            'report_to' => $input['report_to'],
            'job_desc' => $input['job_desc']
        ]);

        $exp = Experience::where('seeker_id', $seeker->id)->get();
        $totalExp = 0;
        foreach ($exp as $row) {
            $totalExp += Carbon::parse($row->start_date)->diffInYears(Carbon::parse($row->end_date));
        }
        $seeker->update([
            'total_exp' => $totalExp
        ]);

        return back()->with('update', 'Work experience (' . $input['job_title'] . ') is successfully updated!');
    }

    public function deleteExperiences($id, $exp)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        Experience::destroy(decrypt($id));

        $expSeek = Experience::where('seeker_id', $seeker->id)->get();
        $totalExp = 0;
        foreach ($expSeek as $row) {
            $totalExp += Carbon::parse($row->start_date)->diffInYears(Carbon::parse($row->end_date));
        }
        $seeker->update([
            'total_exp' => $totalExp
        ]);

        return back()->with('delete', 'Work experience (' . $exp . ') is successfully deleted!');
    }

    public function createEducations(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $input = $request->all();

        if ($input['end_period'] != "") {
            $this->validate($request, [
                'start_period' => 'required',
                'end_period' => 'after_or_equal:start_period'
            ]);
        }

        Education::create([
            'seeker_id' => $seeker->id,
            'school_name' => $input['school_name'],
            'tingkatpend_id' => $input['tingkatpend_id'],
            'jurusanpend_id' => $input['jurusanpend_id'],
            'awards' => $input['awards'],
            'nilai' => $input['nilai'],
            'start_period' => $input['start_period'],
            'end_period' => $input['end_period'],
        ]);
        return back()->with('add', 'Successfully added an education in (' . $input['school_name'] . ')!');
    }

    public function editEducations($id)
    {
        $findEdu = Education::find(decrypt($id));
        return $findEdu;
    }

    public function updateEducations($id, Request $request)
    {
        $findEdu = Education::find(decrypt($id));
        $input = $request->all();

        if ($input['end_period'] != "") {
            $this->validate($request, [
                'start_period' => 'required',
                'end_period' => 'after_or_equal:start_period'
            ]);
        }

        $findEdu->update([
            'school_name' => $input['school_name'],
            'tingkatpend_id' => $input['tingkatpend_id'],
            'jurusanpend_id' => $input['jurusanpend_id'],
            'awards' => $input['awards'],
            'nilai' => $input['nilai'],
            'start_period' => $input['start_period'],
            'end_period' => $input['end_period'],
        ]);
        return back()->with('update', 'Education in (' . $input['school_name'] . ') is successfully updated!');
    }

    public function deleteEducations($id, $edu)
    {
        Education::destroy(decrypt($id));
        return back()->with('delete', 'Education in (' . $edu . ') is successfully deleted!');
    }

    public function createTrainings(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $input = $request->all();

        Training::create([
            'seeker_id' => $seeker->id,
            'name' => $input['name'],
            'issuedby' => $input['issuedby'],
            'descript' => $input['descript'],
            'issueddate' => $input['issueddate'],
        ]);

        return back()->with('add', 'Successfully added a training/certification (' . $input['name'] . ')!');
    }

    public function editTrainings($id)
    {
        $findCert = Training::find(decrypt($id));
        return $findCert;
    }

    public function updateTrainings($id, Request $request)
    {
        $findCert = Training::find(decrypt($id));
        $input = $request->all();

        $findCert->update([
            'name' => $input['name'],
            'issuedby' => $input['issuedby'],
            'descript' => $input['descript'],
            'issueddate' => $input['issueddate'],
        ]);

        return back()->with('update', '' . $input['name'] . ' training/certification is successfully updated!');
    }

    public function deleteTrainings($id, $cert)
    {
        Training::destroy(decrypt($id));
        return back()->with('delete', '' . $cert . ' training/certification is successfully deleted!');
    }

    public function createOrganizations(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $input = $request->all();

        if ($input['end_period'] != "") {
            $this->validate($request, [
                'start_period' => 'required',
                'end_period' => 'after_or_equal:start_period'
            ]);
        }

        Organization::create([
            'seeker_id' => $seeker->id,
            'name' => $input['name'],
            'title' => $input['title'],
            'start_period' => $input['start_period'],
            'end_period' => $input['end_period'],
            'descript' => $input['descript'],
        ]);

        return back()->with('add', 'Successfully added an organization (' . $input['name'] . ')!');
    }

    public function editOrganizations($id)
    {
        $findOrg = Organization::find(decrypt($id));
        return $findOrg;
    }

    public function updateOrganizations($id, Request $request)
    {
        $findOrg = Organization::find(decrypt($id));
        $input = $request->all();

        if ($input['end_period'] != "") {
            $this->validate($request, [
                'start_period' => 'required',
                'end_period' => 'after_or_equal:start_period'
            ]);
        }

        $findOrg->update([
            'name' => $input['name'],
            'title' => $input['title'],
            'start_period' => $input['start_period'],
            'end_period' => $input['end_period'],
            'descript' => $input['descript'],
        ]);

        return back()->with('update', '' . $input['name'] . ' organization is successfully updated!');
    }

    public function deleteOrganizations($id, $org)
    {
        Organization::destroy(decrypt($id));
        return back()->with('delete', '' . $org . ' organization is successfully deleted!');
    }

    public function createLanguages(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $input = $request->all();

        Languages::create([
            'seeker_id' => $seeker->id,
            'name' => $input['name'],
            'spoken_lvl' => $input['spoken_lvl'],
            'written_lvl' => $input['written_lvl'],
        ]);

        return back()->with('add', 'Successfully added a language skill (' . $input['name'] . ')!');
    }

    public function editLanguages($id)
    {
        $findLang = Languages::find(decrypt($id));
        return $findLang;
    }

    public function updateLanguages($id, Request $request)
    {
        $findLang = Languages::find(decrypt($id));
        $input = $request->all();

        $findLang->update([
            'name' => $input['name'],
            'spoken_lvl' => $input['spoken_lvl'],
            'written_lvl' => $input['written_lvl'],
        ]);

        return back()->with('update', '' . $input['name'] . ' language skill is successfully updated!');
    }

    public function deleteLanguages($id, $lang)
    {
        Languages::destroy(decrypt($id));
        return back()->with('delete', '' . $lang . ' language skill is successfully deleted!');
    }

    public function createSkills(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $input = $request->all();

        Skills::create([
            'seeker_id' => $seeker->id,
            'name' => $input['name'],
            'level' => $input['level'],
        ]);

        return back()->with('add', 'Successfully added a skill (' . $input['name'] . ')!');
    }

    public function editSkills($id)
    {
        $findSkill = Skills::find(decrypt($id));
        return $findSkill;
    }

    public function updateSkills($id, Request $request)
    {
        $findSkill = Skills::find(decrypt($id));
        $input = $request->all();

        $findSkill->update([
            'name' => $input['name'],
            'level' => $input['level'],
        ]);

        return back()->with('update', '' . $input['name'] . ' skill is successfully updated!');
    }

    public function deleteSkills($id, $skill)
    {
        Skills::destroy(decrypt($id));
        return back()->with('delete', '' . $skill . ' skill is successfully deleted!');
    }
}

<?php

namespace App\Http\Controllers\Seekers;

use App\Accepting;
use App\Agencies;
use App\Attachments;
use App\Blog;
use App\Carousel;
use App\Cities;
use App\Education;
use App\Experience;
use App\FavoriteAgency;
use App\FungsiKerja;
use App\Industri;
use App\Invitation;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\Languages;
use App\Organization;
use App\Salaries;
use App\Seekers;
use App\Skills;
use App\Tingkatpend;
use App\Training;
use App\User;
use App\Provinces;
use App\Vacancies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SeekerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'seeker'])->except(['index', 'showProfile']);
    }

    public function index()
    {
        $provinces = Provinces::all();
        $carousels = Carousel::all();
        $blogs = Blog::all();

        $id = [4, 9, 13, 26, 29, 30, 38, 40, 41, 45, 47, 49, 52, 58, 59, 61, 62, 63];
        $favIndustries = Industri::whereIn('id', $id)->get();

        $favAgency = FavoriteAgency::select('agency_id')->where('isFavorite', true)
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('agency_id')
            ->orderByDesc('count')
            ->limit(6)
            ->get()->pluck('agency_id')->toArray();

        if (count($favAgency) >= 6) {
            $agencies = Agencies::wherehas('vacancies')->whereIn('id', $favAgency)->orderByDesc('id')->take(6)->get();

        } else {
            $agencies = Agencies::wherehas('vacancies')->orderByDesc('updated_at')->take(6)->get();
        }

        return view('home-seeker', compact('provinces', 'carousels', 'blogs', 'favIndustries', 'agencies'));
    }

    public function showProfile($id)
    {
        $provinces = Provinces::all();
        $seeker = Seekers::findOrFail($id);
        $user = User::find($seeker->user_id);

        $attachments = Attachments::where('seeker_id', $id)->orderby('created_at', 'desc')->get();
        $experiences = Experience::where('seeker_id', $id)->orderby('id', 'desc')->get();
        $educations = Education::where('seeker_id', $id)->orderby('tingkatpend_id', 'desc')->get();
        $trainings = Training::where('seeker_id', $id)->orderby('id', 'desc')->get();
        $organizations = Organization::where('seeker_id', $id)->orderby('id', 'desc')->get();
        $languages = Languages::where('seeker_id', $id)->orderby('id', 'desc')->get();
        $skills = Skills::where('seeker_id', $id)->orderby('id', 'desc')->get();

        $job_title = Experience::where('seeker_id', $id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        return view('_seekers.profile-seeker', compact('provinces', 'seeker', 'user', 'attachments',
            'experiences', 'educations', 'trainings', 'organizations', 'languages', 'skills', 'job_title', 'last_edu'));
    }

    public function favoriteAgency(Request $request)
    {
        $agency = Agencies::find($request->agency_id);
        $agencyName = User::find($agency->user_id)->name;
        $fav = FavoriteAgency::where('agency_id', $agency->id)->where('user_id', Auth::user()->id);

        if (count($fav->get()) == 0) {
            FavoriteAgency::create([
                'user_id' => Auth::user()->id,
                'agency_id' => $agency->id,
                'isFavorite' => true,
            ]);

            return back()->with('agency', '' . $agencyName . ' is successfully liked!');

        } else {
            $fav->first()->delete();

            return back()->with('agency', '' . $agencyName . ' is successfully disliked!');
        }
    }

    public function showDashboard(Request $request)
    {
        $provinces = Provinces::all();
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        $totalApp = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)->count();
        $totalBook = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->count();
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->where('isApply', false)->count();

        $time = $request->time;
        if ($request->has('time')) {
            if ($time == 2) {
                $apply = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)
                    ->whereDate('created_at', Carbon::today())
                    ->orderByDesc('id')->paginate(5);
            } elseif ($time == 3) {
                $apply = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)
                    ->whereDate('created_at', '>', Carbon::today()->subWeek()->toDateTimeString())
                    ->orderByDesc('id')->paginate(5);
            } elseif ($time == 4) {
                $apply = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)
                    ->whereDate('created_at', '>', Carbon::today()->subMonth()->toDateTimeString())
                    ->orderByDesc('id')->paginate(5);
            } else {
                $apply = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)
                    ->orderByDesc('id')->paginate(5);
            }
        } else {
            $apply = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)
                ->orderByDesc('id')->paginate(5);
        }

        return view('auth.seekers.dashboard', compact('user', 'provinces', 'seeker', 'job_title',
            'last_edu', 'totalApp', 'totalBook', 'totalInvToApply', 'time', 'apply'));
    }

    public function showCompare($id)
    {
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $vacancy = Vacancies::find($id)->toArray();
        $reqEdu = $vacancy['tingkatpend_id'];
        $reqExp = filter_var($vacancy['pengalaman'], FILTER_SANITIZE_NUMBER_INT);

        $acc = Accepting::where('vacancy_id', $vacancy['id'])->where('isApply', true);
        $totalApp = array('total_app' => $acc->count());

        if (substr(Cities::find($vacancy['cities_id'])->name, 0, 2) == "Ko") {
            $cities = substr(Cities::find($vacancy['cities_id'])->name, 5);
        } else {
            $cities = substr(Cities::find($vacancy['cities_id'])->name, 10);
        }

        $userAgency = User::findOrFail(Agencies::findOrFail($vacancy['agency_id'])->user_id);
        if ($userAgency->ava == "agency.png" || $userAgency->ava == "") {
            $filename = asset('images/agency.png');
        } else {
            $filename = asset('storage/users/' . $userAgency->ava);
        }

        $city = array('city' => $cities);
        $degrees = array('degrees' => Tingkatpend::findOrFail($vacancy['tingkatpend_id'])->name);
        $majors = array('majors' => Jurusanpend::findOrFail($vacancy['jurusanpend_id'])->name);
        $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacancy['fungsikerja_id'])->nama);
        $industry = array('industry' => Industri::findOrFail($vacancy['industry_id'])->nama);
        $jobtype = array('job_type' => JobType::findOrFail($vacancy['jobtype_id'])->name);
        $joblevel = array('job_level' => JobLevel::findOrFail($vacancy['joblevel_id'])->name);
        $salary = array('salary' => Salaries::findOrFail($vacancy['salary_id'])->name);
        $ava['user'] = array('ava' => $filename, 'name' => $userAgency->name);
        $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',
            $vacancy['updated_at'])->diffForHumans());

        $accSeeker = $acc->where('seeker_id', $seeker->id);
        $applied = array('applied_on' => $accSeeker->count() > 0 ? Carbon::parse($accSeeker->first()->created_at)
            ->format('j F Y') : '');

        // compare education
        $eduEqual = array('edu_equal' => Seekers::wherehas('educations', function ($query) use ($reqEdu) {
            $query->where('tingkatpend_id', $reqEdu);
        })->wherehas('accepting', function ($query) use ($vacancy) {
            $query->where('vacancy_id', $vacancy['id']);
        })->count());
        $eduHigher = array('edu_higher' => Seekers::wherehas('educations', function ($query) use ($reqEdu) {
            $query->where('tingkatpend_id', '>', $reqEdu);
        })->wherehas('accepting', function ($query) use ($vacancy) {
            $query->where('vacancy_id', $vacancy['id']);
        })->count());

        // compare experience
        $expEqual = array('exp_equal' => Seekers::wherehas('accepting', function ($query) use ($vacancy) {
            $query->where('vacancy_id', $vacancy['id']);
        })->where('total_exp', $reqExp)->count());
        $expHigher = array('exp_higher' => Seekers::wherehas('accepting', function ($query) use ($vacancy) {
            $query->where('vacancy_id', $vacancy['id']);
        })->where('total_exp', '>', $reqExp)->count());

        $result = array_replace($ava, $vacancy, $city, $degrees, $majors, $jobfunc, $industry, $jobtype, $joblevel,
            $salary, $update_at, $applied, $totalApp, $eduEqual, $eduHigher, $expEqual, $expHigher);

        return $result;
    }

    public function showInterviewInv(Request $request)
    {
        $provinces = Provinces::all();
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        $totalApp = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)->count();
        $totalBook = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->count();
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->where('isApply', false)->count();

        $time = $request->time;

        return view('auth.seekers.dashboard-interview', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu', 'totalApp', 'totalBook', 'totalInvToApply', 'time'));
    }

    public function showQuizInv()
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
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->where('isApply', false)->count();

        return view('auth.seekers.dashboard-quiz', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu', 'totalApp', 'totalBook', 'totalInvToApply'));
    }

    public function showJobInvitation()
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
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->where('isApply', false)->count();

        $invToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->paginate(5);

        return view('auth.seekers.dashboard-toApply', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu', 'totalApp', 'totalBook', 'totalInvToApply', 'invToApply'));
    }

    public function applyJobInvitation(Request $request)
    {
        $invitation = Invitation::find(decrypt($request->invitation_id));
        $vacancy = Vacancies::find($invitation->vacancy_id);
        $userAgency = User::find(Agencies::find($invitation->agency_id)->user_id);

        if ($invitation->isApply == false) {
            $invitation->update(['isApply' => true]);

            return back()->with('vacancy', '' . $userAgency->name . '`s invitation is successfully applied! You don`t need to take the Online Test, so please check the Interview Invitation in your Dashboard.');

        } else {
            $invitation->update(['isApply' => false]);

            return back()->with('vacancy', 'Application for ' . $vacancy->judul . ' is successfully aborted!');
        }
    }

    public function recommendedVacancy(Request $request)
    {
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('isPost', true)->get();
        $provinces = Provinces::all();
        $totalApp = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)->count();
        $totalBook = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->count();
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->where('isApply', false)->count();

        $keyword = $request->q;
        $page = $request->page;

        return view('auth.seekers.dashboard-recommendedVacancy', compact('user', 'seeker', 'vacancies',
            'provinces', 'totalApp', 'totalBook', 'totalInvToApply', 'keyword', 'page'));
    }

    public function getRecommendedVacancy(Request $request)
    {
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        if ($seeker->educations->count()) {
            foreach ($seeker->educations as $education) {
                $degrees[] = $education->tingkatpend_id;
            }
        } else {
            $degrees = array();
        }

        $keyword = $request->q;
        $agency = Agencies::whereHas('user', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->get()->pluck('id')->toArray();
        if ($seeker->total_exp == "") {
            $totalExp = 0;
        } else {
            $totalExp = $seeker->total_exp;
        }
        $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->where('isPost', true)
            ->where('pengalaman', '<=', $totalExp)->where(function ($query) use ($degrees) {
                foreach ($degrees as $degree) {
                    $query->orWhere('tingkatpend_id', '<=', $degree);
                }
            })->orwhereIn('agency_id', $agency)->where('isPost', true)
            ->where('pengalaman', '<=', $totalExp)->where(function ($query) use ($degrees) {
                foreach ($degrees as $degree) {
                    $query->orWhere('tingkatpend_id', '<=', $degree);
                }
            })->paginate(6)->appends($request->only('q'))->toArray();

        $result = $this->array_vacancies($result);
        return $result;
    }

    private function array_vacancies($result)
    {
        $i = 0;
        foreach ($result['data'] as $vacancy) {
            if (substr(Cities::find($vacancy['cities_id'])->name, 0, 2) == "Ko") {
                $cities = substr(Cities::find($vacancy['cities_id'])->name, 5);
            } else {
                $cities = substr(Cities::find($vacancy['cities_id'])->name, 10);
            }

            $userAgency = User::findOrFail(Agencies::findOrFail($vacancy['agency_id'])->user_id);
            if ($userAgency->ava == "agency.png" || $userAgency->ava == "") {
                $filename = asset('images/agency.png');
            } else {
                $filename = asset('storage/users/' . $userAgency->ava);
            }

            $city = array('city' => $cities);
            $degrees = array('degrees' => Tingkatpend::findOrFail($vacancy['tingkatpend_id'])->name);
            $majors = array('majors' => Jurusanpend::findOrFail($vacancy['jurusanpend_id'])->name);
            $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacancy['fungsikerja_id'])->nama);
            $industry = array('industry' => Industri::findOrFail($vacancy['industry_id'])->nama);
            $jobtype = array('job_type' => JobType::findOrFail($vacancy['jobtype_id'])->name);
            $joblevel = array('job_level' => JobLevel::findOrFail($vacancy['joblevel_id'])->name);
            $salary = array('salary' => Salaries::findOrFail($vacancy['salary_id'])->name);
            $ava['user'] = array('ava' => $filename, 'name' => $userAgency->name, 'id' => $vacancy['agency_id']);
            $interview = array('interview_date' => is_null($vacancy['interview_date']) ? '-' :
                Carbon::parse($vacancy['interview_date'])->format('l, j F Y'));
            $startDate = array('recruitmentDate_start' => is_null($vacancy['recruitmentDate_start']) ? '-' :
                Carbon::parse($vacancy['recruitmentDate_start'])->format('j F Y'));
            $endDate = array('recruitmentDate_end' => is_null($vacancy['recruitmentDate_end']) ? '-' :
                Carbon::parse($vacancy['recruitmentDate_end'])->format('j F Y'));
            $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',
                $vacancy['updated_at'])->diffForHumans());
            $acc = array('acc' => Accepting::where('vacancy_id', $vacancy['id'])->where('isApply', true)->first());

            $result['data'][$i] = array_replace($ava, $result['data'][$i], $city, $degrees, $majors, $jobfunc,
                $industry, $jobtype, $joblevel, $salary, $interview, $startDate, $endDate, $update_at, $acc);
            $i = $i + 1;
        }

        return $result;
    }

    public function detailRecommendedVacancy($id)
    {
        $vacancy = Vacancies::find($id);
        $userAgency = User::findOrFail(Agencies::findOrFail($vacancy->agency_id)->user_id);
        if ($userAgency->ava == "agency.png" || $userAgency->ava == "") {
            $filename = asset('images/agency.png');
        } else {
            $filename = asset('storage/users/' . $userAgency->ava);
        }
        if (substr(Cities::find($vacancy->cities_id)->name, 0, 2) == "Ko") {
            $cities = substr(Cities::find($vacancy->cities_id)->name, 5);
        } else {
            $cities = substr(Cities::find($vacancy->cities_id)->name, 10);
        }
        $city = array('city' => $cities);
        $degrees = array('degrees' => Tingkatpend::findOrFail($vacancy->tingkatpend_id)->name);
        $majors = array('majors' => Jurusanpend::findOrFail($vacancy->jurusanpend_id)->name);
        $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacancy->fungsikerja_id)->nama);
        $industry = array('industry' => Industri::findOrFail($vacancy->industry_id)->nama);
        $jobtype = array('job_type' => JobType::findOrFail($vacancy->jobtype_id)->name);
        $joblevel = array('job_level' => JobLevel::findOrFail($vacancy->joblevel_id)->name);
        $salary = array('salary' => Salaries::findOrFail($vacancy->salary_id)->name);
        $ava['user'] = array('ava' => $filename, 'name' => $userAgency->name, 'id' => $vacancy->agency_id);
        $interview = array('interview_date' => is_null($vacancy->interview_date) ? '-' :
            Carbon::parse($vacancy->interview_date)->format('l, j F Y'));
        $recruitment = array('recruitment_date' => is_null($vacancy->recruitmentDate_start) &&
        is_null($vacancy->recruitmentDate_end) ? '-' : Carbon::parse($vacancy->recruitmentDate_start)
                ->format('j F Y') . ' - ' . Carbon::parse($vacancy->recruitmentDate_end)->format('j F Y'));
        $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',
            $vacancy->updated_at)->diffForHumans());

        $result = array_replace($ava, $vacancy->toArray(), $city, $degrees, $majors, $jobfunc,
            $industry, $jobtype, $joblevel, $salary, $interview, $recruitment, $update_at);

        return $result;
    }

    public function showBookmark()
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
        $totalInvToApply = Invitation::where('seeker_id', $seeker->id)->where('isInvite', true)->where('isApply', false)->count();

        $bookmark = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->paginate(5);

        return view('auth.seekers.dashboard-bookmarked', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu', 'totalApp', 'totalBook', 'totalInvToApply', 'bookmark'));
    }
}

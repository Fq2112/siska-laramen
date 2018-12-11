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
use App\Plan;
use App\PsychoTestInfo;
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
        $this->middleware('seeker.profile')->only('showProfile');
    }

    public function index()
    {
        $provinces = Provinces::all();
        $carousels = Carousel::all();
        $blogs = Blog::orderByDesc('id')->get();

        $id = [4, 9, 13, 26, 29, 30, 38, 40, 41, 45, 47, 49, 52, 58, 59, 61, 62, 63];
        $favIndustries = Industri::whereIn('id', $id)->get();

        $favAgency = FavoriteAgency::select('agency_id')->where('isFavorite', true)
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('agency_id')
            ->orderByDesc('count')
            ->limit(9)
            ->get()->pluck('agency_id')->toArray();

        if (count($favAgency) >= 9) {
            $agencies = Agencies::wherehas('vacancies')->whereIn('id', $favAgency)->orderByDesc('id')->take(9)->get();

        } else {
            $agencies = Agencies::wherehas('vacancies')->orderByDesc('updated_at')->take(9)->get();
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

        $invitation = Invitation::where('seeker_id', $seeker->id);

        return view('_seekers.profile-seeker', compact('provinces', 'seeker', 'user', 'attachments',
            'experiences', 'educations', 'trainings', 'organizations', 'languages', 'skills', 'job_title', 'last_edu',
            'invitation'));
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

    public function showDashboard()
    {
        $provinces = Provinces::all();
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        return view('auth.seekers.dashboard', compact('user', 'provinces', 'seeker', 'job_title',
            'last_edu'));
    }

    public function getAccVacancies(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $result = Accepting::where('seeker_id', $request->seeker_id)->whereBetween('created_at', [$start, $end])
            ->where('isApply', true)->orderByDesc('id')->paginate(6)->toArray();

        $result = $this->array_AccInv_vacancies($result);

        return $result;
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
            $query->where('tingkatpend_id', $reqEdu)->wherenotnull('end_period');
        })->wherehas('accepting', function ($query) use ($vacancy) {
            $query->where('vacancy_id', $vacancy['id']);
        })->count());
        $eduHigher = array('edu_higher' => Seekers::wherehas('educations', function ($query) use ($reqEdu) {
            $query->where('tingkatpend_id', '>', $reqEdu)->wherenotnull('end_period');
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

    public function showQuizInv()
    {
        $user = Auth::user();
        $provinces = Provinces::all();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        $quizInv = Accepting::wherehas('getVacancy', function ($vac) {
            $vac->wherenotnull('quizDate_start')->wherenotnull('quizDate_end')
                ->where('quizDate_start', '<=', today()->addDay())
                ->where('quizDate_end', '>=', today());
        })->where('seeker_id', $seeker->id)->where('isApply', true)->orderByDesc('id')->get();

        return view('auth.seekers.dashboard-quiz', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu', 'quizInv'));
    }

    public function showPsychoTestInv()
    {
        $user = Auth::user();
        $provinces = Provinces::all();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        $findRoom = PsychoTestInfo::whereHas('getVacancy', function ($vac) use ($seeker) {
            $vac->whereHas('getAccepting', function ($acc) use ($seeker) {
                $acc->where('seeker_id', $seeker->id)->where('isApply', true);
            })->whereHas('getQuizInfo', function ($info) use ($seeker) {
                $info->whereHas('getQuizResult', function ($res) use ($seeker) {
                    $res->where('seeker_id', $seeker->id)->where('isPassed', true);
                });
            });
        })->first();

        $candidate = '';
        if ($findRoom != null) {
            foreach ($findRoom->room_codes as $room) {
                strtok($room, '_');
                $participantID = strtok('');
                if ($seeker->id == $participantID) {
                    $candidate = $seeker->id;
                }
            }
        }

        $psychoTestInv = Accepting::wherehas('getVacancy', function ($vac) use ($candidate) {
            $vac->whereHas('getQuizInfo', function ($info) use ($candidate) {
                $info->whereHas('getQuizResult', function ($res) use ($candidate) {
                    $res->where('seeker_id', $candidate)->where('isPassed', true);
                });
            })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')
                ->where('psychoTestDate_start', '<=', today()->addDay())
                ->where('psychoTestDate_end', '>=', today());
        })->where('seeker_id', $candidate)->where('isApply', true)->orderByDesc('id')->get();

        return view('auth.seekers.dashboard-psychoTest', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu', 'psychoTestInv'));
    }

    public function showJobInvitation()
    {
        $provinces = Provinces::all();
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $job_title = Experience::where('seeker_id', $seeker->id)->where('end_date', null)
            ->orderby('id', 'desc')->take(1);

        $last_edu = Education::where('seeker_id', $seeker->id)->wherenotnull('end_period')
            ->orderby('tingkatpend_id', 'desc')->take(1);

        return view('auth.seekers.dashboard-toApply', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu'));
    }

    public function getInvVacancies(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $result = Invitation::where('seeker_id', $request->seeker_id)->whereBetween('created_at', [$start, $end])
            ->orderByDesc('id')->paginate(6)->toArray();

        $result = $this->array_AccInv_vacancies($result);

        return $result;
    }

    private function array_AccInv_vacancies($result)
    {
        $i = 0;
        foreach ($result['data'] as $row) {
            $vacancy = Vacancies::find($row['vacancy_id']);
            $plan = Plan::find($vacancy->plan_id);

            $cities = substr(Cities::find($vacancy->cities_id)->name, 0, 2) == "Ko" ?
                substr(Cities::find($vacancy->cities_id)->name, 5) :
                substr(Cities::find($vacancy->cities_id)->name, 10);

            $userAgency = $vacancy->agencies->user;
            $filename = $userAgency->ava == "agency.png" || $userAgency->ava == "" ?
                asset('images/agency.png') : asset('storage/users/' . $userAgency->ava);

            $judul['vacancy'] = array('id' => $vacancy->id, 'judul' => $vacancy->judul, 'city' => $cities,
                'degrees' => Tingkatpend::findOrFail($vacancy->tingkatpend_id)->name,
                'majors' => Jurusanpend::findOrFail($vacancy->jurusanpend_id)->name,
                'job_func' => FungsiKerja::findOrFail($vacancy->fungsikerja_id)->nama,
                'industry' => Industri::findOrFail($vacancy->industry_id)->nama,
                'job_type' => JobType::findOrFail($vacancy->jobtype_id)->name,
                'job_level' => JobLevel::findOrFail($vacancy->joblevel_id)->name,
                'salary' => Salaries::findOrFail($vacancy->salary_id)->name,
                'interview_date' => is_null($vacancy->interview_date) ? '-' :
                    Carbon::parse($vacancy->interview_date)->format('l, j F Y'),
                'recruitmentDate_start' => is_null($vacancy->recruitmentDate_start) ? '-' :
                    Carbon::parse($vacancy->recruitmentDate_start)->format('j F Y'),
                'recruitmentDate_end' => is_null($vacancy->recruitmentDate_end) ? '-' :
                    Carbon::parse($vacancy->recruitmentDate_end)->format('j F Y'),
                'quizDate' => is_null($vacancy->quizDate_start) || is_null($vacancy->quizDate_end) ? '-' :
                    Carbon::parse($vacancy->quizDate_start)->format('j F Y') . ' - ' .
                    Carbon::parse($vacancy->quizDate_end)->format('j F Y'),
                'psychoTestDate' => is_null($vacancy->psychoTestDate_start) || is_null($vacancy->psychoTestDate_end) ?
                    '-' : Carbon::parse($vacancy->psychoTestDate_start)->format('j F Y') . ' - ' .
                    Carbon::parse($vacancy->psychoTestDate_end)->format('j F Y'),
                'total_app' => Accepting::where('vacancy_id', $vacancy->id)->where('isApply', true)->count(),
                'isQuiz' => $plan->isQuiz,
                'isPsychoTest' => $plan->isPsychoTest,
                'checkDate_end' => is_null($vacancy->recruitmentDate_end) ? '-' : $vacancy->recruitmentDate_end,
                'created_at' => Carbon::parse($vacancy->created_at)->format('j F Y'),
                'updated_at' => Carbon::parse($vacancy->updated_at)->diffForHumans()
            );

            $ava['user'] = array('ava' => $filename, 'name' => $userAgency->name, 'id' => $vacancy->agency_id);

            $created_at = array('created_at' => Carbon::parse($row['created_at'])->format('j F Y'));
            $update_at = array('updated_at' => Carbon::parse($row['updated_at'])->diffForHumans());

            $result['data'][$i] = array_replace($ava, $result['data'][$i], $judul, $created_at, $update_at);
            $i = $i + 1;
        }

        return $result;
    }

    public function applyJobInvitation(Request $request)
    {
        $invitation = Invitation::find($request->invitation_id);
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
        $provinces = Provinces::all();

        $keyword = $request->q;
        $page = $request->page;

        return view('auth.seekers.dashboard-recommendedVacancy', compact('user', 'seeker', 'provinces',
            'keyword', 'page'));
    }

    public function getRecommendedVacancy(Request $request)
    {
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $totalExp = $seeker->total_exp != "" ? $seeker->total_exp : 0;
        $degrees = array();
        $educations = Education::whereHas('seekers', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })->wherenotnull('end_period')->get();
        if (count($educations) > 0) {
            foreach ($educations as $education) {
                $degrees[] = $education->tingkatpend_id;
            }
        }

        $keyword = $request->q;
        $agency = Agencies::whereHas('user', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->get()->pluck('id')->toArray();

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
            $plan = Plan::find($vacancy['plan_id']);

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
            $quizDate = array('quizDate' => is_null($vacancy['quizDate_start']) || is_null($vacancy['quizDate_end']) ?
                '-' : Carbon::parse($vacancy['quizDate_start'])->format('j F Y') . ' - ' .
                Carbon::parse($vacancy['quizDate_end'])->format('j F Y'));
            $psychoTestDate = array('psychoTestDate' => is_null($vacancy['psychoTestDate_start']) ||
            is_null($vacancy['psychoTestDate_end']) ? '-' : Carbon::parse($vacancy['psychoTestDate_start'])
                    ->format('j F Y') . ' - ' . Carbon::parse($vacancy['psychoTestDate_end'])
                    ->format('j F Y'));
            $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',
                $vacancy['updated_at'])->diffForHumans());
            $acc = array('acc' => Accepting::where('vacancy_id', $vacancy['id'])->where('isApply', true)->first());
            $bookmark = array('bookmark' => Accepting::where('vacancy_id', $vacancy['id'])
                ->where('isBookmark', true)->first());
            $totalApp = array('total_app' => Accepting::where('vacancy_id', $vacancy['id'])->where('isApply', true)->count());
            $isQuiz = array('isQuiz' => $plan->isQuiz);
            $isPsychoTest = array('isPsychoTest' => $plan->isPsychoTest);

            $result['data'][$i] = array_replace($ava, $result['data'][$i], $city, $degrees, $majors, $jobfunc,
                $industry, $jobtype, $joblevel, $salary, $interview, $startDate, $endDate, $update_at, $acc, $bookmark,
                $totalApp, $quizDate, $psychoTestDate, $isQuiz, $isPsychoTest);
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
        $quizDate = array('quizDate' => is_null($vacancy->quizDate_start) || is_null($vacancy->quizDate_end) ?
            '-' : Carbon::parse($vacancy->quizDate_start)->format('j F Y') . ' - ' .
            Carbon::parse($vacancy->quizDate_end)->format('j F Y'));
        $psychoTestDate = array('psychoTestDate' => is_null($vacancy->psychoTestDate_start) ||
        is_null($vacancy->psychoTestDate_end) ? '-' : Carbon::parse($vacancy->psychoTestDate_start)
                ->format('j F Y') . ' - ' . Carbon::parse($vacancy->psychoTestDate_end)->format('j F Y'));
        $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',
            $vacancy->updated_at)->diffForHumans());
        $isQuiz = array('isQuiz' => $vacancy->getPlan->isQuiz);
        $isPsychoTest = array('isPsychoTest' => $vacancy->getPlan->isPsychoTest);
        $totalApp = array('total_app' => Accepting::where('vacancy_id', $vacancy->id)->where('isApply', true)->count());

        $result = array_replace($ava, $vacancy->toArray(), $city, $degrees, $majors, $jobfunc, $industry, $jobtype,
            $joblevel, $salary, $interview, $recruitment, $update_at, $totalApp, $quizDate, $psychoTestDate,
            $isQuiz, $isPsychoTest);

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

        $bookmark = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->paginate(5);

        return view('auth.seekers.dashboard-bookmarked', compact('user', 'provinces', 'seeker',
            'job_title', 'last_edu', 'bookmark'));
    }

    public function getBookmarkedVacancies(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $result = Accepting::where('seeker_id', $request->seeker_id)->whereBetween('created_at', [$start, $end])
            ->where('isBookmark', true)->orderByDesc('id')->paginate(6)->toArray();

        $result = $this->array_AccInv_vacancies($result);

        return $result;
    }
}

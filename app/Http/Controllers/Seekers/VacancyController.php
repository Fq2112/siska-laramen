<?php

namespace App\Http\Controllers\Seekers;

use App\Accepting;
use App\Agencies;
use App\Carousel;
use App\Cities;
use App\Education;
use App\Experience;
use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\Jurusanpend;
use App\Provinces;
use App\Salaries;
use App\Seekers;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class VacancyController extends Controller
{
    public function __construct()
    {
        $this->middleware('seeker')->except(['showVacancy', 'detailVacancy']);

        $this->middleware('guest')->only(['showVacancy', 'detailVacancy']);
    }

    public function showVacancy(Request $request)
    {
        $provinces = Provinces::all();
        $salaries = Salaries::all();
        $job_functions = FungsiKerja::all();
        $industries = Industri::all();
        $degrees = Tingkatpend::all();
        $majors = Jurusanpend::all();

        $keyword = $request->q;
        $location = $request->loc;
        $sort = $request->sort;
        $salary_ids = $request->salary_ids;
        $jobfunc_ids = $request->jobfunc_ids;
        $industry_ids = $request->industry_ids;
        $degrees_ids = $request->degrees_ids;
        $majors_ids = $request->majors_ids;
        $page = $request->page;

        return view('_seekers.search-vacancy', compact('provinces', 'salaries', 'job_functions', 'industries',
            'degrees', 'majors', 'keyword', 'location', 'sort', 'salary_ids', 'jobfunc_ids', 'industry_ids',
            'degrees_ids', 'majors_ids', 'page'));
    }

    public function detailVacancy($id)
    {
        $provinces = Provinces::all();
        $vacancy = Vacancies::findOrFail($id);
        $carousels = Carousel::all();
        $agency = Agencies::find($vacancy->agency_id);
        $user = User::find(Agencies::find($vacancy->agency_id)->user_id);
        $city = Cities::find($vacancy->cities_id)->name;
        $salary = Salaries::find($vacancy->salary_id);
        $jobfunc = FungsiKerja::find($vacancy->fungsikerja_id);
        $joblevel = JobLevel::find($vacancy->joblevel_id);
        $industry = Industri::find($vacancy->industry_id);
        $degrees = Tingkatpend::find($vacancy->tingkatpend_id);
        $majors = Jurusanpend::find($vacancy->jurusanpend_id);
        $applicants = Accepting::where('vacancy_id', $vacancy->id)->where('isApply', true)->count();

        return view('_agencies.detail-vacancy', compact('provinces', 'vacancy', 'carousels', 'agency', 'user',
            'city', 'salary', 'jobfunc', 'joblevel', 'industry', 'degrees', 'majors', 'applicants'));
    }

    public function bookmarkVacancy(Request $request)
    {
        $vacancy = Vacancies::find($request->vacancy_id);
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $acc = Accepting::where('vacancy_id', $vacancy->id)->where('seeker_id', $seeker->id);

        if (!$acc->count()) {
            Accepting::create([
                'seeker_id' => $seeker->id,
                'vacancy_id' => $vacancy->id,
                'isBookmark' => true,
            ]);

            return back()->with('vacancy', '' . $vacancy->judul . ' is successfully bookmarked!');

        } else {
            if ($acc->first()->isBookmark == true) {
                $acc->first()->update(['isBookmark' => false]);

                if ($acc->first()->isApply == false) {
                    $acc->first()->delete();
                }

                return back()->with('vacancy', '' . $vacancy->judul . ' is successfully unmarked!');

            } else {
                $acc->first()->update(['isBookmark' => true]);

                return back()->with('vacancy', '' . $vacancy->judul . ' is successfully bookmarked!');
            }
        }
    }

    public function applyVacancy(Request $request)
    {
        $vacancy = Vacancies::find($request->vacancy_id);
        $user = Auth::user();
        $seeker = Seekers::where('user_id', $user->id)->firstOrFail();

        $acc = Accepting::where('vacancy_id', $vacancy->id)->where('seeker_id', $seeker->id);

        if (count($acc->get()) == 0) {
            Accepting::create([
                'seeker_id' => $seeker->id,
                'vacancy_id' => $vacancy->id,
                'isApply' => true,
            ]);

            return back()->with('vacancy', '' . $vacancy->judul . ' is successfully applied! Please check Application Status in your Dashboard.');

        } else {
            if ($acc->first()->isApply == true) {
                $acc->first()->update(['isApply' => false]);

                if ($acc->first()->isBookmark == false) {
                    $acc->first()->delete();
                }

                return back()->with('vacancy', 'Application for ' . $vacancy->judul . ' is successfully aborted!');

            } else {
                $acc->first()->update(['isApply' => true]);

                return back()->with('vacancy', '' . $vacancy->judul . ' is successfully applied! Please check Application Status in your Dashboard.');
            }
        }
    }

    public function getVacancyRequirement($id)
    {
        $vacancy = Vacancies::find($id);
        $seeker = Seekers::where('user_id', Auth::user()->id)->first();
        $edu = Education::where('seeker_id', $seeker->id)->get();
        $exp = Experience::where('seeker_id', $seeker->id)->get();

        $reqExp = filter_var($vacancy->pengalaman, FILTER_SANITIZE_NUMBER_INT);
        $checkEdu = Education::whereHas('seekers', function ($seeker) {
            $seeker->where('user_id', Auth::user()->id);
        })->where('tingkatpend_id', '>=', $vacancy->tingkatpend_id)->wherenotnull('end_period')->count();

        if (count($edu) == 0 || count($exp) == 0 || $seeker->phone == "" || $seeker->address == "" ||
            $seeker->birthday == "" || $seeker->gender == "") {
            return 0;
        } else {
            if ($seeker->total_exp < $reqExp) {
                return 1;
            } elseif ($checkEdu < 1) {
                return 2;
            } else {
                return 3;
            }
        }

    }
}

<?php

namespace App\Http\Controllers\Api\Clients;

use App\Accepting;
use App\Agencies;
use App\Cities;
use App\FavoriteAgency;
use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\Salaries;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VacanciesAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function favagency()
    {
        $favAgency = FavoriteAgency::select('agency_id')->where('isFavorite', true)
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('agency_id')
            ->orderByDesc('count')
            ->limit(9)
            ->get()->pluck('agency_id')->toArray();

        $agency = Agencies::whereIn('id',$favAgency)->get()->toArray();
        $array_agency = $this->array_agency($agency);
        return $array_agency;

    }

    public function array_agency($agency)
    {
        $data = 0;
        foreach ($agency as $item){
            $user = User::findOrFail(Agencies::findOrFail($item['id'])->user_id);
            if ($user->ava == "agency.png" || $user->ava == "") {
                $filename = asset('images/agency.png');
            } else {
                $filename = asset('storage/users/' . $user->ava);
            }
            $ava['user'] = array('ava' => $filename, 'name' => $user->name);
            $industry = array('industry' => Industri::findOrFail($item['industri_id'])->nama);
            $arr[$data] = array_replace($ava, $agency[$data], $industry);
            $data = $data + 1;
        }
        return $arr;
    }
    
    public function loadVacancies()
    {
        $vacancies = Vacancies::where('isPost', true)->get()->toArray();
        $vacancies = $this->array_vacancies($vacancies);

        return $vacancies;
    }

    public function loadVacanciesMobile($limit)
    {
//        dd($limit);
        $vacancies = Vacancies::where('isPost', true)->get()->take($limit)->toArray();
        $vacancies = $this->array_vacancies($vacancies);

        return $vacancies;
    }

    public function loadFavVacancies()
    {
        $favVacancy = Accepting::select('vacancy_id')->where('isApply', true)
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('vacancy_id')
            ->orderByDesc('count')
            ->limit(12)
            ->get()->pluck('vacancy_id')->toArray();

        if (count($favVacancy) >= 12) {
            $vacancies = Vacancies::whereIn('id', $favVacancy)->where('isPost', true)->orderByDesc('id')
                ->take(12)->get()->toArray();

        } else {
            $vacancies = Vacancies::orderByDesc('salary_id')->where('isPost', true)
                ->take(12)->get()->toArray();
        }

        $vacancies = $this->array_vacancies($vacancies);

        return $vacancies;
    }

    public function loadLateVacancies()
    {
        $vacancies = Vacancies::orderBy('updated_at', 'desc')->where('isPost', true)->take(16)->get()->toArray();
        $vacancies = $this->array_vacancies($vacancies);

        return $vacancies;
    }

    public function array_vacancies($vacancies)
    {
        $i = 0;
        foreach ($vacancies as $row) {

            if (substr(Cities::find($row['cities_id'])->name, 0, 2) == "Ko") {
                $cities = substr(Cities::find($row['cities_id'])->name, 5);
            } else {
                $cities = substr(Cities::find($row['cities_id'])->name, 10);
            }

            $user = User::findOrFail(Agencies::findOrFail($row['agency_id'])->user_id);
            if ($user->ava == "agency.png" || $user->ava == "") {
                $filename = asset('images/agency.png');
            } else {
                $filename = asset('storage/users/' . $user->ava);
            }

            $city = array('city' => $cities);
            $degrees = array('degrees' => Tingkatpend::findOrFail($row['tingkatpend_id'])->name);
            $majors = array('majors' => Jurusanpend::findOrFail($row['jurusanpend_id'])->name);
            $jobfunc = array('job_func' => FungsiKerja::findOrFail($row['fungsikerja_id'])->nama);
            $industry = array('industry' => Industri::findOrFail($row['industry_id'])->nama);
            $jobtype = array('job_type' => JobType::findOrFail($row['jobtype_id'])->name);
            $joblevel = array('job_level' => JobLevel::findOrFail($row['joblevel_id'])->name);
            $salary = array('salary' => Salaries::findOrFail($row['salary_id'])->name);
            $ava['user'] = array('ava' => $filename, 'name' => $user->name);
            $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $row['updated_at'])->diffForHumans());
            $arr[$i] = array_replace($ava, $vacancies[$i], $city, $degrees, $majors, $jobfunc, $industry, $jobtype, $joblevel, $salary, $update_at);

            $i = $i + 1;
        }

        return $arr;
    }

    public function getDetailAgency($agency_id)
    {
        $agency = Agencies::find($agency_id)->toArray();
        return response()->json([
            'data' => [
                $agency
            ]
        ]);
    }

    public function seeker()
    {
        $user = User::findOrFail($this->guard()->user()->id);
        $seeker = $user->seekers;
        return $seeker;
    }
    public function guard()
    {
        return Auth::guard('api');
    }

    public function getVacancyAgency($id)
    {

            $seeker = $this->seeker();
            $vacancies = Vacancies::find($id)->toArray();

            if (substr(Cities::find($vacancies['cities_id'])->name, 0, 2) == "Ko") {
                $cities = array('city' => substr(Cities::find($vacancies['cities_id'])->name, 5));
            } else {
                $cities = array('city' => substr(Cities::find($vacancies['cities_id'])->name, 10));
            }

//        $agency = Agencies::findOrFail($vacancies['agency_id'])->toArray();
//            $bookmark = App\Accepting::where('seeker_id',$seeker->id)->where('vacancy_id',$vacancies->id)->first()->isBookmark;
//            dd($bookmark);
            $degrees = array('degrees' => Tingkatpend::findOrFail($vacancies['tingkatpend_id'])->name);
            $majors = array('majors' => Jurusanpend::findOrFail($vacancies['jurusanpend_id'])->name);
            $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacancies['fungsikerja_id'])->nama);
            $industry = array('industry' => Industri::findOrFail($vacancies['industry_id'])->nama);
            $jobtype = array('job_type' => JobType::findOrFail($vacancies['jobtype_id'])->name);
            $joblevel = array('job_level' => JobLevel::findOrFail($vacancies['joblevel_id'])->name);
            $salary = array('salary' => Salaries::findOrFail($vacancies['salary_id'])->name);
            $total = array('total' => Accepting::where('vacancy_id', $id)->get()->count());
            $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $vacancies['updated_at'])->diffForHumans());
            $user = User::findOrFail(Agencies::findOrFail($vacancies['agency_id'])->user_id);
            if ($user->ava == "agency.png" || $user->ava == "") {
                $filename = asset('images/agency.png');
            } else {
                $filename = asset('storage/users/' . $user->ava);
            }

            $ava['user'] = array('ava' => $filename, 'name' => $user->name);
            $array = array_replace($vacancies, $salary, $degrees, $majors, $jobtype, $jobfunc, $industry, $joblevel, $update_at, $total, $ava, $cities);

            return $array;

    }
}

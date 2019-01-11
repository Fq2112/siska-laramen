<?php

namespace App\Http\Controllers\Api;

use App\Agencies;
use App\Cities;
use App\Http\Controllers\Api\Clients\VacanciesAPIController as Search;
use App\Http\Controllers\Controller;
use App\Vacancies;

;

class SearchAPICOntroller extends Controller
{
    public function search()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $q = $obj['q'];
        $agen = $obj['agen'];
        $loc = $obj['loc'];

        $salary = $obj['salary_ids'];
        $array_sal = explode(',', $salary);

        $job_func = $obj['jobfunc_ids'];
        $array_job = explode(',', $job_func);

        $industry = $obj['industry_ids'];
        $array_ind = explode(',', $industry);

        $degree = $obj['degree_ids'];
        $array_deg = explode(',', $degree);

        $major = $obj['major_ids'];
        $array_major = explode(',', $major);

        $agency = Agencies::whereHas('user', function ($query) use ($agen) {
            $query->where('name', 'like', '%' . $agen . '%');
        })->get()->pluck('id')->toArray();

//        dd($agency);
//      $city = Cities::where('name', 'like', '%' . $loc . '%')->get()->pluck('id')->toArray();
		$city = Cities::where('id', 'like',  $loc )->get()->pluck('id')->toArray();
//		dd($city);
//        $arr = Vacancies::where('judul', 'like', '%' . $q . '%')->whereIn('cities_id', $city)
//            ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)->where('isPost', true)->get()
//            ->toArray();

        $arr = Vacancies::when($agen, function ($query) use ($q, $agency) {
            $query->orwhereIn('agency_id', $agency);
        })->when($loc, function ($query) use ($city) {
            $query->whereIn('cities_id', $city);
        })->when($salary, function ($query) use ($array_sal) {
            $query->wherein('salary_id', $array_sal);
        })->when($job_func, function ($query) use ($array_job) {
            $query->wherein('fungsikerja_id', $array_job);
        })->when($industry, function ($query) use ($array_ind) {
            $query->wherein('industry_id', $array_ind);
        })->when($degree, function ($query) use ($array_deg) {
            $query->wherein('tingkatpend_id', $array_deg);
        })->when($major, function ($query) use ($array_major) {
            $query->wherein('jurusanpend_id', $array_major);
        })->where('judul', 'like', '%' . $q . '%')->where('isPost', true)->get()->toArray();



//        if ($salary != '' || $job_func != '' || $industry != '' || $degree != '' || $major != '') {
//
//        }
       // dd($arr);

        if(count($arr) < 1)
    {
        return response()->json([]);
    }

        return app(Search::class)->array_vacancies($arr);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Agencies;
use App\Cities;
use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\Salaries;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class SearchVacancyController extends Controller
{
    public function getSearchResult(Request $request)
    {
        $input = $request->all();

        if ($request->has(['q']) || $request->has(['loc'])) {
            $keyword = $input['q'];
            $location = $input['loc'];

            $city = Cities::where('name', 'like', '%' . $location . '%')->get()->pluck('id')->toArray();
            $agency = Agencies::whereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })->get()->pluck('id')->toArray();

            $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)->where('isPost', true)->paginate(12)
                ->appends($request->only(['q', 'loc']))->toArray();

            // sorting
            if ($request->has('sort')) {
                $sort = $input['sort'];
                if ($sort == 'latest') {
                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->orderBy('updated_at', 'desc')->where('isPost', true)->paginate(12)
                        ->appends($request->only(['q', 'loc']))->toArray();

                } elseif ($sort == 'highest_salary') {
                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->orderBy('salary_id', 'desc')->where('isPost', true)->paginate(12)
                        ->appends($request->only(['q', 'loc']))->toArray();

                } else {
                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)->where('isPost', true)->paginate(12)
                        ->appends($request->only(['q', 'loc']))->toArray();
                }
            }

            // filtering
            if ($request->has('salary_ids') || $request->has('jobfunc_ids') || $request->has('industry_ids')
                || $request->has('degrees_ids') || $request->has('majors_ids')) {

                // 1, 2, 3, 4, 5 (1 filter)
                if ($request->has('salary_ids')) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has('jobfunc_ids')) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has('industry_ids')) {
                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->wherein('industry_id', $industries)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->wherein('industry_id', $industries)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has('degrees_ids')) {
                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->wherein('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->wherein('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has('majors_ids')) {
                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->wherein('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->wherein('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }

                // 12, 13, 14, 15 (2 filters)
                if ($request->has(['salary_ids', 'jobfunc_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'industry_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'degrees_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'majors_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                // 23, 24, 25
                if ($request->has(['jobfunc_ids', 'industry_ids'])) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['jobfunc_ids', 'degrees_ids'])) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['jobfunc_ids', 'majors_ids'])) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                // 34, 35
                if ($request->has(['industry_ids', 'degrees_ids'])) {
                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['industry_ids', 'majors_ids'])) {
                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('industry_id', $industries)->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('industry_id', $industries)->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                // 45
                if ($request->has(['degrees_ids', 'majors_ids'])) {
                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('tingkatpend_id', $degrees)->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('tingkatpend_id', $degrees)->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }

                // 123, 124, 125, 134, 135, 145 (3 filters)
                if ($request->has(['salary_ids', 'jobfunc_ids', 'industry_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'jobfunc_ids', 'degrees_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'jobfunc_ids', 'majors_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'industry_ids', 'degrees_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'industry_ids', 'majors_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'degrees_ids', 'majors_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                // 234, 235, 245
                if ($request->has(['jobfunc_ids', 'industry_ids', 'degrees_ids'])) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['jobfunc_ids', 'industry_ids', 'majors_ids'])) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['jobfunc_ids', 'degrees_ids', 'majors_ids'])) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                // 345
                if ($request->has(['industry_ids', 'degrees_ids', 'majors_ids'])) {
                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }

                // 1234, 1235, 1345 (4 filters)
                if ($request->has(['salary_ids', 'jobfunc_ids', 'industry_ids', 'degrees_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'jobfunc_ids', 'industry_ids', 'majors_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                if ($request->has(['salary_ids', 'industry_ids', 'degrees_ids', 'majors_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
                // 2345
                if ($request->has(['jobfunc_ids', 'industry_ids', 'degrees_ids', 'majors_ids'])) {
                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('fungsikerja_id', $fungsikerja)->whereIn('industry_id', $industries)
                        ->whereIn('tingkatpend_id', $degrees)->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }

                // 12345 (5 filters)
                if ($request->has(['salary_ids', 'jobfunc_ids', 'industry_ids', 'degrees_ids', 'majors_ids'])) {
                    $sal_select = $input['salary_ids'];
                    $sal_ids = '';
                    foreach ((array)$sal_select as $select) {
                        $sal_ids .= $select . ', ';
                    }
                    $sal_ids = explode(",", substr($sal_ids, 0, -2));
                    $salaries = Salaries::whereIn('id', $sal_ids)->get()->pluck('id')->toArray();

                    $jf_select = $input['jobfunc_ids'];
                    $jf_ids = '';
                    foreach ((array)$jf_select as $select) {
                        $jf_ids .= $select . ', ';
                    }
                    $jf_ids = explode(",", substr($jf_ids, 0, -2));
                    $fungsikerja = FungsiKerja::whereIn('id', $jf_ids)->get()->pluck('id')->toArray();

                    $in_select = $input['industry_ids'];
                    $in_ids = '';
                    foreach ((array)$in_select as $select) {
                        $in_ids .= $select . ', ';
                    }
                    $in_ids = explode(",", substr($in_ids, 0, -2));
                    $industries = Industri::whereIn('id', $in_ids)->get()->pluck('id')->toArray();

                    $de_select = $input['degrees_ids'];
                    $de_ids = '';
                    foreach ((array)$de_select as $select) {
                        $de_ids .= $select . ', ';
                    }
                    $de_ids = explode(",", substr($de_ids, 0, -2));
                    $degrees = Tingkatpend::whereIn('id', $de_ids)->get()->pluck('id')->toArray();

                    $ma_select = $input['majors_ids'];
                    $ma_ids = '';
                    foreach ((array)$ma_select as $select) {
                        $ma_ids .= $select . ', ';
                    }
                    $ma_ids = explode(",", substr($ma_ids, 0, -2));
                    $majors = Jurusanpend::whereIn('id', $ma_ids)->get()->pluck('id')->toArray();

                    $result = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)
                        ->whereIn('salary_id', $salaries)->whereIn('fungsikerja_id', $fungsikerja)
                        ->whereIn('industry_id', $industries)->whereIn('tingkatpend_id', $degrees)
                        ->whereIn('jurusanpend_id', $majors)
                        ->where('isPost', true)->paginate(12)->appends($request->only(['q', 'loc']))->toArray();
                }
            }

        } else {
            $result = Vacancies::where('isPost', true)->paginate(12)->toArray();
        }
        $result = $this->array_vacancies($result);
        return $result;
    }

    private function array_vacancies($result)
    {
        $i = 0;
        foreach ($result['data'] as $row) {

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
            $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $row['updated_at'])
                ->diffForHumans());

            $result['data'][$i] = array_replace($ava, $result['data'][$i], $city, $degrees, $majors, $jobfunc,
                $industry, $jobtype, $joblevel, $salary, $update_at);

            $i = $i + 1;
        }

        return $result;
    }
}

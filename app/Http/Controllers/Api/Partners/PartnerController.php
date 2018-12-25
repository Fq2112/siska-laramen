<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\Cities;
use App\Http\Controllers\Api\SearchVacancyController as Search;
use App\Vacancies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    public function getPartnerInfo(Request $request)
    {
        $partner = $request->partner;
        $instansi = array('name' => $partner->name, 'email' => $partner->email, 'phone' => $partner->phone);
        $api = array('key' => $partner->api_key, 'secret' => $partner->api_secret,
            'expiry' => Carbon::parse($partner->api_expiry)->format('l, j F Y'),
            'created_at' => Carbon::parse($partner->created_at)->format('l, j F Y'),
            'updated_at' => Carbon::parse($partner->updated_at)->diffForHumans());

        $result = array_replace($instansi, $api);
        return $result;
    }

    public function syncVacancies(Request $request)
    {
        $vacancies = $request->vacancies;

        /*foreach ($vacancies as $vacancy) {
            Vacancies::create([
                'judul' => $vacancy['judul'],
                'cities_id' => $vacancy['city_id'],
                'syarat' => $vacancy['syarat'],
                'tanggungjawab' => $vacancy['tanggungjawab'],
                'pengalaman' => $vacancy['pengalaman'],
                'jobtype_id' => $vacancy['jobtype_id'],
                'industry_id' => $vacancy['industry_id'],
                'joblevel_id' => $vacancy['joblevel_id'],
                'salary_id' => $vacancy['salary_id'],
                'agency_id' => $vacancy['agency_id'],
                'tingkatpend_id' => $vacancy['degree_id'],
                'jurusanpend_id' => $vacancy['major_id'],
                'fungsikerja_id' => $vacancy['jobfunction_id'],
                'recruitmentDate_start' => $vacancy['recruitmentDate_start'],
                'recruitmentDate_end' => $vacancy['recruitmentDate_end'],
                'interview_date' => $vacancy['interview_date'],
            ]);
        }*/

        $status = count($vacancies) > 1 ? count($vacancies) . ' vacancies!' : 'a vacancy!';

        return response()->json([
            'status' => "200 OK",
            'success' => true,
            'message' => 'Successfully synchronized ' . $status
        ], 200);
    }

    public function getVacancies(Request $request)
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

        } else {
            $result = Vacancies::where('isPost', true)->paginate(12)->toArray();
        }

        return app(Search::class)->array_vacancies($result);
    }
}

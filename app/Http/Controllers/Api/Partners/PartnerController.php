<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\Cities;
use App\Http\Controllers\Api\SearchVacancyController as Search;
use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
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

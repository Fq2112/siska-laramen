<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\Cities;
use App\PartnerVacancy;
use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    public function getVacancies(Request $request)
    {
        $partner = $request->partner;
        $check = $partner->getPartnerVacancy;
        $vac = [];
        foreach ($check as $row) {
            $vac[] = $row->getVacancy;
        }
        $data = $this->getDatas($partner->api_key != null ? $vac : Vacancies::where('isPost', true)->get());

        return $data;
        $keyword = $request->q;
        $location = $request->loc;

        $city = Cities::where('name', 'like', '%' . $location . '%')->get()->pluck('id')->toArray();
        $agency = Agencies::whereHas('user', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->get()->pluck('id')->toArray();

        $vacancies = Vacancies::where('judul', 'like', '%' . $keyword . '%')->whereIn('cities_id', $city)
            ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)->where('isPost', true)->get()->toArray();

        return $vacancies;
    }

    private function getDatas($ar)
    {
        $ars = [];
//        if (!empty($ar)) {
        foreach ($ar as $row) {
            $ars[] = $row;
        }
//        }

        return $ars;
    }
}

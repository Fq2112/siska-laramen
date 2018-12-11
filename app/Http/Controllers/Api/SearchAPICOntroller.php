<?php

namespace App\Http\Controllers\Api;

use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Clients\VacanciesAPIController as Search;
class SearchAPICOntroller extends Controller
{
    public function search()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $q = $obj['q'];
        $loc = $obj['loc'];

        $vacancy = Vacancies::when($q, function ($query) use($q){
            $query->where('judul', 'like', '%' . $q . '%');
        })->get()->toArray();

       // dd($vacancy);

        return app(Search::class)->array_vacancies($vacancy);
    }


}

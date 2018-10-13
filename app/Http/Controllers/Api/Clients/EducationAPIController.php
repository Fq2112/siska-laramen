<?php

namespace App\Http\Controllers\Api\Clients;

use App\Jurusanpend;
use App\Tingkatpend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducationAPIController extends Controller
{
    public function loadEducationDegree()
    {
        $degree = Tingkatpend::all()->toArray();
        return $degree;
    }

    public function loadEducationMajor()
    {
        $major = Jurusanpend::all()->toArray();
        return $major;
    }
}

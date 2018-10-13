<?php

namespace App\Http\Controllers\Api\Clients;

use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\JobType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobAPIController extends Controller
{
    public function loadJobLevel()
    {
        $joblevel = JobLevel::all()->toArray();
        return $joblevel;
    }

    public function loadJobFunction()
    {
        $jobfunc = FungsiKerja::all()->toArray();
        return $jobfunc;
    }

    public function loadJobType()
    {
        $jobtype = JobType::all()->toArray();
        return $jobtype;
    }

    public function loadIndustry()
    {
        $industry = Industri::all()->toArray();
        return $industry;
    }
}

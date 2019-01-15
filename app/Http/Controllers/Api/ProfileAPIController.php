<?php

namespace App\Http\Controllers\Api;

use App\Cities;
use App\Education;
use App\Experience;
use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\Organization;
use App\Seekers;
use App\Tingkatpend;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileAPIController extends Controller
{
    public function show()
    {

        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        if ($user['ava'] == "seeker.png" || $user['ava'] == "") {
            $filename = asset('images/seeker.png');
        } else {
            $filename = asset('storage/users/' . $user['ava']);
        }
        $ava['source'] = array('ava' => $filename, 'name' => $user['name']);
        $seeker = Seekers::where('user_id',$user['id'])->first()->toArray();
        //seeker Section
        $seek['seeker'] = array('data'=>$seeker);

        $exp = Experience::where('seeker_id', $seeker['id'])->get()->toArray();
        $exp = $this->array_exp($exp);
        $exparray['exp'] = array('data'=>$exp);

        $edu = Education::where('seeker_id',$seeker['id'])->get()->toArray();
        $edus = $this->educations($edu);
        $arrayedu['educations'] = array('data' => $edus);

        $organization = Organization::where('seeker_id',$seeker['id'])->get()->toArray();
        $arrayorganization['organization'] = array('data' => $organization);

        $array = array_replace($user,$ava,$seek,$exparray,$arrayedu,$arrayorganization);
        return response()->json($array);
    }

    public function educations($edu)
    {   $i = 0;
        foreach ($edu as $item) {

            $degrees = array('degrees' => Tingkatpend::findOrFail($item['tingkatpend_id'])->name);
            $majors = array('majors' => Jurusanpend::findOrFail($item['jurusanpend_id'])->name);

            $arr[$i]= array_replace($edu[$i],$degrees,$majors);
            $i= $i+1;
        }

        return $arr;
    }

    public function array_exp($exp)
    {
        $i = 0;
        foreach ($exp as $data){
            if (substr(Cities::find($data['city_id'])->name, 0, 2) == "Ko") {
                $cities = substr(Cities::find($data['city_id'])->name, 5);
            } else {
                $cities = substr(Cities::find($data['city_id'])->name, 10);
            }

            $city = array('city' => $cities);
            $jobfunc = array('job_func' => FungsiKerja::findOrFail($data['fungsikerja_id'])->nama);
            $industry = array('industry' => Industri::findOrFail($data['industri_id'])->nama);
            $jobtype = array('job_type' => JobType::findOrFail($data['jobtype_id'])->name);
            $joblevel = array('job_level' => JobLevel::findOrFail($data['joblevel_id'])->name);
            $arr[$i] = array_replace($exp[$i], $city,  $jobfunc, $industry, $jobtype, $joblevel);
            $i = $i + 1;
        }
        return $arr;
    }
    
    public function me()
    {
        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        if ($user['ava'] == "seeker.png" || $user['ava'] == "") {
            $filename = asset('images/seeker.png');
        } else {
            $filename = asset('storage/users/' . $user['ava']);
        }
        $ava['user'] = array('ava' => $filename, 'name' => $user['name']);
        $array = array_replace($user, $ava);
        return response()->json($array);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}

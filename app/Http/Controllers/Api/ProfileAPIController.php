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
        $seeker = Seekers::where('user_id', $user['id'])->first()->toArray();
        //seeker Section
        $seek['seeker'] = array('data' => $seeker);

        $exp = Experience::where('seeker_id', $seeker['id'])->get()->toArray();
        $exp = $this->array_exp($exp);
        $exparray['exp'] = array('data' => $exp);

        $edu = Education::where('seeker_id', $seeker['id'])->get()->toArray();
        $edus = $this->educations($edu);
        $arrayedu['educations'] = array('data' => $edus);

        $organization = Organization::where('seeker_id', $seeker['id'])->get()->toArray();
        $arrayorganization['organization'] = array('data' => $organization);

        $array = array_replace($user, $ava, $seek, $exparray, $arrayedu, $arrayorganization);
        return response()->json($array);
    }

    public function educations($edu)
    {
        $i = 0;
        foreach ($edu as $item) {

            $degrees = array('degrees' => Tingkatpend::findOrFail($item['tingkatpend_id'])->name);
            $majors = array('majors' => Jurusanpend::findOrFail($item['jurusanpend_id'])->name);

            $arr[$i] = array_replace($edu[$i], $degrees, $majors);
            $i = $i + 1;
        }

        return $arr;
    }

    public function array_exp($exp)
    {
        $i = 0;
        foreach ($exp as $data) {
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
            $arr[$i] = array_replace($exp[$i], $city, $jobfunc, $industry, $jobtype, $joblevel);
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

    public function show_personal()
    {
        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first()->toArray();

        return response()->json($seeker);
    }

    public function save_personal()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $background = $obj['background'];
        $phone = $obj['phone'];
        $address = $obj['address'];
        $zip_code = $obj['zip_code'];
        $birthday = $obj['birthday'];
        $gender = $obj['gender'];
        $relationship = $obj['relationship'];
        $nationality = $obj['nationality'];
        $website = $obj['website'];
        $lowest_salary = $obj['lowest_salary'];
        $highest_salary = $obj['highest_salary'];
        $summary = $obj['summary'];
        $video_summary = $obj['video_summary'];

        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();

        $seeker->update([
            "background" => $background,
            "phone" => $phone,
            "address" => $address,
            "zip_code" => $zip_code,
            "birthday" => $birthday,
            "gender" => $gender,
            "relationship" => $relationship,
            "nationality"=> $nationality,
            "website" => $website,
            "lowest_salary" => $lowest_salary,
            "highest_salary" => $highest_salary,
            "summary" => $summary,
            "video_summary" => $video_summary,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Your personal data successfully added'
        ]);
    }

    public function show_education($id)
    {
        $edu = Education::findOrFail($id)->toArray();
        $plus['more'] = array('degree' => Tingkatpend::findOrFail($edu['tingkatpend_id'])->name,
            'major' => Jurusanpend::findOrFail($edu['jurusanpend_id'])->name);

        $arr = array_replace($edu, $plus);

        return response()->json($arr);

    }

    public function save_education()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $degree = $obj['tingkatpend_id'];
        $major = $obj['jurusanpend_id'];
        $awards = $obj['awards'];
        $school_name = $obj['school_name'];
        $start_period = $obj['start_period'];
        $end_period = $obj['end_period'];
        $nilai = $obj['nilai'];

        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();
        //dd($user);
        if ($major == null || $degree == null || $awards == null || $school_name == null || $start_period == null || $end_period == null || $nilai == null) {
            return response()->json([
                'status' => 'Warning',
                'success' => false,
                'message' => 'Some data not filled yet!!'
            ]);
        }

        Education::create([
            "seeker_id" => $seeker->id,
            "tingkatpend_id" => $degree,
            "jurusanpend_id" => $major,
            "awards" => $awards,
            "school_name" => $school_name,
            "start_period" => $start_period,
            "end_period" => $end_period,
            "nilai" => $nilai,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Education data successfully added'
        ]);
    }

    public function update_education()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $id = $obj['id'];
        $degree = $obj['tingkatpend_id'];
        $major = $obj['jurusanpend_id'];
        $awards = $obj['awards'];
        $school_name = $obj['school_name'];
        $start_period = $obj['start_period'];
        $end_period = $obj['end_period'];
        $nilai = $obj['nilai'];

        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();
        //dd($user);
        if ($id == null || $major == null || $degree == null || $awards == null || $school_name == null || $start_period == null || $end_period == null || $nilai == null) {
            return response()->json([
                'status' => 'Warning',
                'success' => false,
                'message' => 'Some data not filled yet!!'
            ]);
        }
        $edu = Education::findOrFail($id);

        $edu->update([
            "seeker_id" => $seeker->id,
            "tingkatpend_id" => $degree,
            "jurusanpend_id" => $major,
            "awards" => $awards,
            "school_name" => $school_name,
            "start_period" => $start_period,
            "end_period" => $end_period,
            "nilai" => $nilai,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Education data successfully updated'
        ]);
    }

    public function delete_education($id)
    {
        $edu = Education::findOrFail($id);
        $edu->delete();
        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Education data successfully remove'
        ]);
    }

    public function show_exp($id)
    {
        $exp = Experience::findOrFail($id)->toArray();
        $plus['more'] = array(
            'job_func' => FungsiKerja::findOrFail($exp['fungsikerja_id'])->nama,
            'industry' => Industri::findOrFail($exp['industri_id'])->nama,
            'job_type' => JobType::findOrFail($exp['jobtype_id'])->name,
            'job_level' => JobLevel::findOrFail($exp['joblevel_id'])->name

        );

        $arr = array_replace($exp, $plus);

        return response()->json($arr);

    }

    public function save_exp()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $job_title = $obj['job_title'];
        $joblevel_id = $obj['joblevel_id'];
        $company = $obj['company'];
        $fungsikerja_id = $obj['fungsikerja_id'];
        $industri_id = $obj['industri_id'];
        $city_id = $obj['city_id'];
        $salary_id = $obj['salary_id'];
        $start_date = $obj['start_date'];
        $end_date = $obj['end_date'];
        $jobtype_id = $obj['jobtype_id'];
        $report_to = $obj['report_to'];
        $job_desc = $obj['job_desc'];

        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();
        //dd($user);
        if ($job_title == null || $joblevel_id == null || $company == null || $fungsikerja_id == null ||
            $industri_id == null || $city_id == null || $start_date == null || $end_date == null || $jobtype_id == null
            || $report_to == null || $job_desc == null || $salary_id == null) {
            return response()->json([
                'status' => 'Warning',
                'success' => false,
                'message' => 'Some data not filled yet!!'
            ]);
        }

        Experience::create([
            "seeker_id" => $seeker->id,
            "job_title" => $job_title,
            "joblevel_id" => $joblevel_id,
            "company" => $company,
            "fungsikerja_id" => $fungsikerja_id,
            "industri_id" => $industri_id,
            "city_id" => $city_id,
            "salary_id" => $salary_id,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "jobtype_id" => $jobtype_id,
            "report_to" => $report_to,
            "job_desc" => $job_desc,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Experience data successfully added'
        ]);
    }

    public function update_exp()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $id = $obj['id'];
        $job_title = $obj['job_title'];
        $joblevel_id = $obj['joblevel_id'];
        $company = $obj['company'];
        $fungsikerja_id = $obj['fungsikerja_id'];
        $industri_id = $obj['industri_id'];
        $city_id = $obj['city_id'];
        $salary_id = $obj['salary_id'];
        $start_date = $obj['start_date'];
        $end_date = $obj['end_date'];
        $jobtype_id = $obj['jobtype_id'];
        $report_to = $obj['report_to'];
        $job_desc = $obj['job_desc'];

        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();
        //dd($user);
        if ($job_title == null || $joblevel_id == null || $company == null || $fungsikerja_id == null ||
            $industri_id == null || $city_id == null || $start_date == null || $end_date == null || $jobtype_id == null
            || $report_to == null || $job_desc == null || $salary_id == null) {
            return response()->json([
                'status' => 'Warning',
                'success' => false,
                'message' => 'Some data not filled yet!!'
            ]);
        }

        $exp = Experience::findOrFail($id);

        $exp->update([
            "seeker_id" => $seeker->id,
            "job_title" => $job_title,
            "joblevel_id" => $joblevel_id,
            "company" => $company,
            "fungsikerja_id" => $fungsikerja_id,
            "industri_id" => $industri_id,
            "city_id" => $city_id,
            "salary_id" => $salary_id,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "jobtype_id" => $jobtype_id,
            "report_to" => $report_to,
            "job_desc" => $job_desc,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Experience data successfully updated'
        ]);
    }

    public function delete_exp($id)
    {
        $exp = Experience::findOrFail($id);
        $exp->delete();
        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Experience data successfully remove'
        ]);
    }

    public function show_organization($id)
    {
        $or = Organization::findOrFail($id)->toArray();

        return response()->json($or);

    }

    public function save_organization()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $name = $obj['name'];
        $start_period = $obj['start_period'];
        $end_period = $obj['end_period'];
        $title = $obj['title'];
        $descript = $obj['descript'];


        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();
        //dd($user);
        if ($name == null || $start_period == null || $end_period == null || $title == null ||
            $descript == null) {
            return response()->json([
                'status' => 'Warning',
                'success' => false,
                'message' => 'Some data not filled yet!!'
            ]);
        }

        Organization::create([
            "seeker_id" => $seeker->id,
            "name" => $name,
            "start_period" => $start_period,
            "end_period" => $end_period,
            "title" => $title,
            "descript" => $descript,

        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Organization data successfully added'
        ]);
    }

    public function update_organization()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $id = $obj['id'];
        $name = $obj['name'];
        $start_period = $obj['start_period'];
        $end_period = $obj['end_period'];
        $title = $obj['title'];
        $descript = $obj['descript'];


        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();
        //dd($user);
        if ($name == null || $start_period == null || $end_period == null || $title == null ||
            $descript == null) {
            return response()->json([
                'status' => 'Warning',
                'success' => false,
                'message' => 'Some data not filled yet!!'
            ]);
        }
        $or = Organization::findOrFail($id);

        $or->update([
            "seeker_id" => $seeker->id,
            "name" => $name,
            "start_period" => $start_period,
            "end_period" => $end_period,
            "title" => $title,
            "descript" => $descript,

        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Organization data successfully updated'
        ]);
    }

    public function delete_organization($id)
    {
        $or = Organization::findOrFail($id);
        $or->delete();
        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Organization data successfully remove'
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}

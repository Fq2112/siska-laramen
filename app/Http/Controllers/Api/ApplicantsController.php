<?php

namespace App\Http\Controllers\Api;

use App\Accepting;
use App\Agencies;
use App\Cities;
use App\Education;
use App\Experience;
use App\FungsiKerja;
use App\Http\Controllers\Controller;
use App\Industri;
use App\Invitation;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\Salaries;
use App\Seekers;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use App\Http\Controllers\Api\Clients\VacanciesAPIController as Search;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApplicantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get Current User
     *
     * @return mixed
     */
    public function seeker()
    {
        $user = User::findOrFail($this->guard()->user()->id);
        $seeker = $user->seekers;
        return $seeker;
    }

    public function getDetail($id)
    {

        $seeker = $this->seeker();
        $vacancies = Vacancies::find($id)->toArray();

        if (substr(Cities::find($vacancies['cities_id'])->name, 0, 2) == "Ko") {
            $cities = array('city' => substr(Cities::find($vacancies['cities_id'])->name, 5));
        } else {
            $cities = array('city' => substr(Cities::find($vacancies['cities_id'])->name, 10));
        }

        $agency = Agencies::findOrFail($vacancies['agency_id'])->toArray();

        $bookmark = Accepting::where('seeker_id', $seeker->id)->where('vacancy_id', $vacancies['id'])->first()->isBookmark ?? false;
        $apply = Accepting::where('seeker_id', $seeker->id)->where('vacancy_id', $vacancies['id'])->first()->isApply ?? false;
        $book = array('bookmark' => $bookmark == '1' ? true : false);
        $app = array('apply' => $apply == '1' ? true : false);
        $degrees = array('degrees' => Tingkatpend::findOrFail($vacancies['tingkatpend_id'])->name);
        $majors = array('majors' => Jurusanpend::findOrFail($vacancies['jurusanpend_id'])->name);
        $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacancies['fungsikerja_id'])->nama);
        $industry = array('industry' => Industri::findOrFail($vacancies['industry_id'])->nama);
        $jobtype = array('job_type' => JobType::findOrFail($vacancies['jobtype_id'])->name);
        $joblevel = array('job_level' => JobLevel::findOrFail($vacancies['joblevel_id'])->name);
        $salary = array('salary' => Salaries::findOrFail($vacancies['salary_id'])->name);
        $total = array('total' => Accepting::where('vacancy_id', $id)->get()->count());
        $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $vacancies['updated_at'])->diffForHumans());
        $user = User::findOrFail(Agencies::findOrFail($vacancies['agency_id'])->user_id);
        if ($user->ava == "agency.png" || $user->ava == "") {
            $filename = asset('images/agency.png');
        } else {
            $filename = asset('storage/users/' . $user->ava);
        }

        $ava['user'] = array('ava' => $filename, 'name' => $user->name);
        $array = array_replace($vacancies, $salary, $degrees, $majors, $jobtype, $jobfunc, $industry, $joblevel, $update_at, $total, $ava, $cities, $book, $app);

        return $array;
    }

    public function update_pass()
    {
        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $pass = $obj['password'];
            $newpass = $obj['newpassword'];
            $repass = $obj['repassword'];

            $user = User::find($this->guard()->user()->id);

            if (!Hash::check($pass, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => "Your Current Password is Wrong!!"
                ], 200);
            } else {
                if ($newpass != $repass) {
                    return response()->json([
                        'success' => false,
                        'message' => "Your new password doesn't match!!"
                    ], 200);
                } else {
                    $user->update([
                        "password" => bcrypt($newpass)
                    ]);
                    return response()->json([
                        'success' => true,
                        'message' => 'Password Successfully Changed'
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e
            ], 500);
        }
    }

    public function show_apply()
    {
        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $limit = $obj['limit'];
            $seeker = $this->seeker();
            $data = Accepting::where('seeker_id', $seeker->id)->where('isApply', true)->get()->take($limit)->toArray();
            $result = [];
            foreach ($data as $index => $item) {
                $vacan = Vacancies::find($item["vacancy_id"]);
                if (substr(Cities::find($vacan['cities_id'])->name, 0, 2) == "Ko") {
                    $cities = substr(Cities::find($vacan['cities_id'])->name, 5);
                } else {
                    $cities = substr(Cities::find($vacan['cities_id'])->name, 10);
                }

                $user = User::findOrFail(Agencies::findOrFail($vacan['agency_id'])->user_id);
                if ($user->ava == "agency.png" || $user->ava == "") {
                    $filename = asset('images/agency.png');
                } else {
                    $filename = asset('storage/users/' . $user->ava);
                }

                $city = array('city' => $cities);
                $detail = array('vacancy' => $vacan);
                $degrees = array('degrees' => Tingkatpend::findOrFail($vacan['tingkatpend_id'])->name);
                $majors = array('majors' => Jurusanpend::findOrFail($vacan['jurusanpend_id'])->name);
                $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacan['fungsikerja_id'])->nama);
                $industry = array('industry' => Industri::findOrFail($vacan['industry_id'])->nama);
                $jobtype = array('job_type' => JobType::findOrFail($vacan['jobtype_id'])->name);
                $joblevel = array('job_level' => JobLevel::findOrFail($vacan['joblevel_id'])->name);
                $salary = array('salary' => Salaries::findOrFail($vacan['salary_id'])->name);
                $ava['user'] = array('ava' => $filename, 'name' => $user->name);
                $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d-m-Y'));
                $result[$index] = array_replace($ava, $data[$index], $city, $degrees, $majors,
                    $jobfunc, $industry, $jobtype, $joblevel, $salary, $update_at, $detail);
            }
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e
            ], 500);
        }

    }

    public function show_bookmark()
    {
        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $limit = $obj['limit'];
            $seeker = $this->seeker();
            $data = Accepting::where('seeker_id', $seeker->id)->where('isBookmark', true)->get()->take($limit)->toArray();
//                $seeker->accepting->;
            $result = [];
            foreach ($data as $index => $item) {
                $vacan = Vacancies::find($item["vacancy_id"]);
                if (substr(Cities::find($vacan['cities_id'])->name, 0, 2) == "Ko") {
                    $cities = substr(Cities::find($vacan['cities_id'])->name, 5);
                } else {
                    $cities = substr(Cities::find($vacan['cities_id'])->name, 10);
                }

                $user = User::findOrFail(Agencies::findOrFail($vacan['agency_id'])->user_id);
                if ($user->ava == "agency.png" || $user->ava == "") {
                    $filename = asset('images/agency.png');
                } else {
                    $filename = asset('storage/users/' . $user->ava);
                }

                $city = array('city' => $cities);
                $detail = array('vacancy' => $vacan);
                $degrees = array('degrees' => Tingkatpend::findOrFail($vacan['tingkatpend_id'])->name);
                $majors = array('majors' => Jurusanpend::findOrFail($vacan['jurusanpend_id'])->name);
                $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacan['fungsikerja_id'])->nama);
                $industry = array('industry' => Industri::findOrFail($vacan['industry_id'])->nama);
                $jobtype = array('job_type' => JobType::findOrFail($vacan['jobtype_id'])->name);
                $joblevel = array('job_level' => JobLevel::findOrFail($vacan['joblevel_id'])->name);
                $salary = array('salary' => Salaries::findOrFail($vacan['salary_id'])->name);
                $ava['user'] = array('ava' => $filename, 'name' => $user->name);
                $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d-m-Y'));
                $result[$index] = array_replace($ava, $data[$index], $city, $degrees, $majors,
                    $jobfunc, $industry, $jobtype, $joblevel, $salary, $update_at, $detail);
            }

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e
            ], 500);
        }
    }

    public function show_invitation()
    {
        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $limit = $obj['limit'];
            $seeker = $this->seeker();
            $data = Invitation::where('seeker_id', $seeker->id)->get()->toArray();
            $result = [];
            foreach ($data as $index => $item) {
                $vacan = Vacancies::find($item["vacancy_id"]);
                if (substr(Cities::find($vacan['cities_id'])->name, 0, 2) == "Ko") {
                    $cities = substr(Cities::find($vacan['cities_id'])->name, 5);
                } else {
                    $cities = substr(Cities::find($vacan['cities_id'])->name, 10);
                }

                $user = User::findOrFail(Agencies::findOrFail($vacan['agency_id'])->user_id);
                if ($user->ava == "agency.png" || $user->ava == "") {
                    $filename = asset('images/agency.png');
                } else {
                    $filename = asset('storage/users/' . $user->ava);
                }
                $status = array('status' => $item['isApply'] ? true : false);
                $city = array('city' => $cities);
                $detail = array('vacancy' => $vacan);
                $degrees = array('degrees' => Tingkatpend::findOrFail($vacan['tingkatpend_id'])->name);
                $majors = array('majors' => Jurusanpend::findOrFail($vacan['jurusanpend_id'])->name);
                $jobfunc = array('job_func' => FungsiKerja::findOrFail($vacan['fungsikerja_id'])->nama);
                $industry = array('industry' => Industri::findOrFail($vacan['industry_id'])->nama);
                $jobtype = array('job_type' => JobType::findOrFail($vacan['jobtype_id'])->name);
                $joblevel = array('job_level' => JobLevel::findOrFail($vacan['joblevel_id'])->name);
                $salary = array('salary' => Salaries::findOrFail($vacan['salary_id'])->name);
                $ava['user'] = array('ava' => $filename, 'name' => $user->name);
                $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d-m-Y'));
                $result[$index] = array_replace($ava, $status, $data[$index], $city, $degrees, $majors,
                    $jobfunc, $industry, $jobtype, $joblevel, $salary, $update_at, $detail);
            }
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e
            ], 500);
        }
    }


    public function accept_invitation()
    {
        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $id = $obj['id'];
            $invite = Invitation::findOrFail($id);
            $invite->update([
                'isApply' => true
            ]);

            return response()->json([
                "success" => true,
                "message" => "Invitation Successfully Accepted"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e
            ], 500);
        }
    }

    /**
     * Create Apply in Accepting table
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiApply()
    {
        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $vacancy_id = $obj['vacancy_id'];
            $seeker = $this->seeker();

            $vacancy = Vacancies::find($vacancy_id);
            $edu = Education::where('seeker_id', $seeker->id)->get();
            $exp = Experience::where('seeker_id', $seeker->id)->get();

            $reqExp = filter_var($vacancy->pengalaman, FILTER_SANITIZE_NUMBER_INT);
            $checkEdu = Education::whereHas('seekers', function ($seeker) {
                $seeker->where('user_id', Auth::user()->id);
            })->where('tingkatpend_id', '>=', $vacancy->tingkatpend_id)->wherenotnull('end_period')->count();


            if (count($edu) == 0 || count($exp) == 0 || $seeker->phone == "" || $seeker->address == "" ||
                $seeker->birthday == "" || $seeker->gender == "") {
                //if all req d match
                return response()->json([
                    'status' => 'warning',
                    'success' => false,
                    'message' => 'Your Personal Data is empty!!'
                ]);
            } else {
                //
                if ($seeker->total_exp < $reqExp) {
                    return response()->json([
                        'status' => 'warning',
                        'success' => false,
                        'message' => 'Work Experience Unqualified'
                    ]);
                } elseif ($checkEdu < 1) {
                    return response()->json([
                        'status' => 'warning',
                        'success' => false,
                        'message' => 'Education Degree Unqualified'
                    ]);
                } else {
                    $check = Accepting::where('vacancy_id', $vacancy_id)
                        ->where('seeker_id', $seeker->id)->first();

                    if (!empty($check)) {
                        return response()->json([
                            'status' => 'warning',
                            'success' => false,
                            'message' => 'Already applied!!'
                        ]);
                    } else {
                        Accepting::create([
                            'seeker_id' => $seeker->id,
                            'vacancy_id' => $vacancy_id,
                            'isApply' => true,
                        ]);

                        return response()->json([
                            'status' => 'success',
                            'success' => true,
                            'message' => 'Vacancy is successfully applied!!'
                        ]);
                    }
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "message" => $exception
            ], 500);
        }

    }

    /**
     * Abort Vacancy
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiAbortApply()
    {
        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $vacancy_id = $obj['vacancy_id'];
            $seeker = $this->seeker();


            $vacancy = Accepting::where('seeker_id', $seeker->id)->where('vacancy_id', $vacancy_id)->first();

            $vacancy->delete();

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'Vacancy is successfully aborted!!'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "message" => $exception
            ], 500);
        }
    }

    /**
     * Bookmark vacancy
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiBookmark()
    {


        try {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            $vacancy_id = $obj['vacancy_id'];
            $seeker = $this->seeker();

            $check = Accepting::where('vacancy_id', $vacancy_id)
                ->where('seeker_id', $seeker->id)->get();
//        dd($check[0]->id);
            if ($check->count() == 1) {
                if ($check[0]->isApply == true) {//jika data di apply
                    if ($check[0]->isBookmark == true) {//jika data dibookmark dan di apply
                        $check[0]->update([
                            'isBookmark' => false
                        ]);
                        return response()->json([
                            'status' => 'success',
                            'success' => true,
                            'message' => 'Bookmarks successfully remove!!'
                        ], 200);
                    } elseif ($check[0]->isBookmark == false) { //jika data diapply tapi tidak di bookmark
                        $check[0]->update([
                            'isBookmark' => true
                        ]);
                        return response()->json([
                            'status' => 'success',
                            'success' => true,
                            'message' => 'Bookmarks successfully Bookmarked!!'
                        ], 200);
                    }
                } else {//jika data tidak diapply
                    if ($check[0]->isBookmark == true) { //jika data tidak diapply tapi tidak di bookmark
                        $check[0]->delete();
                        return response()->json([
                            'status' => 'success',
                            'success' => true,
                            'message' => 'Bookmarks successfully remove!!'
                        ], 200);
                    }
                }
            } elseif ($check->count() == 0) {
                Accepting::create([
                    'seeker_id' => $seeker->id,
                    'vacancy_id' => $vacancy_id,
                    'isBookmark' => true,
                ]);

                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'message' => 'Vacancy is successfully Bookmarked!!'
                ], 200);
            }
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "message" => $exception
            ], 500);
        }
    }

    public function guard()
    {
        return Auth::guard('api');
    }

}

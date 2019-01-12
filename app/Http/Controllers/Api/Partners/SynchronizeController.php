<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\Cities;
use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\PartnerVacancy;
use App\Salaries;
use App\Seekers;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SynchronizeController extends Controller
{
    public function getPartnerInfo(Request $request)
    {
        $partner = $request->partner;
        $instansi = array('name' => $partner->name, 'email' => $partner->email, 'phone' => $partner->phone);
        $api = array('key' => $partner->api_key, 'secret' => $partner->api_secret,
            'expiry' => Carbon::parse($partner->api_expiry)->format('l, j F Y'),
            'isSync' => $partner->isSync,
            'created_at' => Carbon::parse($partner->created_at)->format('l, j F Y'),
            'updated_at' => Carbon::parse($partner->updated_at)->diffForHumans());

        $result = array_replace($instansi, $api);
        return $result;
    }

    public function synchronize(Request $request)
    {
        $partner = $request->partner;
        $vacancies = $request->vacancies;
        $seekers = $request->seekers;

        if ($partner->isSync == false) {
            $siskaVacs = Vacancies::where('isPost', true)->get()->toArray();
            $i = 0;
            foreach ($siskaVacs as $row) {
                $cities = substr(Cities::find($row['cities_id'])->name, 0, 2) == "Ko" ?
                    substr(Cities::find($row['cities_id'])->name, 5) :
                    substr(Cities::find($row['cities_id'])->name, 10);
                $agency = Agencies::findOrFail($row['agency_id']);
                $user = $agency->user;
                $filename = $user->ava == "agency.png" || $user->ava == "" ? asset('images/agency.png') :
                    asset('storage/users/' . $user->ava);

                $city = array('city' => $cities);
                $degrees = array('degrees' => Tingkatpend::findOrFail($row['tingkatpend_id'])->name);
                $majors = array('majors' => Jurusanpend::findOrFail($row['jurusanpend_id'])->name);
                $jobfunc = array('job_func' => FungsiKerja::findOrFail($row['fungsikerja_id'])->nama);
                $industry = array('industry' => Industri::findOrFail($row['industry_id'])->nama);
                $jobtype = array('job_type' => JobType::findOrFail($row['jobtype_id'])->name);
                $joblevel = array('job_level' => JobLevel::findOrFail($row['joblevel_id'])->name);
                $salary = array('salary' => Salaries::findOrFail($row['salary_id'])->name);
                $ava['agency'] = array('ava' => $filename, 'company' => $user->name, 'email' => $user->email,
                    'kantor_pusat' => $agency->kantor_pusat, 'industry_id' => $agency->industri_id,
                    'tentang' => $agency->tentang, 'alasan' => $agency->alasan, 'link' => $agency->link,
                    'alamat' => $agency->alamat, 'phone' => $agency->phone,
                    'hari_kerja' => $agency->hari_kerja, 'jam_kerja' => $agency->jam_kerja,
                    'lat' => $agency->lat, 'long' => $agency->long, 'isSISKA' => true);
                $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $row['updated_at'])
                    ->diffForHumans());
                $siskaVacs[$i] = array_replace($ava, $siskaVacs[$i], $city, $degrees, $majors, $jobfunc,
                    $industry, $jobtype, $joblevel, $salary, $update_at);

                $i = $i + 1;
            }

            foreach ($vacancies as $row) {
                $checkUser = User::where('email', $row['agency_id']['email'])->first();
                if (!$checkUser) {
                    $user = User::firstOrCreate([
                        'ava' => 'agency.png',
                        'name' => $row['agency_id']['company'],
                        'email' => $row['agency_id']['email'],
                        'password' => bcrypt(str_random(15)),
                        'role' => 'agency',
                        'status' => true
                    ]);
                } else {
                    $user = $checkUser;
                }

                $agency = Agencies::firstOrCreate([
                    'user_id' => $user->id,
                    'kantor_pusat' => $row['agency_id']['kantor_pusat'],
                    'industri_id' => $row['agency_id']['industry_id'],
                    'tentang' => $row['agency_id']['tentang'],
                    'alasan' => $row['agency_id']['alasan'],
                    'link' => $row['agency_id']['link'],
                    'alamat' => $row['agency_id']['alamat'],
                    'phone' => $row['agency_id']['phone'],
                    'hari_kerja' => $row['agency_id']['hari_kerja'],
                    'jam_kerja' => $row['agency_id']['jam_kerja'],
                    'lat' => $row['agency_id']['lat'],
                    'long' => $row['agency_id']['long'],
                ]);

                $vacancy = Vacancies::create([
                    'agency_id' => $agency->id,
                    'plan_id' => 1,
                    'judul' => $row['judul'],
                    'cities_id' => $row['city_id'],
                    'syarat' => $row['syarat'],
                    'tanggungjawab' => $row['tanggungjawab'],
                    'pengalaman' => $row['pengalaman'],
                    'jobtype_id' => $row['jobtype_id'],
                    'industry_id' => $row['industry_id'],
                    'joblevel_id' => $row['joblevel_id'],
                    'salary_id' => $row['salary_id'],
                    'tingkatpend_id' => $row['degree_id'],
                    'jurusanpend_id' => $row['major_id'],
                    'fungsikerja_id' => $row['jobfunction_id'],
                    'recruitmentDate_start' => $row['recruitmentDate_start'],
                    'recruitmentDate_end' => $row['recruitmentDate_end'],
                    'interview_date' => $row['interview_date'],
                ]);

                PartnerVacancy::create([
                    'vacancy_id' => $vacancy->id,
                    'partner_id' => $partner->id,
                ]);
            }

            foreach ($seekers as $seeker) {
                $checkUser = User::where('email', $seeker['email'])->first();
                if (!$checkUser) {
                    $user = User::firstOrCreate([
                        'ava' => 'seeker.png',
                        'name' => $seeker['name'],
                        'email' => $seeker['email'],
                        'password' => $seeker['password'],
                        'role' => 'seeker',
                        'status' => $seeker['status']
                    ]);
                } else {
                    $user = $checkUser;
                }

                Seekers::create([
                    'user_id' => $user->id,
                    'phone' => $seeker['phone'],
                    'address' => $seeker['address'],
                    'zip_code' => $seeker['zip_code'],
                    'birthday' => $seeker['birthday'],
                    'gender' => $seeker['gender'],
                    'relationship' => $seeker['relationship'],
                    'nationality' => $seeker['nationality'],
                    'website' => $seeker['website'],
                    'lowest_salary' => $seeker['lowest_salary'],
                    'highest_salary' => $seeker['highest_salary'],
                    'summary' => $seeker['summary'],
                ]);
            }

            $partner->update(['isSync' => true]);

            return response()->json([
                'status' => "200 OK",
                'success' => true,
                'message' => 'Successfully synchronized!',
                'vacancies' => $siskaVacs,
            ], 200);

        } else {
            return response()->json([
                'status' => "403 ERROR",
                'success' => false,
                'message' => 'Forbidden Access! Your client has been synchronized.'
            ], 403);
        }
    }
}

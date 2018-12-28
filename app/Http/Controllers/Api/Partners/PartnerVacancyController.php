<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\Cities;
use App\FungsiKerja;
use App\Http\Controllers\Api\SearchVacancyController as Search;
use App\Industri;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\PartnerVacancy;
use App\Salaries;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerVacancyController extends Controller
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
        $partner = $request->partner;
        $vacancies = $request->vacancies;

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
                'lat' => $agency->lat, 'long' => $agency->long);
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

        $status = count($vacancies) > 1 ? count($vacancies) . ' vacancies!' : 'a vacancy!';

        return response()->json([
            'status' => "200 OK",
            'success' => true,
            'message' => 'Successfully synchronized ' . $status,
            'data' => $siskaVacs
        ], 200);
    }

    public function createVacancies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;
        $vac = $request->vacancy;

        $checkUser = User::where('email', $ag['email'])->first();
        if (!$checkUser) {
            $user = User::firstOrCreate([
                'ava' => 'agency.png',
                'name' => $ag['company'],
                'email' => $ag['email'],
                'password' => bcrypt(str_random(15)),
                'role' => 'agency',
                'status' => true
            ]);
        } else {
            $user = $checkUser;
        }

        $agency = Agencies::firstOrCreate([
            'user_id' => $user->id,
            'kantor_pusat' => $ag['kantor_pusat'],
            'industri_id' => $ag['industry_id'],
            'tentang' => $ag['tentang'],
            'alasan' => $ag['alasan'],
            'link' => $ag['link'],
            'alamat' => $ag['alamat'],
            'phone' => $ag['phone'],
            'hari_kerja' => $ag['hari_kerja'],
            'jam_kerja' => $ag['jam_kerja'],
            'lat' => $ag['lat'],
            'long' => $ag['long'],
        ]);

        $vacancy = Vacancies::create([
            'agency_id' => $agency->id,
            'plan_id' => 1,
            'judul' => $vac['judul'],
            'cities_id' => $vac['city_id'],
            'syarat' => $vac['syarat'],
            'tanggungjawab' => $vac['tanggungjawab'],
            'pengalaman' => $vac['pengalaman'],
            'jobtype_id' => $vac['jobtype_id'],
            'industry_id' => $vac['industry_id'],
            'joblevel_id' => $vac['joblevel_id'],
            'salary_id' => $vac['salary_id'],
            'tingkatpend_id' => $vac['degree_id'],
            'jurusanpend_id' => $vac['major_id'],
            'fungsikerja_id' => $vac['jobfunction_id'],
            'recruitmentDate_start' => $vac['recruitmentDate_start'],
            'recruitmentDate_end' => $vac['recruitmentDate_end'],
            'interview_date' => $vac['interview_date']
        ]);

        PartnerVacancy::create([
            'vacancy_id' => $vacancy->id,
            'partner_id' => $partner->id,
        ]);

        return response()->json([
            'status' => "200 OK",
            'success' => true,
            'message' => $vac['judul'] . ' is successfully added!'
        ], 200);
    }

    public function updateVacancies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;
        $vac = $request->vacancy;
        $data = $request->data;

        $user = User::where('email', $ag['email'])->first();
        if ($user != null) {
            $agency = Agencies::where('user_id', $user->id)->first();

            $vacancy = Vacancies::whereHas('getPartnerVacancy', function ($q) use ($partner) {
                $q->where('partner_id', $partner->id);
            })->where('agency_id', $agency->id)->where('judul', $vac['judul'])->first();

            $vacancy->update([
                'judul' => $data['judul'],
                'cities_id' => $data['city_id'],
                'syarat' => $data['syarat'],
                'tanggungjawab' => $data['tanggungjawab'],
                'pengalaman' => $data['pengalaman'],
                'jobtype_id' => $data['jobtype_id'],
                'industry_id' => $data['industry_id'],
                'joblevel_id' => $data['joblevel_id'],
                'salary_id' => $data['salary_id'],
                'tingkatpend_id' => $data['degree_id'],
                'jurusanpend_id' => $data['major_id'],
                'fungsikerja_id' => $data['jobfunction_id'],
                'recruitmentDate_start' => $data['isPost'] == 1 ? $data['recruitmentDate_start'] : null,
                'recruitmentDate_end' => $data['isPost'] == 1 ? $data['recruitmentDate_end'] : null,
                'interview_date' => $data['isPost'] == 1 ? $data['interview_date'] : null
            ]);
        }

        return response()->json([
            'status' => "200 OK",
            'success' => true,
            'message' => $vacancy['judul'] . ' is successfully updated!'
        ], 200);
    }

    public function deleteVacancies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;
        $vac = $request->vacancy;

        $user = User::where('email', $ag['email'])->first();
        if ($user != null) {
            $agency = Agencies::where('user_id', $user->id)->first();

            $vacancy = Vacancies::whereHas('getPartnerVacancy', function ($q) use ($partner) {
                $q->where('partner_id', $partner->id);
            })->where('agency_id', $agency->id)->where('judul', $vac['judul'])->first();

            if ($vacancy != null) {
                $vacancy->delete();
            }
        }

        return response()->json([
            'status' => "200 OK",
            'success' => true,
            'message' => $vacancy['judul'] . ' is successfully deleted!'
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
                ->where('isPost', true)
                ->orwhereIn('agency_id', $agency)->whereIn('cities_id', $city)->where('isPost', true)
                ->orderByDesc('updated_at')->paginate(12)->appends($request->only(['q', 'loc']))->toArray();

        } else {
            $result = Vacancies::where('isPost', true)->orderByDesc('updated_at')->paginate(12)->toArray();
        }

        return app(Search::class)->array_vacancies($result);
    }
}

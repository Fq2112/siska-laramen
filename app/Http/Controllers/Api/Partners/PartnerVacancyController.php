<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\PartnerVacancy;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerVacancyController extends Controller
{
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

        $user = User::whereHas('agencies', function ($q) use ($partner) {
            $q->whereHas('vacancies', function ($q) use ($partner) {
                $q->whereHas('getPartnerVacancy', function ($q) use ($partner) {
                    $q->where('partner_id', $partner->id);
                });
            });
        })->where('email', $ag['email'])->first();

        if ($user != null) {
            $vacancy = Vacancies::whereHas('getPartnerVacancy', function ($q) use ($partner) {
                $q->where('partner_id', $partner->id);
            })->where('agency_id', $user->agencies->id)->where('judul', $vac['judul'])->first();

            if ($vacancy != null) {
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

                return response()->json([
                    'status' => "200 OK",
                    'success' => true,
                    'message' => $vacancy['judul'] . ' is successfully updated!'
                ], 200);
            }
        }

        return response()->json([
            'status' => "403 ERROR",
            'success' => true,
            'message' => 'Forbidden Access! You\'re only permitted to update/delete your own vacancy.'
        ], 200);
    }

    public function deleteVacancies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;
        $vac = $request->vacancy;

        $user = User::whereHas('agencies', function ($q) use ($partner) {
            $q->whereHas('vacancies', function ($q) use ($partner) {
                $q->whereHas('getPartnerVacancy', function ($q) use ($partner) {
                    $q->where('partner_id', $partner->id);
                });
            });
        })->where('email', $ag['email'])->first();

        if ($user != null) {
            $vacancy = Vacancies::whereHas('getPartnerVacancy', function ($q) use ($partner) {
                $q->where('partner_id', $partner->id);
            })->where('agency_id', $user->agencies->id)->where('judul', $vac['judul'])->first();

            if ($vacancy != null) {
                $vacancy->delete();

                return response()->json([
                    'status' => "200 OK",
                    'success' => true,
                    'message' => $vacancy['judul'] . ' is successfully deleted!'
                ], 200);
            }
        }

        return response()->json([
            'status' => "403 ERROR",
            'success' => true,
            'message' => 'Forbidden Access! You\'re only permitted to update/delete your own vacancy.'
        ], 200);
    }
}

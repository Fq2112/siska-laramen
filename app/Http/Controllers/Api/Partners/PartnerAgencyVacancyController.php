<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\PartnerCredential;
use App\PartnerVacancy;
use App\User;
use App\Vacancies;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerAgencyVacancyController extends Controller
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
                $partners = PartnerCredential::where('status', true)->where('isSync', true)
                    ->whereDate('api_expiry', '>=', today())->where('id', '!=', $partner->id)->get();
                $arr = array('email' => $user->email, 'judul' => $vac['judul'], 'input' => $data);
                $this->updatePartners($partners, $arr, 'vacancies');

                if ($data['isPost'] == 1) {
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
                        'recruitmentDate_start' => $data['recruitmentDate_start'],
                        'recruitmentDate_end' => $data['recruitmentDate_end'],
                        'interview_date' => $data['interview_date']
                    ]);

                } else {
                    $vacancy->update([
                        'recruitmentDate_start' => null,
                        'recruitmentDate_end' => null,
                        'interview_date' => null
                    ]);
                }

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
                $partners = PartnerCredential::where('status', true)->where('isSync', true)
                    ->whereDate('api_expiry', '>=', today())->where('id', '!=', $partner->id)->get();
                $arr = array('email' => $user->email, 'judul' => $vac['judul']);
                $this->deletePartners($partners, $arr, 'vacancy');

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

    public function updateAgencies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;
        $data = $request->data;

        $user = User::whereHas('agencies', function ($q) use ($partner) {
            $q->whereHas('vacancies', function ($q) use ($partner) {
                $q->whereHas('getPartnerVacancy', function ($q) use ($partner) {
                    $q->where('partner_id', $partner->id);
                });
            });
        })->where('email', $ag['email'])->first();

        if ($user != null) {
            $partners = PartnerCredential::where('status', true)->where('isSync', true)
                ->whereDate('api_expiry', '>=', today())->where('id', '!=', $partner->id)->get();
            $arr = array('email' => $user->email, 'input' => $data);
            $this->updatePartners($partners, $arr, 'agencies');

            $user->update([
                'name' => $data['company'],
                'email' => $data['email'],
            ]);

            $user->agencies->update([
                'kantor_pusat' => $data['kantor_pusat'],
                'industri_id' => $data['industry_id'],
                'tentang' => $data['tentang'],
                'alasan' => $data['alasan'],
                'link' => $data['link'],
                'alamat' => $data['address'],
                'phone' => $data['phone'],
                'hari_kerja' => $data['start_day'] . ' - ' . $data['end_day'],
                'jam_kerja' => $data['start_time'] . ' - ' . $data['end_time'],
                'lat' => $data['lat'],
                'long' => $data['long'],
            ]);

            return response()->json([
                'status' => "200 OK",
                'success' => true,
                'message' => $data['company'] . ' is successfully updated!'
            ], 200);
        }

        return response()->json([
            'status' => "403 ERROR",
            'success' => true,
            'message' => 'Forbidden Access! You\'re only permitted to update/delete your own agency.'
        ], 200);
    }

    private function updatePartners($partners, $arr, $check)
    {
        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $client = new Client([
                    'base_uri' => $partner->uri,
                    'defaults' => [
                        'exceptions' => false
                    ]
                ]);

                try {
                    if ($check == 'vacancies') {
                        $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                            'form_params' => [
                                'key' => $partner->api_key,
                                'secret' => $partner->api_secret,
                                'check_form' => 'vacancy',
                                'agencies' => $arr,
                            ]
                        ]);
                        $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                            'form_params' => [
                                'key' => $partner->api_key,
                                'secret' => $partner->api_secret,
                                'check_form' => 'schedule',
                                'agencies' => $arr,
                            ]
                        ]);

                    } elseif ($check == 'agencies') {
                        $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                            'form_params' => [
                                'key' => $partner->api_key,
                                'secret' => $partner->api_secret,
                                'check_form' => 'personal_data',
                                'agencies' => $arr,
                            ]
                        ]);
                        $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                            'form_params' => [
                                'key' => $partner->api_key,
                                'secret' => $partner->api_secret,
                                'check_form' => 'address',
                                'agencies' => $arr,
                            ]
                        ]);
                        $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                            'form_params' => [
                                'key' => $partner->api_key,
                                'secret' => $partner->api_secret,
                                'check_form' => 'about',
                                'agencies' => $arr,
                            ]
                        ]);
                    }
                } catch (ConnectException $e) {
                    //
                }
            }
        }
    }

    public function deleteAgencies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;

        $user = User::whereHas('agencies', function ($q) use ($partner) {
            $q->whereHas('vacancies', function ($q) use ($partner) {
                $q->whereHas('getPartnerVacancy', function ($q) use ($partner) {
                    $q->where('partner_id', $partner->id);
                });
            });
        })->where('email', $ag['email'])->first();

        if ($user != null) {
            $user->forceDelete();

            $partners = PartnerCredential::where('status', true)->where('isSync', true)
                ->whereDate('api_expiry', '>=', today())->where('id', '!=', $partner->id)->get();
            $arr = array('email' => $user->email, 'judul' => null);
            $this->deletePartners($partners, $arr, 'agency');

            return response()->json([
                'status' => "200 OK",
                'success' => true,
                'message' => $ag['company'] . ' is successfully deleted!'
            ], 200);
        }

        return response()->json([
            'status' => "403 ERROR",
            'success' => true,
            'message' => 'Forbidden Access! You\'re only permitted to update/delete your own agency.'
        ], 200);
    }

    private function deletePartners($partners, $arr, $check)
    {
        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $client = new Client([
                    'base_uri' => $partner->uri,
                    'defaults' => [
                        'exceptions' => false
                    ]
                ]);

                try {
                    $client->delete($partner->uri . '/api/SISKA/vacancies/delete', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'check_form' => $check,
                            'agencies' => $arr,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }
        }
    }
}

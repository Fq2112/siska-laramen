<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Agencies;
use App\Cities;
use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\Salaries;
use App\Tingkatpend;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use ZipArchive;
use App\Events\Partners\UserPartnershipEmail;
use App\PartnerCredential;
use App\PartnerVacancy;
use App\Vacancies;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TransactionPartnerController extends Controller
{
    public function showPartnersCredentials(Request $request)
    {
        $partnership = PartnerCredential::orderByDesc('id')->get();
        $findPartner = $request->q;

        return view('_admins.tables._transactions.partners.partnersCredentials-table', compact('partnership',
            'findPartner'));
    }

    public function updatePartnersCredentials(Request $request)
    {
        $partnership = PartnerCredential::find($request->id);

        if ($request->status == 1) {
            $partnership->update([
                'api_key' => $partnership->id . str_random(40),
                'api_secret' => $partnership->id . str_random(40),
                'api_expiry' => today()->addMonth(),
                'status' => $request->status
            ]);
            $filename = 'SiskaLTE_' . str_replace(' ', '_', $partnership->name) . '_credentials.pdf';
            $pdf = PDF::loadView('reports.partnership-pdf', compact('partnership'));
            Storage::put('public/users/partners/' . $filename, $pdf->output());
            event(new UserPartnershipEmail($partnership, $filename));

            return back()->with('success', 'Credentials API Key & API Secret for ' . $partnership->name . ' is ' .
                'successfully activated and sent to ' . $partnership->email . '!');

        } else {
            $partnership->update([
                'api_key' => null,
                'api_secret' => null,
                'api_expiry' => null,
                'status' => $request->status
            ]);

            return back()->with('success', 'Credentials API Key & API Secret for ' . $partnership->name . ' is ' .
                'successfully deactivated!');
        }
    }

    public function deletePartnersCredentials($id)
    {
        $partnership = PartnerCredential::find(decrypt($id));
        $partnership->delete();

        return back()->with('success', '' . $partnership->name . ' is successfully deleted from SISKA Partnership!');
    }

    public function showPartnersVacancies(Request $request)
    {
        $partnership = PartnerCredential::whereHas('getPartnerVacancy')->get();
        $partnerVacancies = PartnerVacancy::all();
        $findPartner = $request->q;

        return view('_admins.tables._transactions.partners.partnersVacancies-table', compact('partnership',
            'partnerVacancies', 'findPartner'));
    }

    public function editPartnersVacancies($id)
    {
        return Vacancies::find($id);
    }

    public function updatePartnersVacancies(Request $request)
    {
        $partnerVacancy = Vacancies::find($request->id);
        $partners = PartnerCredential::where('status', true)->where('isSync', true)
            ->whereDate('api_expiry', '>=', today())->where('id', '!=', $request->partner_id)->get();
        $data = array('email' => $partnerVacancy->agencies->user->email, 'judul' => $partnerVacancy->judul, 'input' => $request->toArray());
        $this->updatePartners($partners, $data, $request->check_form);

        if ($request->check_form == 'vacancy') {
            $partnerVacancy->update([
                'judul' => $request->judul,
                'cities_id' => $request->cities_id,
                'syarat' => $request->syarat,
                'tanggungjawab' => $request->tanggungjawab,
                'pengalaman' => $request->pengalaman,
                'jobtype_id' => $request->jobtype_id,
                'industry_id' => $request->industri_id,
                'joblevel_id' => $request->joblevel_id,
                'salary_id' => $request->salary_id,
                'agency_id' => $request->agency_id,
                'tingkatpend_id' => $request->tingkatpend_id,
                'jurusanpend_id' => $request->jurusanpend_id,
                'fungsikerja_id' => $request->fungsikerja_id,
            ]);

        } elseif ($request->check_form == 'schedule') {
            $partnerVacancy->update([
                'isPost' => $request->isPost == 1 ? $partnerVacancy->isPost : false,
                'active_period' => $request->isPost == 1 ? $partnerVacancy->active_period : null,
                'recruitmentDate_start' => $request->isPost == 1 ? $request->recruitmentDate_start : null,
                'recruitmentDate_end' => $request->isPost == 1 ? $request->recruitmentDate_end : null,
                'interview_date' => $request->isPost == 1 ? $request->interview_date : null,
            ]);
        }

        return back()->with('success', '' . $partnerVacancy->judul . ' is successfully updated!');
    }

    private function updatePartners($partners, $data, $check)
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
                    $client->put($partner->uri . '/api/SISKA/vacancies/update', [
                        'form_params' => [
                            'key' => $partner->api_key,
                            'secret' => $partner->api_secret,
                            'check_form' => $check,
                            'agencies' => $data,
                        ]
                    ]);
                } catch (ConnectException $e) {
                    //
                }
            }
        }
    }

    public function massPostPartnersVacancies(Request $request)
    {
        $partnerVacancies = PartnerVacancy::whereIn('id', explode(",", $request->partnerVac_ids))->get();
        $i = 0;
        foreach ($partnerVacancies as $partnerVacancy) {
            $partnerVacancy->getVacancy->update([
                'isPost' => true,
                'active_period' => today()->addMonth()
            ]);

            $data = $partnerVacancy->getVacancy->toArray();
            $cities = substr(Cities::find($data['cities_id'])->name, 0, 2) == "Ko" ?
                substr(Cities::find($data['cities_id'])->name, 5) :
                substr(Cities::find($data['cities_id'])->name, 10);
            $agency = Agencies::findOrFail($data['agency_id']);
            $user = $agency->user;
            $filename = $user->ava == "agency.png" || $user->ava == "" ? asset('images/agency.png') :
                asset('storage/users/' . $user->ava);
            $city = array('city' => $cities);
            $degrees = array('degrees' => Tingkatpend::findOrFail($data['tingkatpend_id'])->name);
            $majors = array('majors' => Jurusanpend::findOrFail($data['jurusanpend_id'])->name);
            $jobfunc = array('job_func' => FungsiKerja::findOrFail($data['fungsikerja_id'])->nama);
            $industry = array('industry' => Industri::findOrFail($data['industry_id'])->nama);
            $jobtype = array('job_type' => JobType::findOrFail($data['jobtype_id'])->name);
            $joblevel = array('job_level' => JobLevel::findOrFail($data['joblevel_id'])->name);
            $salary = array('salary' => Salaries::findOrFail($data['salary_id'])->name);
            $ava['agency'] = array('ava' => $filename, 'company' => $user->name, 'email' => $user->email,
                'kantor_pusat' => $agency->kantor_pusat, 'industry_id' => $agency->industri_id,
                'tentang' => $agency->tentang, 'alasan' => $agency->alasan, 'link' => $agency->link,
                'alamat' => $agency->alamat, 'phone' => $agency->phone,
                'hari_kerja' => $agency->hari_kerja, 'jam_kerja' => $agency->jam_kerja,
                'lat' => $agency->lat, 'long' => $agency->long, 'isSISKA' => true);
            $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $data['updated_at'])
                ->diffForHumans());
            $result[$i] = array_replace($ava, $data, $city, $degrees, $majors, $jobfunc,
                $industry, $jobtype, $joblevel, $salary, $update_at);
            $i = $i + 1;

            $partners = PartnerCredential::where('status', true)->where('isSync', true)
                ->whereDate('api_expiry', '>=', today())->where('id', '!=', $partnerVacancy->getPartner->id)->get();
            if (count($partners) > 0) {
                foreach ($partners as $partner) {
                    $client = new Client([
                        'base_uri' => $partner->uri,
                        'defaults' => [
                            'exceptions' => false
                        ]
                    ]);

                    try {
                        $client->post($partner->uri . '/api/SISKA/vacancies/create', [
                            'form_params' => [
                                'key' => $partner->api_key,
                                'secret' => $partner->api_secret,
                                'vacancies' => $result,
                            ]
                        ]);
                    } catch (ConnectException $e) {
                        //
                    }
                }
            }
        }

        return back()->with('success', '' . count($partnerVacancies) . ' partner vacancies are successfully posted!');
    }

    public function massGeneratePDF(Request $request)
    {
        $ids = explode(",", $request->partnerVac_ids);
        $partnerVacancies = PartnerVacancy::whereIn('id', $ids)->get();

        $files = [];
        $i = 0;
        foreach ($partnerVacancies as $partnerVacancy) {
            $partner = $partnerVacancy->getPartner;
            $vacancies = Vacancies::whereHas('getPartnerVacancy', function ($q) use ($partner) {
                $q->where('partner_id', $partner->id);
            })->get();
            $filename = 'VacancyList_' . str_replace(' ', '_', $partner->name) . '.pdf';
            $pdf = PDF::loadView('reports.partnerVacancyList-pdf', compact('partner', 'vacancies'));
            Storage::put('public/admins/partners/reports/vacancies/' . $filename, $pdf->output());

            $files[$i] = $filename;
            $i = $i + 1;
        }

        $public_dir = public_path();
        $zipFileName = 'PDFs.zip';
        $zip = new ZipArchive;
        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $zip->addFile(public_path('storage/admins/partners/reports/vacancies/' . $file), $file);
            }
            $zip->close();
        }
        $headers = array('Content-Type' => 'application/octet-stream');
        $filetopath = $public_dir . '/' . $zipFileName;
        if (!file_exists($filetopath)) {
            return back()->with('error', 'Couldn\'t zip the file! Please try again.');
        } else {
            return response()->download($filetopath, $zipFileName, $headers)->deleteFileAfterSend(true);
        }
    }

    public function massDeletePartnersVacancies(Request $request)
    {
        $partnerVacancies = PartnerVacancy::whereIn('id', explode(",", $request->partnerVac_ids))->get();

        foreach ($partnerVacancies as $partnerVacancy) {
            $partnerVacancy->getVacancy->delete();

            $data = array('email' => $partnerVacancy->getVacancy->agencies->user->email, 'judul' => $partnerVacancy->getVacancy->judul);
            $partners = PartnerCredential::where('status', true)->where('isSync', true)
                ->whereDate('api_expiry', '>=', today())->where('id', '!=', $partnerVacancy->getPartner->id)->get();
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
                                'check_form' => 'vacancy',
                                'agencies' => $data,
                            ]
                        ]);
                    } catch (ConnectException $e) {
                        //
                    }
                }
            }
        }

        return back()->with('success', '' . count($partnerVacancies) . ' partner vacancies are successfully deleted!');
    }
}

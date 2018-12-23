<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use ZipArchive;
use App\Events\UserPartnershipEmail;
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
        $partnerVacancies = PartnerVacancy::orderByDesc('id')->get();
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

        if ($request->check_form == 'vacancy') {
            $partnerVacancy->update([
                'judul' => $request->judul,
                'cities_id' => $request->cities_id,
                'syarat' => $request->syarat,
                'tanggungjawab' => $request->tanggungjawab,
                'pengalaman' => 'At least ' . $request->pengalaman . ' years',
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
                'isPost' => $request->isPost,
                'active_period' => $request->isPost == 1 ? today()->addMonth() : null,
                'recruitmentDate_start' => $request->isPost == 1 ? $request->recruitmentDate_start : null,
                'recruitmentDate_end' => $request->isPost == 1 ? $request->recruitmentDate_end : null,
                'interview_date' => $request->isPost == 1 ? $request->interview_date : null,
            ]);
        }

        return back()->with('success', '' . $partnerVacancy->judul . ' is successfully updated!');
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
            return 0;
        } else {
            return response()->download($filetopath, $zipFileName, $headers)->deleteFileAfterSend(true);
        }
    }

    public function massDeletePartnersVacancies(Request $request)
    {
        $partnerVacancies = PartnerVacancy::whereIn('id', explode(",", $request->partnerVac_ids))->get();

        foreach ($partnerVacancies as $partnerVacancy) {
            $partnerVacancy->getVacancy->delete();
        }

        return back()->with('success', '' . count($partnerVacancies) . ' partner vacancies are successfully deleted!');
    }
}

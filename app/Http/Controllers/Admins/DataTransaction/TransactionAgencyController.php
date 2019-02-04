<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Agencies;
use App\Cities;
use App\ConfirmAgency;
use App\Events\Agencies\VacancyPaymentDetails;
use App\FungsiKerja;
use App\Industri;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\PartnerCredential;
use App\PaymentCategory;
use App\PaymentMethod;
use App\Plan;
use App\Salaries;
use App\Support\RomanConverter;
use App\Tingkatpend;
use App\Vacancies;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionAgencyController extends Controller
{
    public function showVacanciesTable()
    {
        $vacancies = Vacancies::orderByDesc('id')->get();

        return view('_admins.tables._transactions.agencies.vacancy-table', compact('vacancies'));
    }

    public function deleteVacancies($id)
    {
        $vacancy = Vacancies::find(decrypt($id));
        $vacancy->delete();

        $data = array('email' => $vacancy->agencies->user->email, 'judul' => $vacancy->judul);
        $partners = PartnerCredential::where('status', true)->where('isSync', true)
            ->whereDate('api_expiry', '>=', today())->get();
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

        return back()->with('success', '' . $vacancy->judul . ' is successfully deleted!');
    }

    public function showJobPostingsTable(Request $request)
    {
        $postings = ConfirmAgency::orderByDesc('id')->get();
        $findAgency = $request->q;

        return view('_admins.tables._transactions.agencies.jobPosting-table', compact('postings', 'findAgency'));
    }

    public function updateJobPostings(Request $request)
    {
        $posting = ConfirmAgency::find($request->id);
        $vacancies = Vacancies::whereIn('id', $posting->vacancy_ids)->get();

        foreach ($vacancies as $vacancy) {
            if ($request->isPaid == 1) {
                $posting->update([
                    'isPaid' => true,
                    'date_payment' => now(),
                    'admin_id' => Auth::guard('admin')->user()->id
                ]);
                $vacancy->update([
                    'isPost' => true,
                    'active_period' => today()->addMonth()
                ]);

            } elseif ($request->isPaid == 0) {
                $posting->update([
                    'isPaid' => false,
                    'date_payment' => null,
                    'admin_id' => Auth::guard('admin')->user()->id
                ]);
                $vacancy->update([
                    'isPost' => false,
                    'active_period' => null,
                    'recruitmentDate_start' => null,
                    'recruitmentDate_end' => null,
                    'quizDate_start' => null,
                    'quizDate_end' => null,
                    'psychoTestDate_start' => null,
                    'psychoTestDate_end' => null,
                    'interview_date' => null,
                ]);

                if ($request->isAbort == 1) {
                    $posting->update(['isAbort' => true]);
                    $vacancy->update(['plan_id' => null]);
                }
            }
        }

        if ($request->isPaid == 1 || $request->isAbort == 1) {
            $this->paymentDetailsMail($posting);
        }

        if ($request->isPaid == 1) {
            $result = $vacancies->toArray();
            $i = 0;
            foreach ($result as $row) {
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
                $result[$i] = array_replace($ava, $result[$i], $city, $degrees, $majors, $jobfunc,
                    $industry, $jobtype, $joblevel, $salary, $update_at);

                $i = $i + 1;
            }

            $partners = PartnerCredential::where('status', true)->where('isSync', true)
                ->whereDate('api_expiry', '>=', today())->get();
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

        return back()->with('success', '' . $request->invoice . ' is successfully updated!')
            ->withInput($request->all())->with('vac_ids', implode(',', $posting->vacancy_ids));
    }

    private function paymentDetailsMail($posting)
    {
        $pm = PaymentMethod::find($posting->payment_method_id);
        $pc = PaymentCategory::find($pm->payment_category_id);
        $pl = Plan::find($posting->plans_id);

        $plan_price = $pl->price - ($pl->price * $pl->discount / 100);
        $price_per_ads = Plan::find(1)->price - (Plan::find(1)->price * Plan::find(1)->discount / 100);

        $old_totalVacancy = array_sum(str_split(filter_var($pl->job_ads, FILTER_SANITIZE_NUMBER_INT)));
        $diffTotalVacancy = $posting->total_ads - $old_totalVacancy;
        $totalVacancy = $old_totalVacancy . "(+" . $diffTotalVacancy . ")";
        $price_totalVacancy = $diffTotalVacancy * $price_per_ads;

        $old_totalQuizApplicant = $pl->quiz_applicant;
        $diffTotalQuizApplicant = $posting->total_quiz - $old_totalQuizApplicant;
        $totalQuizApplicant = $old_totalQuizApplicant . "(+" . $diffTotalQuizApplicant . ")";
        $price_totalQuiz = $diffTotalQuizApplicant * $pl->price_quiz_applicant;

        $old_totalPsychoTest = $pl->psychoTest_applicant;
        $diffTotalPsychoTest = $posting->total_psychoTest - $old_totalPsychoTest;
        $totalPsychoTest = $old_totalPsychoTest . "(+" . $diffTotalPsychoTest . ")";
        $price_totalPsychoTest = $diffTotalPsychoTest * $pl->price_psychoTest_applicant;

        $data = [
            'confirmAgency' => $posting,
            'payment_method' => $pm,
            'payment_category' => $pc,
            'plans' => $pl,
            'plan_price' => $plan_price,
            'totalVacancy' => $totalVacancy,
            'price_totalVacancy' => $price_totalVacancy,
            'totalQuizApplicant' => $totalQuizApplicant,
            'price_totalQuiz' => $price_totalQuiz,
            'totalPsychoTest' => $totalPsychoTest,
            'price_totalPsychoTest' => $price_totalPsychoTest,
        ];
        event(new VacancyPaymentDetails($data));
    }

    public function deleteJobPostings($id)
    {
        $posting = ConfirmAgency::find(decrypt($id));

        $date = $posting->created_at;
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' . RomanConverter::numberToRoman($date->format('m'));
        $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $posting->id;

        if ($posting->payment_proof != "") {
            Storage::delete('public/users/agencies/payment/' . $posting->payment_proof);
        }

        $posting->forcedelete();

        return back()->with('success', '' . $invoice . ' is successfully deleted!');
    }
}

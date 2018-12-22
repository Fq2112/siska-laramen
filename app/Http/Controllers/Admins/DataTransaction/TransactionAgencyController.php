<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Agencies;
use App\ConfirmAgency;
use App\Events\Agencies\VacancyPaymentDetails;
use App\PaymentCategory;
use App\PaymentMethod;
use App\Plan;
use App\Support\RomanConverter;
use App\User;
use App\Vacancies;
use Carbon\Carbon;
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

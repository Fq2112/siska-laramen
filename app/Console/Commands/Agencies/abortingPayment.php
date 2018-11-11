<?php

namespace App\Console\Commands\Agencies;

use App\ConfirmAgency;
use App\Events\Agencies\VacancyPaymentDetails;
use App\PaymentCategory;
use App\PaymentMethod;
use App\Plan;
use App\Vacancies;
use Illuminate\Console\Command;

class abortingPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abortPayment:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aborting the job posting payment that has been expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $postings = ConfirmAgency::where('isPaid', false)->where('isAbort', false)
            ->whereDate('created_at', '<=', now()->subDay())->get();

        foreach ($postings as $posting) {
            $posting->update([
                'isPaid' => false,
                'date_payment' => null,
                'isAbort' => true,
                'admin_id' => 1
            ]);

            $vacancies = Vacancies::whereIn('id', $posting->vacancy_ids)->get();
            foreach ($vacancies as $vacancy) {
                $vacancy->update([
                    'plan_id' => null,
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
            }

            $this->paymentAbortDetailsMail($posting);
        }
    }

    private function paymentAbortDetailsMail($posting)
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
}

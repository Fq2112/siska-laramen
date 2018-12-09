<?php

use App\ConfirmAgency;
use App\Vacancies;
use App\Plan;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ConfirmAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        $plans = Plan::all();
        foreach ($plans as $pl) {
            $plan_price = $pl->price - ($pl->price * $pl->discount / 100);
            $totalAds = array_sum(str_split(filter_var($pl->job_ads, FILTER_SANITIZE_NUMBER_INT)));

            $agencies = \App\Agencies::take(5)->get();

            foreach ($agencies as $agency) {
                $vacancies = Vacancies::where('agency_id', $agency->id)->take($totalAds)->get()->pluck('id')->toArray();
                $paymentCode = rand(100, 999);

                ConfirmAgency::create([
                    'agency_id' => $agency->id,
                    'plans_id' => $pl->id,
                    'total_ads' => $totalAds,
                    'vacancy_ids' => $vacancies,
                    'total_quiz' => $pl->quiz_applicant,
                    'total_psychoTest' => $pl->psychoTest_applicant,
                    'payment_method_id' => rand(1, 5),
                    'payment_code' => $paymentCode,
                    'total_payment' => $plan_price - $paymentCode,
                    'payment_proof' => '001.jpg',
                    'isPaid' => true,
                    'date_payment' => $faker->dateTimeBetween(now()->startOfYear(), now()->endOfYear()),
                    'admin_id' => 1,
                ]);
            }
        }
    }
}

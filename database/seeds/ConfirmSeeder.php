<?php

use Illuminate\Database\Seeder;
use App\Vacancies;
use App\ConfirmAgency;
use App\Plan;
use App\PaymentMethod;
use App\Admin;

class ConfirmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Vacancies::all() as $vacan){
            ConfirmAgency::create([
                'agency_id' => $vacan->agency_id,
                'plans_id' =>  rand(Plan::min('id'), Plan::max('id')),
                'vacancy_ids' => $vacan->id,
                'payment_method_id' => rand(PaymentMethod::min('id'),PaymentMethod::max('id')),
                'payment_code' => rand(22,1000),
                'isPaid' => rand(0,1),
                'admin_id' => rand(Admin::min('id'),Admin::max('id')),
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            HomeContentSeeder::class,
            TingkatpendSeeder::class,
            NationSeeder::class,
            ProvinceSeeder::class,
            CitiesSeeder::class,
            FungsikerjaSeeder::class,
            IndustriSeeder::class,
            JurusanSeeder::class,
            JobLevelSeeder::class,
            JobTypeSeeder::class,
            SalarySeeder::class,
            UserSeeder::class,
            PaymentMethodSeeder::class,
            ConfirmAgencySeeder::class,
            QuizSeeder::class,
            BlogSeeder::class,
        ]);
    }
}

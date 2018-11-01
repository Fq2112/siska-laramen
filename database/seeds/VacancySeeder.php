<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Cities;
use App\JobType;
use App\JobLevel;
use App\Salaries;
use App\Agencies;
use App\Tingkatpend;
use App\Jurusanpend;
use App\FungsiKerja;
use App\Industri;
use App\Vacancies;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($c = 0; $c < 100; $c++) {
            Vacancies::create([
                'judul' => $faker->jobTitle,
                'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                    '</li></ul>',
                'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                    '</li></ul>',
                'pengalaman' => $faker->randomDigitNotNull,
                'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                'industry_id' => rand(Industri::min('id'), Industri::max('id')),
                'salary_id' => rand(Salaries::min('id'), Salaries::max('id')),
                'agency_id' => rand(Agencies::min('id'), Agencies::max('id')),
                'tingkatpend_id' => rand(Tingkatpend::min('id'), Tingkatpend::max('id')),
                'jurusanpend_id' => rand(Jurusanpend::min('id'), Jurusanpend::max('id')),
                'fungsikerja_id' => rand(FungsiKerja::min('id'), FungsiKerja::max('id')),
                'plan_id' => 1,
                'isPost' => true,
                'active_period' => today()->addMonth(),
                'recruitmentDate_start' => today(),
                'recruitmentDate_end' => today()->addMonth(),
                'interview_date' => today()->addMonth()->addWeek(),
            ]);
        }
    }
}

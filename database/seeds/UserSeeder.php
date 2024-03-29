<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Support\Role;
use Carbon\Carbon;
use App\User;
use App\Agencies;
use App\Gallery;
use App\Seekers;
use App\Experience;
use App\Education;
use App\Admin;
use App\Cities;
use App\JobType;
use App\JobLevel;
use App\Salaries;
use App\Tingkatpend;
use App\Jurusanpend;
use App\FungsiKerja;
use App\Industri;
use App\Vacancies;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        foreach (Role::ALL as $role) {
            if ($role == Role::AGENCY) {
                for ($c = 0; $c < (($role == Role::AGENCY) ? 6 : 2); $c++) {
                    $user = User::create([
                        'ava' => 'agency.png',
                        'name' => $faker->company,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(60),
                        'role' => $role,
                        'status' => true,
                    ]);
                    $agency = Agencies::create([
                        'user_id' => $user->id,
                        'kantor_pusat' => $faker->city,
                        'industri_id' => rand(Industri::min('id'), Industri::max('id')),
                        'tentang' => '<p align="justify">' . $faker->text($maxNbChars = 700) . '</p>',
                        'alasan' => '<p align="justify">' . $faker->text($maxNbChars = 800) . '</p>',
                        'link' => 'https://www.' . preg_replace('/\s+/', '', strtolower($user->name)) . '.com',
                        'alamat' => $faker->address,
                        'phone' => $faker->phoneNumber,
                        'hari_kerja' => 'Monday - Saturday',
                        'jam_kerja' => '08:00 - 17:00',
                        'lat' => $faker->latitude(-8, -6),
                        'long' => $faker->longitude(111, 113)
                    ]);
                    Gallery::create([
                        'agency_id' => $agency->id,
                        'image' => 'c1.jpg',
                    ]);
                    Gallery::create([
                        'agency_id' => $agency->id,
                        'image' => 'c2.jpg',
                    ]);
                    Gallery::create([
                        'agency_id' => $agency->id,
                        'image' => 'c3.jpg',
                    ]);
                }

                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
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
                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
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
                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
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

                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
                    'salary_id' => rand(Salaries::min('id'), Salaries::max('id')),
                    'agency_id' => rand(Agencies::min('id'), Agencies::max('id')),
                    'tingkatpend_id' => rand(Tingkatpend::min('id'), Tingkatpend::max('id')),
                    'jurusanpend_id' => rand(Jurusanpend::min('id'), Jurusanpend::max('id')),
                    'fungsikerja_id' => rand(FungsiKerja::min('id'), FungsiKerja::max('id')),
                    'plan_id' => 2,
                    'passing_grade' => $faker->randomFloat(8, 60, 80),
                    'quiz_applicant' => 75,
                    'isPost' => true,
                    'active_period' => today()->addMonth(),
                    'recruitmentDate_start' => today(),
                    'recruitmentDate_end' => today()->addMonth(),
                    'quizDate_start' => today()->addMonth()->addDay(),
                    'quizDate_end' => today()->addMonth()->addDays(8),
                    'interview_date' => today()->addMonth()->addDays(15),
                ]);
                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
                    'salary_id' => rand(Salaries::min('id'), Salaries::max('id')),
                    'agency_id' => rand(Agencies::min('id'), Agencies::max('id')),
                    'tingkatpend_id' => rand(Tingkatpend::min('id'), Tingkatpend::max('id')),
                    'jurusanpend_id' => rand(Jurusanpend::min('id'), Jurusanpend::max('id')),
                    'fungsikerja_id' => rand(FungsiKerja::min('id'), FungsiKerja::max('id')),
                    'plan_id' => 2,
                    'passing_grade' => $faker->randomFloat(8, 60, 80),
                    'quiz_applicant' => 75,
                    'isPost' => true,
                    'active_period' => today()->addMonth(),
                    'recruitmentDate_start' => today(),
                    'recruitmentDate_end' => today()->addMonth(),
                    'quizDate_start' => today()->addMonth()->addDay(),
                    'quizDate_end' => today()->addMonth()->addDays(8),
                    'interview_date' => today()->addMonth()->addDays(15),
                ]);

                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
                    'salary_id' => rand(Salaries::min('id'), Salaries::max('id')),
                    'agency_id' => rand(Agencies::min('id'), Agencies::max('id')),
                    'tingkatpend_id' => rand(Tingkatpend::min('id'), Tingkatpend::max('id')),
                    'jurusanpend_id' => rand(Jurusanpend::min('id'), Jurusanpend::max('id')),
                    'fungsikerja_id' => rand(FungsiKerja::min('id'), FungsiKerja::max('id')),
                    'plan_id' => 3,
                    'passing_grade' => $faker->randomFloat(8, 70, 80),
                    'quiz_applicant' => 75,
                    'psychoTest_applicant' => 5,
                    'isPost' => true,
                    'active_period' => today()->addMonth(),
                    'recruitmentDate_start' => today(),
                    'recruitmentDate_end' => today()->addMonth(),
                    'quizDate_start' => today()->addMonth()->addDay(),
                    'quizDate_end' => today()->addMonth()->addDays(8),
                    'psychoTestDate_start' => today()->addMonth()->addDays(9),
                    'psychoTestDate_end' => today()->addMonth()->addDays(16),
                    'interview_date' => today()->addMonth()->addDays(23),
                ]);
                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
                    'salary_id' => rand(Salaries::min('id'), Salaries::max('id')),
                    'agency_id' => rand(Agencies::min('id'), Agencies::max('id')),
                    'tingkatpend_id' => rand(Tingkatpend::min('id'), Tingkatpend::max('id')),
                    'jurusanpend_id' => rand(Jurusanpend::min('id'), Jurusanpend::max('id')),
                    'fungsikerja_id' => rand(FungsiKerja::min('id'), FungsiKerja::max('id')),
                    'plan_id' => 3,
                    'passing_grade' => $faker->randomFloat(8, 70, 80),
                    'quiz_applicant' => 75,
                    'psychoTest_applicant' => 5,
                    'isPost' => true,
                    'active_period' => today()->addMonth(),
                    'recruitmentDate_start' => today(),
                    'recruitmentDate_end' => today()->addMonth(),
                    'quizDate_start' => today()->addMonth()->addDay(),
                    'quizDate_end' => today()->addMonth()->addDays(8),
                    'psychoTestDate_start' => today()->addMonth()->addDays(9),
                    'psychoTestDate_end' => today()->addMonth()->addDays(16),
                    'interview_date' => today()->addMonth()->addDays(23),
                ]);
                Vacancies::create([
                    'judul' => Factory::create()->jobTitle,
                    'cities_id' => rand(Cities::min('id'), Cities::max('id')),
                    'syarat' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'tanggungjawab' => '<ul><li>' . $faker->sentence($nbWords = 10, $variableNbWords = true) .
                        '</li></ul>',
                    'pengalaman' => $faker->randomDigitNotNull,
                    'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                    'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                    'industry_id' => $agency->industri_id,
                    'salary_id' => rand(Salaries::min('id'), Salaries::max('id')),
                    'agency_id' => rand(Agencies::min('id'), Agencies::max('id')),
                    'tingkatpend_id' => rand(Tingkatpend::min('id'), Tingkatpend::max('id')),
                    'jurusanpend_id' => rand(Jurusanpend::min('id'), Jurusanpend::max('id')),
                    'fungsikerja_id' => rand(FungsiKerja::min('id'), FungsiKerja::max('id')),
                    'plan_id' => 3,
                    'passing_grade' => $faker->randomFloat(8, 70, 80),
                    'quiz_applicant' => 75,
                    'psychoTest_applicant' => 5,
                    'isPost' => true,
                    'active_period' => today()->addMonth(),
                    'recruitmentDate_start' => today(),
                    'recruitmentDate_end' => today()->addMonth(),
                    'quizDate_start' => today()->addMonth()->addDay(),
                    'quizDate_end' => today()->addMonth()->addDays(8),
                    'psychoTestDate_start' => today()->addMonth()->addDays(9),
                    'psychoTestDate_end' => today()->addMonth()->addDays(16),
                    'interview_date' => today()->addMonth()->addDays(23),
                ]);

            } elseif ($role == Role::SEEKER) {
                for ($c = 0; $c < (($role == Role::SEEKER) ? 6 : 2); $c++) {
                    $user = User::create([
                        'ava' => 'seeker.png',
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                        'status' => true,
                    ]);
                    $seeker = Seekers::create([
                        'user_id' => $user->id,
                        'phone' => $faker->phoneNumber,
                        'address' => $faker->address,
                        'zip_code' => $faker->postcode,
                        'birthday' => $faker->dateTimeThisCentury->format('Y-m-d'),
                        'gender' => rand(0, 1) ? 'male' : 'female',
                        'relationship' => rand(0, 1) ? 'single' : 'married',
                        'nationality' => $faker->country,
                        'website' => 'https://www.' . preg_replace('/\s+/', '', strtolower($user->name)) . '.com',
                        'lowest_salary' => '1000000',
                        'highest_salary' => '5000000',
                        'summary' => '<p align="justify">' . $faker->text($maxNbChars = 500) . '</p>',
                    ]);

                    Education::create([
                        'seeker_id' => $seeker->id,
                        'school_name' => 'State University of ' . $faker->city,
                        'tingkatpend_id' => rand(Tingkatpend::min('id'), Tingkatpend::max('id')),
                        'jurusanpend_id' => rand(Jurusanpend::min('id'), Jurusanpend::max('id')),
                        'awards' => '<p align="justify">' . $faker->sentence(5, true) . '</p>',
                        'nilai' => $faker->randomFloat(8, 3, 4),
                        'start_period' => (today()->subYears(rand(1, 4)))->format('Y'),
                        'end_period' => today()->format('Y'),
                    ]);
                    $exp = Experience::create([
                        'seeker_id' => $seeker->id,
                        'job_title' => $faker->title,
                        'joblevel_id' => rand(JobLevel::min('id'), JobLevel::max('id')),
                        'company' => $faker->company,
                        'fungsikerja_id' => rand(FungsiKerja::min('id'), FungsiKerja::max('id')),
                        'industri_id' => rand(Industri::min('id'), Industri::max('id')),
                        'city_id' => rand(Cities::min('id'), Cities::max('id')),
                        'salary_id' => rand(Salaries::min('id'), Salaries::max('id')),
                        'start_date' => today()->subYears(rand(1, 9)),
                        'end_date' => rand(0, 1) ? null : today(),
                        'jobtype_id' => rand(JobType::min('id'), JobType::max('id')),
                        'report_to' => $faker->name,
                        'job_desc' => '<p align="justify">' . $faker->sentence(10, true) . '</p>',
                    ]);
                    $seeker->update([
                        'total_exp' => Carbon::parse($exp->start_date)->diffInYears(Carbon::parse($exp->end_date))
                    ]);

                    \App\FavoriteAgency::create([
                        'user_id' => $user->id,
                        'agency_id' => rand(Agencies::min('id'), Agencies::max('id')),
                        'isFavorite' => true
                    ]);
                }

            } elseif ($role == Role::VACANCY_STAFF) {
                Admin::create([
                    'ava' => 'avatar.png',
                    'name' => 'jQuinn',
                    'email' => 'jquinn211215@gmail.com',
                    'password' => bcrypt('secret'),
                    'role' => Role::ROOT
                ]);

                for ($c = 0; $c < 3; $c++) {
                    Admin::create([
                        'ava' => 'avatar.png',
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'role' => Role::VACANCY_STAFF
                    ]);

                    Admin::create([
                        'ava' => 'avatar.png',
                        'name' => $faker->name,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'role' => Role::INTERVIEWER
                    ]);

                    Admin::create([
                        'ava' => 'avatar.png',
                        'name' => $faker->name,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'role' => Role::SYNC_STAFF
                    ]);

                    Admin::create([
                        'ava' => 'avatar.png',
                        'name' => $faker->name,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'role' => Role::QUIZ_STAFF
                    ]);
                }
            }
        }

        User::find(1)->update([
            'email' => 'rm.rabbitmedia@gmail.com',
            'name' => 'Rabbit Media'
        ]);

        User::find(7)->update([
            'email' => 'fiqy_a@icloud.com',
            'name' => 'Fiqy Ainuzzaqy'
        ]);
    }
}

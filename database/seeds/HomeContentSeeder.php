<?php

use App\Admin;
use App\Carousel;
use App\Plan;
use Faker\Factory;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($c = 0; $c < 8; $c++) {
            Carousel::create([
                'image' => 'c' . $faker->unique()->numberBetween($min = 1, $max = 8) . '.jpg',
                'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'captions' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ]);
        }

        for ($c = 0; $c < 3; $c++) {
            Plan::create([
                'name' => rand(0, 1) ? 'plus' : 'enterprise',
                'price' => $faker->numberBetween($min = 1000000, $max = 1500000),
                'discount' => $faker->numberBetween($min = 0, $max = 100),
                'caption' => $faker->sentence($nbWords = 5, $variableNbWords = true),
                'job_ads' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'quiz_applicant' => $faker->numberBetween(1, 100),
                'price_quiz_applicant' => $faker->numberBetween(10000, 20000),
                'psychoTest_applicant' => $faker->numberBetween(1, 5),
                'price_psychoTest_applicant' => $faker->numberBetween(100000, 200000),
                'benefit' => '<ul><li>Waktu tayang 30 hari</li><li>Sistem auto-match untuk memfilter pelamar</li><li>Simpan resume pelamar selamanya</li></ul>'
            ]);
        }

        Plan::find(1)->update([
            'name' => 'Basic',
            'price' => 500000,
            'discount' => 10,
            'caption' => 'Job Posting Basic Package',
            'job_ads' => '1 Job Ad',
            'quiz_applicant' => 0,
            'price_quiz_applicant' => 0,
            'psychoTest_applicant' => 0,
            'price_psychoTest_applicant' => 0,
        ]);

        Plan::find(2)->update([
            'name' => 'Plus',
            'price' => 2500000,
            'discount' => 20,
            'caption' => 'Job Posting Plus Package',
            'job_ads' => '2 Job Ads + Online Quiz (TPA & TKD)',
            'isQuiz' => true,
            'quiz_applicant' => 150,
            'price_quiz_applicant' => 10000,
            'psychoTest_applicant' => 0,
            'price_psychoTest_applicant' => 0,
        ]);

        Plan::find(3)->update([
            'name' => 'Enterprise',
            'price' => 6750000,
            'discount' => 30,
            'caption' => 'Best Job Posting Package',
            'job_ads' => '3 Job Ads + Online Quiz + Psycho Test (Online Interview)',
            'isQuiz' => true,
            'quiz_applicant' => 225,
            'price_quiz_applicant' => 10000,
            'isPsychoTest' => true,
            'psychoTest_applicant' => 15,
            'price_psychoTest_applicant' => 200000,
            'isBest' => true,
        ]);
    }
}

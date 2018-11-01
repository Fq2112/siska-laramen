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
                'caption' => $faker->sentence($nbWords = 5, $variableNbWords = true),
                'job_ads' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'benefit' => $faker->paragraph(5, true),
            ]);
        }
        Plan::find(1)->update([
            'name' => 'Basic',
            'price' => 500000,
            'caption' => 'Job Posting Basic Package',
            'job_ads' => '1 Job Ad',
            'benefit' => '<ul><li>Waktu tayang 30 hari</li><li>Sistem auto-match untuk memfilter pelamar</li><li>Simpan resume pelamar selamanya</li></ul>',
        ]);
        Plan::find(2)->update([
            'name' => 'Plus',
            'price' => 1000000,
            'caption' => 'Job Posting Plus Package',
            'job_ads' => '2 Job Ads + Quiz (Online TPA & TKD)',
            'benefit' => '<ul><li>Waktu tayang 30 hari</li><li>Sistem auto-match untuk memfilter pelamar</li><li>Simpan resume pelamar selamanya</li></ul>',
            'isQuiz' => true,
        ]);
        Plan::find(3)->update([
            'name' => 'Enterprise',
            'price' => 1500000,
            'caption' => 'Job Posting Plus Package',
            'job_ads' => '3 Job Ads + Quiz + Psycho Test (Online Interview)',
            'benefit' => '<ul><li>Waktu tayang 30 hari</li><li>Sistem auto-match untuk memfilter pelamar</li><li>Simpan resume pelamar selamanya</li></ul>',
            'isQuiz' => true,
            'isPsychoTest' => true,
            'isBest' => true,
        ]);
    }
}

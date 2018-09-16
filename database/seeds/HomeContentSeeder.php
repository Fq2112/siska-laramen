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
                'admin_id' => rand(Admin::min('id'), Admin::max('id')),
                'image' => 'c' . $faker->unique()->numberBetween($min = 1, $max = 8) . '.jpg',
                'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'captions' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ]);
        }

        for ($c = 0; $c < 3; $c++) {
            Plan::create([
                'admin_id' => rand(Admin::min('id'), Admin::max('id')),
                'name' => rand(0, 1) ? 'plus' : 'enterprise',
                'price' => $faker->numberBetween($min = 1000000, $max = 1500000),
                'caption' => $faker->sentence($nbWords = 5, $variableNbWords = true),
                'job_ads' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'benefit' => '<ul><li>Waktu tayang 30 hari</li><li>Posisi iklan prioritas (4x)</li><li>Sistem auto-match untuk memfilter pelamar</li><li>Simpan resume pelamar selamanya</li></ul>',
            ]);
        }
        Plan::find(1)->update([
            'name' => 'Basic',
            'price' => 800000,
            'caption' => 'Job Posting Basic Package',
            'job_ads' => '1 Job Ad',
        ]);
        Plan::find(2)->update([
            'name' => 'Plus',
            'price' => 1800000,
            'caption' => 'Best Job Posting Package',
            'job_ads' => '2 Job Ads +FREE 1 Job Ad',
            'isBest' => true,
        ]);
        Plan::find(3)->update([
            'name' => 'Enterprise',
            'price' => 'On-demand',
            'caption' => 'Butuh Pasang Iklan Lebih Banyak?',
            'job_ads' => 'On-demand',
            'benefit' => '<ul><li><a href="tel:+62318672552">031-867 2552 (Sidoarjo)</a></li><li><a href="tel:+62315667102">031-566 7102 (Surabaya)</a></li><li><a href="mailto:info@karir.org">info@karir.org</a></li></ul><br><br><hr>',
        ]);
    }
}

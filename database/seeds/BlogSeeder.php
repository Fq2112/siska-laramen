<?php

use App\Jenisblog;
use App\Blog;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($c = 0; $c < 5; $c++) {
            $blogType = Jenisblog::create([
                'nama' => $faker->words(2, true)
            ]);

            Blog::create([
                'judul' => $faker->words(3, true),
                'subjudul' => $faker->words(5, true),
                'dir' => rand(0, 1) ? 'full_image_4.jpg' : 'full_image_5.jpg',
                'konten' => $faker->sentences(5, true),
                'uploder' => $faker->name,
                'jenisblog_id' => $blogType->id,
            ]);

            Blog::create([
                'judul' => $faker->words(3, true),
                'subjudul' => $faker->words(5, true),
                'dir' => rand(0, 1) ? 'unesa.jpg' : 'features.jpeg',
                'konten' => $faker->sentences(5, true),
                'uploder' => $faker->name,
                'jenisblog_id' => $blogType->id,
            ]);
        }
    }
}

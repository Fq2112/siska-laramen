<?php

use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 5; $i++) {
            \App\PromoCode::create([
                'promo_code' => strtoupper(uniqid('KRNS')),
                'start' => now(),
                'end' => now()->addMonth(),
                'description' => \Faker\Factory::create()->sentence,
                'discount' => rand(5, 15),
            ]);
        }

        \App\PromoCode::find(1)->update([
            'promo_code' => 'kariernesia1.0',
            'start' => now(),
            'end' => now()->addCentury(),
            'description' => env('APP_NAME').' 90% off!',
            'discount' => 90,
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Support\Role;
use App\User;
use App\Agencies;
use App\Gallery;
use App\Seekers;
use App\Admin;
use App\Carousel;

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
                for ($c = 0; $c < (($role == Role::AGENCY) ? 50 : 2); $c++) {
                    $user = User::create([
                        'ava' => 'agency.png',
                        'name' => $faker->company,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                        'status' => true,
                    ]);
                    $agency = Agencies::create([
                        'user_id' => $user->id,
                        'kantor_pusat' => $faker->city,
                        'tentang' => '<p align="justify">' . $faker->text($maxNbChars = 700) . '</p>',
                        'alasan' => '<p align="justify">' . $faker->text($maxNbChars = 800) . '</p>',
                        'link' => 'https://www.' . preg_replace('/\s+/', '', strtolower($user->name)) . '.com',
                        'alamat' => $faker->address,
                        'phone' => $faker->phoneNumber,
                        'hari_kerja' => 'Monday - Saturday',
                        'jam_kerja' => '08:00 - 17:00',
                        'lat' => $faker->latitude(-8, -6),
                        'long' => $faker->longitude(111, 113)
                    ])->id;
                    Gallery::create([
                        'agency_id' => $agency,
                        'image' => 'c1.jpg',
                    ]);
                    Gallery::create([
                        'agency_id' => $agency,
                        'image' => 'c2.jpg',
                    ]);
                    Gallery::create([
                        'agency_id' => $agency,
                        'image' => 'c3.jpg',
                    ]);
                }
            } elseif ($role == Role::SEEKER) {
                for ($c = 0; $c < (($role == Role::SEEKER) ? 50 : 2); $c++) {
                    $user = User::create([
                        'ava' => 'seeker.png',
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                        'status' => true,
                    ]);
                    Seekers::create([
                        'user_id' => $user->id,
                        'background' => 'c2.jpg',
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
                        'summary' => $faker->text($maxNbChars = 500),
                    ]);
                }
            } elseif ($role == Role::ADMIN) {
                for ($c = 0; $c < (($role == Role::ADMIN) ? 10 : 2); $c++) {
                    Admin::create([
                        'ava' => 'avatar.png',
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                    ]);
                }
            }
        }
    }
}

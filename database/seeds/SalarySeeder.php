<?php

use Illuminate\Database\Seeder;
use App\Salaries;

class SalarySeeder extends Seeder
{
    const SALARIES = [
        'At most 1 million',
        '1 - 2 millions',
        '2 - 3 millions',
        '3 - 4 millions',
        '4 - 5 millions',
        '5 - 6 millions',
        '6 - 7 millions',
        '7 - 8 millions',
        '8 - 9 millions',
        '9 - 10 millions',
        '10 - 15 millions',
        '15 - 20 millions',
        '20 - 30 millions',
        '30 - 40 millions',
        '40 - 50 millions',
        '50 - 60 millions',
        '60 - 70 millions',
        '70 - 80 millions',
        '80 - 90 millions',
        '90 - 100 millions',
        'At least 100 millions',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::SALARIES as $salary) {
            Salaries::create([
                'name' => $salary
            ]);
        }
    }
}

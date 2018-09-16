<?php

use Illuminate\Database\Seeder;
use App\JobLevel;

class JobLevelSeeder extends Seeder
{
    const JOB_LEVELS = [
        'Not Specified',
        'Entry Level / Staff',
        'Senior Staff',
        'Supervisor',
        'Assistant Manager',
        'Senior Assistant Manager',
        'Manager - Department',
        'Manager - Branch / Regional',
        'Engineer',
        'Senior Manager',
        'Assistant Vice President',
        'General Manager',
        'Business Unit Head',
        'Vice President',
        'Senior Vice President',
        'Executive Vice President',
        'Director',
        'President Director - CEO',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::JOB_LEVELS as $job_level) {
            JobLevel::create([
                'name' => $job_level
            ]);
        }
    }
}

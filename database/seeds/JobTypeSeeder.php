<?php

use Illuminate\Database\Seeder;
use App\JobType;

class JobTypeSeeder extends Seeder
{
    const JOB_TYPES = [
        'Full-Time',
        'Part-Time',
        'Internship',
        'Temporary',
        'Contract',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::JOB_TYPES as $JOB_TYPE) {
            JobType::create([
                'name' => $JOB_TYPE
            ]);
        }
    }
}

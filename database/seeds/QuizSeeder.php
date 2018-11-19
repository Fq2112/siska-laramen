<?php

use App\QuizType;
use App\QuizQuestions;
use App\QuizOptions;
use App\QuizInfo;
use App\Vacancies;
use Faker\Factory;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        QuizType::create([
            'name' => 'TPA'
        ]);
        QuizType::create([
            'name' => 'TKD'
        ]);

        for ($c = 0; $c < 40; $c++) {
            $question = QuizQuestions::create([
                'quiztype_id' => 1,
                'question_text' => '<p>' . ucfirst($faker->words(6, true)) . '?</p>',
            ]);

            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(1, 3), true),
                'correct' => true
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(1, 3), true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(1, 3), true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(1, 3), true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(1, 3), true),
            ]);
        }

        for ($c = 0; $c < 60; $c++) {
            $question = QuizQuestions::create([
                'quiztype_id' => 2,
                'question_text' => '<p>' . ucfirst($faker->words(8, true)) . '?</p>',
            ]);

            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(2, 4), true),
                'correct' => true
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(2, 4), true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(2, 4), true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(2, 4), true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->words(rand(2, 4), true),
            ]);
        }

        QuizInfo::create([
            'vacancy_id' => Vacancies::where('plan_id', 3)->first()->id,
            'unique_code' => str_random(6),
            'total_question' => 100,
            'question_ids' => QuizQuestions::get()->pluck('id')->toArray(),
            'time_limit' => 120
        ]);
    }
}

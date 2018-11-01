<?php

use App\QuizType;
use App\QuizQuestions;
use App\QuizOptions;
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
                'question_text' => $faker->sentences(5, true) . '?',
            ]);

            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
                'correct' => true
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
        }

        for ($c = 0; $c < 60; $c++) {
            $question = QuizQuestions::create([
                'quiztype_id' => 2,
                'question_text' => $faker->sentences(5, true) . '?',
            ]);

            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
                'correct' => true
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
            QuizOptions::create([
                'question_id' => $question->id,
                'option' => $faker->sentences(3, true),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Seekers;

use App\Provinces;
use App\QuizInfo;
use App\QuizOptions;
use App\QuizQuestions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'seeker']);
    }

    public function showQuiz()
    {
        $quiz = QuizInfo::where('unique_code', '9kzc23')->first();

        return view('_seekers.quiz', compact('quiz'));
    }

    public function loadQuizAnswers($id)
    {
        $quiz = QuizInfo::find($id);
        $questions = QuizQuestions::whereIn('id', $quiz->question_ids)->get()->pluck('id')->toArray();
        $answers = QuizOptions::whereIn('question_id', $questions)->where('correct', true)
            ->orderBy('question_id')->get()->pluck('option')->toJson();

        return $answers;
    }
}

<?php

namespace App\Http\Controllers\Seekers;

use App\Agencies;
use App\QuizInfo;
use App\QuizOptions;
use App\QuizQuestions;
use App\QuizResult;
use App\Seekers;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'seeker']);
    }

    public function showQuiz(Request $request)
    {
        $quiz = QuizInfo::where('unique_code', $request->quiz_code)->first();
        $vacancy = Vacancies::find($quiz->vacancy_id);
        $agency = User::find(Agencies::find($vacancy->agency_id)->id);

        return view('_seekers.quiz', compact('quiz', 'vacancy', 'agency'));
    }

    public function loadQuizAnswers($id)
    {
        $quiz = QuizInfo::find($id);
        $questions = QuizQuestions::whereIn('id', $quiz->question_ids)->get()->pluck('id')->toArray();
        $answers = QuizOptions::whereIn('question_id', $questions)->where('correct', true)
            ->orderBy('question_id')->get()->pluck('option')->toJson();

        return $answers;
    }

    public function submitQuiz(Request $request)
    {
        $quiz = QuizResult::create([
            'quiz_id' => $request->quiz_id,
            'seeker_id' => Seekers::where('user_id', $request->user_id)->firstOrFail()->id,
            'score' => $request->score,
        ]);

        return $quiz;
    }
}

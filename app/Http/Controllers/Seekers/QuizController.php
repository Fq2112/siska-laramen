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
        $this->middleware('quiz')->only('showQuiz');
    }

    public function showQuiz(Request $request)
    {
        $no = 1;
        $quiz = QuizInfo::where('unique_code', $request->quiz_code)->first();
        $questions = QuizQuestions::whereIn('id', $quiz->question_ids)->inRandomOrder()->get();

        $vacancy = $quiz->getVacancy;
        $agency = $vacancy->agencies;

        return view('_seekers.quiz', compact('quiz', 'no', 'questions', 'vacancy', 'agency'));
    }

    public function loadQuizAnswers($question_ids)
    {
        $ids = explode(",", $question_ids);
        $answers = QuizOptions::whereIn('question_id', $ids)->where('correct', true)
            ->orderByRaw("FIELD(question_id, $question_ids) ASC")->get()->pluck('option')->toJson();

        return $answers;
    }

    public function submitQuiz(Request $request)
    {
        $info = QuizInfo::find($request->quiz_id);
        $result = QuizResult::create([
            'quiz_id' => $request->quiz_id,
            'seeker_id' => Seekers::where('user_id', $request->user_id)->firstOrFail()->id,
            'score' => $request->score,
            'isPassed' => $request->score >= $info->getVacancy->passing_grade ? true : false
        ]);

        return $result;
    }
}

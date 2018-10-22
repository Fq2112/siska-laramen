<?php

namespace App\Http\Controllers\Admins;

use App\QuizOptions;
use App\QuizQuestions;
use App\QuizType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    public function showQuizTopics()
    {
        $topics = QuizType::all();

        return view('_admins.quiz.topic-table', compact('topics'));
    }

    public function loadQuizTopics()
    {
        return QuizType::all();
    }

    public function createQuizTopics(Request $request)
    {
        QuizType::create(['name' => $request->name]);

        return back()->with('success', '' . $request->name . 'topic quiz is successfully created!');
    }

    public function updateQuizTopics(Request $request)
    {
        $topic = QuizType::find($request->id);
        $topic->update(['name' => $request->name]);

        return back()->with('success', '' . $topic->name . 'topic quiz is successfully updated!');
    }

    public function deleteQuizTopics($id)
    {
        $topic = QuizType::find(decrypt($id));
        $topic->delete();

        return back()->with('success', '' . $topic->name . 'topic quiz is successfully deleted!');
    }

    public function showQuizQuestions()
    {
        $questions = QuizQuestions::all();

        return view('_admins.quiz.question-table', compact('questions'));
    }

    public function loadQuizQuestions()
    {
        $questions = QuizQuestions::all()->toArray();
        $i = 0;
        $result = array();
        foreach ($questions as $question) {
            $topic = array('topic' => QuizType::find($question['quiztype_id'])->name);
            $result[$i] = array_replace($questions[$i], $topic);
            $i = $i + 1;
        }

        return $result;
    }

    public function createQuizQuestions(Request $request)
    {
        $question = QuizQuestions::create([
            'quiztype_id' => $request->quiztype_id,
            'question_text' => $request->question_text
        ]);

        foreach ($request->input() as $key => $value) {
            if (strpos($key, 'option') !== false && $value != '') {
                $status = $request->input('correct') == $key ? true : false;
                QuizOptions::create([
                    'question_id' => $question->id,
                    'option' => $value,
                    'correct' => $status,
                ]);
            }
        }

        $topic = QuizType::find($request->quiztype_id);

        return back()->with('success', '' . $topic->name . '\'s question (' . $request->question_text . ') is successfully created!');
    }

    public function updateQuizQuestions(Request $request)
    {
        $question = QuizQuestions::find($request->id);
        $question->update([
            'quiztype_id' => $request->quiztype_id,
            'question_text' => $request->question_text
        ]);

        $topic = QuizType::find($question->quiztype_id);

        return back()->with('success', '' . $topic->name . '\'s question (' . $question->question_text . ') is successfully updated!');
    }

    public function deleteQuizQuestions($id)
    {
        $question = QuizQuestions::find(decrypt($id));
        $question->delete();

        $topic = QuizType::find($question->quiztype_id);

        return back()->with('success', '' . $topic->name . '\'s question (' . $question->question_text . ') is successfully deleted!');
    }

    public function showQuizOptions()
    {
        $options = QuizOptions::all();

        return view('_admins.quiz.option-table', compact('options'));
    }

    public function createQuizOptions(Request $request)
    {
        QuizOptions::create([
            'question_id' => $request->question_id,
            'option' => $request->option,
            'correct' => $request->correct
        ]);

        $question = QuizQuestions::find($request->question_id);

        return back()->with('success', '' . $question->question_text . '\'s option (' . $request->option . ') is successfully created!');
    }

    public function updateQuizOptions(Request $request)
    {
        $option = QuizOptions::find($request->id);

        if ($request->correct != $option->correct) {
            foreach (QuizOptions::where('question_id', $request->question_id)->get() as $row) {
                $row->update(['correct' => false]);
            }
        }

        $option->update([
            'question_id' => $request->question_id,
            'option' => $request->option,
            'correct' => $request->correct
        ]);

        $question = QuizQuestions::find($option->question_id);

        return back()->with('success', '' . $question->question_text . '\'s option (' . $option->option . ') is successfully updated!');
    }

    public function deleteQuizOptions($id)
    {
        $option = QuizOptions::find(decrypt($id));
        $option->delete();

        $question = QuizQuestions::find($option->question_id);

        return back()->with('success', '' . $question->question_text . '\'s option (' . $option->option . ') is successfully deleted!');
    }
}

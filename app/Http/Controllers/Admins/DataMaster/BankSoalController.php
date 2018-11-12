<?php

namespace App\Http\Controllers\Admins\DataMaster;

use App\QuizOptions;
use App\QuizQuestions;
use App\QuizType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankSoalController extends Controller
{
    public function showQuizTopics()
    {
        $topics = QuizType::all();

        return view('_admins.tables.bankSoal.topic-table', compact('topics'));
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
        $questions = QuizQuestions::orderByDesc('id')->get();

        return view('_admins.tables.bankSoal.question-table', compact('questions'));
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
        $options = QuizOptions::orderByDesc('question_id')->get();

        return view('_admins.tables.bankSoal.option-table', compact('options'));
    }

    public function createQuizOptions(Request $request)
    {
        $question = QuizQuestions::find($request->question_id);

        $checkOptions = QuizOptions::where('question_id', $request->question_id)->get();
        if (count($checkOptions) == 5) {
            return back()->with('error', 'Add option for ' . $question->question_text . ' is failed! It\'s already have 5 options.');

        } else {
            foreach ($checkOptions as $row) {
                if ($request->correct == true) {
                    $row->update(['correct' => false]);
                }
            }

            QuizOptions::create([
                'question_id' => $request->question_id,
                'option' => $request->option,
                'correct' => $request->correct == null ? false : $request->correct
            ]);

            return back()->with('success', '' . $question->question_text . '\'s option (' . $request->option . ') is successfully created!');
        }
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
            'correct' => $request->correct == null ? false : $request->correct
        ]);

        $question = QuizQuestions::find($option->question_id);
        $checkOptions = QuizOptions::where('question_id', $request->question_id)->where('correct', true)->count();

        if ($checkOptions > 0) {
            return back()->with('success', '' . $question->question_text . '\'s option (' . $option->option . ') is successfully updated!');
        } else {
            return back()->with('warning', '' . $question->question_text . '\'s option (' . $option->option . ') is successfully updated! But there\'s no correct answer for it, so please select an option as the correct answer.');
        }
    }

    public function deleteQuizOptions($id)
    {
        $option = QuizOptions::find(decrypt($id));
        $option->delete();

        $question = QuizQuestions::find($option->question_id);
        $checkOptions = QuizOptions::where('question_id', $option->question_id)->count();

        if ($checkOptions < 5) {
            return back()->with('warning', '' . $question->question_text . '\'s option (' . $option->option . ') is successfully deleted! But now it\'s only have ' . $checkOptions . ' option, so please create ' . (5 - $checkOptions) . ' more option.');

        } else {
            return back()->with('success', '' . $question->question_text . '\'s option (' . $option->option . ') is successfully deleted!');
        }
    }
}

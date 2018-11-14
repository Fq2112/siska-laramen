<?php

namespace App\Http\Controllers\Seekers;

use App\Provinces;
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
        return view('_seekers.quiz');
    }
}

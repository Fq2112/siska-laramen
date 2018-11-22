<?php

namespace App\Http\Middleware\Seekers;

use App\QuizInfo;
use App\QuizResult;
use App\Seekers;
use Closure;
use Illuminate\Support\Facades\Auth;

class QuizMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->isSeeker()) {
                $seeker = Seekers::where('user_id', Auth::user()->id)->first();
                $quiz = QuizInfo::where('unique_code', $request->quiz_code)->first();
                $checkSeekerQuiz = QuizResult::where('quiz_id', $quiz->id)->where('seeker_id', $seeker->id)->count();
                if (!$checkSeekerQuiz) {
                    return $next($request);
                }
            }
        } else {
            return $next($request);
        }
        return response(view('errors.403'), 403);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizOptions extends Model
{
    protected $table = 'quiz_options';

    protected $guarded = ['id'];

    public function getQuizQuestion()
    {
        return $this->belongsTo(QuizQuestions::class, 'question_id');
    }
}

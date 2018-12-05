<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestions extends Model
{
    protected $table = 'quiz_questions';

    protected $guarded = ['id'];

    public function getQuizType()
    {
        return $this->belongsTo(QuizType::class, 'quiztype_id');
    }

    public function getQuizOption()
    {
        return $this->hasMany(QuizOptions::class, 'question_id');
    }
}

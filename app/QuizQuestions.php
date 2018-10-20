<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestions extends Model
{
    protected $table = 'quiz_questions';

    protected $guarded = ['id'];
}

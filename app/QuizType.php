<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizType extends Model
{
    protected $table = 'quiz_types';

    protected $guarded = ['id'];
}

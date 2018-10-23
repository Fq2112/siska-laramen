<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizInfo extends Model
{
    protected $table = 'quiz_infos';

    protected $guarded = ['id'];

    protected $casts = ['question_ids' => 'array'];
}

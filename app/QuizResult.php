<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $table = 'quiz_results';

    protected $guarded = ['id'];

    public function getQuizInfo()
    {
        return $this->belongsTo(QuizInfo::class, 'quiz_id');
    }
}

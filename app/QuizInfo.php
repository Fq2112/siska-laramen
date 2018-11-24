<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizInfo extends Model
{
    protected $table = 'quiz_infos';

    protected $guarded = ['id'];

    protected $casts = ['question_ids' => 'array'];

    public function getVacancy()
    {
        return $this->belongsTo(Vacancies::class, 'vacancy_id');
    }

    public function getQuizResult()
    {
        return $this->hasMany(QuizResult::class, 'quiz_id');
    }
}

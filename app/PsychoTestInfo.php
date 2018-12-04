<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PsychoTestInfo extends Model
{
    protected $table = 'psycho_test_infos';

    protected $guarded = ['id'];

    protected $casts = ['room_codes' => 'array'];

    public function getVacancy()
    {
        return $this->belongsTo(Vacancies::class, 'vacancy_id');
    }

    public function getPsychoTestResult()
    {
        return $this->hasMany(PsychoTestResult::class, 'psychoTest_id');
    }
}

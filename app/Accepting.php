<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accepting extends Model
{
    protected $table = 'acc';

    protected $guarded = ['id'];


    public function getVacancy()
    {
        return $this->belongsTo(Vacancies::class,'vacancy_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancies extends Model
{
    protected $table = 'vacancy';

    protected $guarded = ['id'];

    public function agencies()
    {
        return $this->belongsTo(Agencies::class);
    }
}

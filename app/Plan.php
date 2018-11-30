<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $table = 'plans';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function getVacancy()
    {
        return $this->hasMany(Vacancies::class, 'plan_id');
    }

    public function getConfirmAgency()
    {
        return $this->hasMany(ConfirmAgency::class, 'plans_id');
    }
}

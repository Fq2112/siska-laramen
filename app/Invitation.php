<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use SoftDeletes;

    protected $table = 'invitations';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function GetAgency()
    {
        return $this->belongsTo('App\Agencies','agency_id');
    }

    public function GetSeeker()
    {
        return $this->belongsTo('App\Seeker','seeker_id');
    }

    public function GetVacancy()
    {
        return $this->belongsTo(Vacancies::class, 'vacancy_id');
    }
}

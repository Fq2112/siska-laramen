<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';

    protected $guarded = ['id'];

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

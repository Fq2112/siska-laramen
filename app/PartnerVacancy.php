<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerVacancy extends Model
{
    protected $table = 'partner_vacancies';

    protected $guarded = ['id'];

    public function getVacancy()
    {
        return $this->belongsTo(Vacancies::class, 'vacancy_id');
    }

    public function getPartner()
    {
        return $this->belongsTo(PartnerCredential::class, 'partner_id');
    }
}

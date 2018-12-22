<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerCredential extends Model
{
    protected $table = 'partner_credentials';

    protected $guarded = ['id'];

    public function getPartnerVacancy()
    {
        return $this->hasMany(PartnerVacancy::class, 'partner_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agencies extends Model
{
    protected $table = 'agencies';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancies::class, 'agency_id');
    }
}

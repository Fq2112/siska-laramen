<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tingkatpend extends Model
{
    protected $table = 'tingkatpends';

    protected $guarded = ['id'];

    public function getEducation()
    {
        return $this->hasMany(Education::class, 'tingkatpend_id');
    }
}

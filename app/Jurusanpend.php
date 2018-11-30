<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusanpend extends Model
{
    protected $table = 'jurusanpends';

    protected $guarded = ['id'];

    public function getEducation()
    {
        return $this->hasMany(Education::class, 'jurusanpend_id');
    }
}

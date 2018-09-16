<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = 'provinces';

    public function cities()
    {
        return $this->hasMany(Cities::class, 'province_id');
    }
}

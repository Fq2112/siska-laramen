<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = 'provinces';

    protected $guarded = ['id'];

    public function cities()
    {
        return $this->hasMany(Cities::class, 'province_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';

    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
}

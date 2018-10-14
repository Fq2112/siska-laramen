<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';

    protected $guarded = ['id'];

    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
}

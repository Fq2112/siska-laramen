<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $table = 'skills';

    protected $guarded = ['id'];

    public function seekers()
    {
        return $this->belongsTo(Seekers::class);
    }
}

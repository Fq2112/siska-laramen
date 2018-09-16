<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'trainings';

    protected $guarded = ['id'];

    public function seekers()
    {
        return $this->belongsTo(Seekers::class);
    }
}

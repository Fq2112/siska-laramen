<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experiences';

    protected $guarded = ['id'];

    public function seekers()
    {
        return $this->belongsTo(Seekers::class);
    }
}

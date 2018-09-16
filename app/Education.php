<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $guarded = ['id'];

    public function seekers()
    {
        return $this->belongsTo(Seekers::class);
    }
}

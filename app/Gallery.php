<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $guarded = ['id'];

    public function agencies()
    {
        return $this->belongsTo(Agencies::class);
    }
}

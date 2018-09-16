<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $table = 'carousels';

    protected $guarded = ['id'];

    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
}

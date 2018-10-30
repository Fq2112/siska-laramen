<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RubikPenilaian extends Model
{
    protected $table = 'rubik_penilaians';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}

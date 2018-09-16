<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tingkatpend extends Model
{
    protected $table = 'tingkatpends';

    protected $fillable = [
        'id', 'name',
    ];
}

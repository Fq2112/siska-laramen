<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusanpend extends Model
{
    protected $table = 'jurusanpends';

    protected $fillable = [
        'id', 'name',
    ];
}

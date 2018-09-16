<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenisblog extends Model
{
    protected $table = 'jenisblog';

    protected $fillable = [
        'id', 'nama',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FungsiKerja extends Model
{
    protected $table = 'fungsi_kerja';

    protected $fillable = [
        'id', 'nama',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    protected $table = 'attachments';

    protected $fillable = [
        'seeker_id', 'files'
    ];
}

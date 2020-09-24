<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sent extends Model
{
    protected $table = 'sents';

    protected $guarded = ['id'];

    protected $casts = ['attachments' => 'array'];
}

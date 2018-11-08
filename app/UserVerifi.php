<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVerifi extends Model
{
    protected $table = 'user_verifications';

    protected $fillable = ['id','user_id','token'];
}

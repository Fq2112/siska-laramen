<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteAgency extends Model
{
    protected $table = 'favorite_agencies';

    protected $guarded = ['id'];
}

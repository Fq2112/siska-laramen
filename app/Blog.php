<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';

    protected $guarded = ['id'];

    public function jenisBlog()
    {
        return $this->belongsTo(Jenisblog::class);
    }
}

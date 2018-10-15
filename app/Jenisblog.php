<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenisblog extends Model
{
    protected $table = 'jenisblog';

    protected $guarded = ['id'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'jenisblog_id');
    }
}

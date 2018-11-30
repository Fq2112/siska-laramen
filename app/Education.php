<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $guarded = ['id'];

    public function seekers()
    {
        return $this->belongsTo(Seekers::class);
    }

    public function getDegree()
    {
        return $this->belongsTo(Tingkatpend::class, 'tingkatpend_id');
    }

    public function getMajor()
    {
        return $this->belongsTo(Jurusanpend::class, 'jurusanpend_id');
    }
}

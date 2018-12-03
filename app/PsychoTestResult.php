<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PsychoTestResult extends Model
{
    protected $table = 'psycho_test_results';

    protected $guarded = ['id'];

    public function getPsychoTestInfo()
    {
        return $this->belongsTo(PsychoTestInfo::class, 'psychoTest_id');
    }
}

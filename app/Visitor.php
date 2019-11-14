<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public $attributes = ['hits' => 0];

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $table = 'visitors';

    public static function boot()
    {
        parent::boot();
        // When a new instance of this model is created...
        static::creating(function ($visitor) {
            $visitor->hits = 0;
        });

        // Any time the instance is saved (create OR update)
        static::saving(function ($visitor) {
            $visitor->visit_date = date('Y-m-d');
            $visitor->visit_time = date('H:i:s');
            $visitor->hits++;
        });
    }

    // Fill in the IP and today's date
    public function scopeCurrent($query)
    {
        return $query->where('ip', $_SERVER['REMOTE_ADDR'])->where('date', date('Y-m-d'));
    }

    public static function hit()
    {
        static::firstOrCreate([
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => date('Y-m-d'),
        ])->save();
    }
}
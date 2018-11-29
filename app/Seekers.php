<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seekers extends Model
{
    protected $table = 'seekers';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function accepting()
    {
        return $this->hasMany(Accepting::class, 'seeker_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'seeker_id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class, 'seeker_id');
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function languages()
    {
        return $this->hasMany(Languages::class);
    }

    public function skills()
    {
        return $this->hasMany(Skills::class);
    }
}

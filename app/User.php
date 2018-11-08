<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check whether this user is agency or not
     * @return bool
     */
    public function isAgency()
    {
        return ($this->role == Role::AGENCY);
    }

    /**
     * Check whether this user is seeker or not
     * @return bool
     */
    public function isSeeker()
    {
        return ($this->role == Role::SEEKER);
    }

    /**
     * Check whether this user is admin or not
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->role == Role::ADMIN);
    }

    /**
     * Check whether this user is root or not
     * @return bool
     */
    public function isRoot()
    {
        return ($this->role == Role::ROOT);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function scopeByActivationColumns(Builder $builder, $email, $verifyToken)
    {
        return $builder->where('email', $email)->where('verifyToken', $verifyToken);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function seekers()
    {
        return $this->hasOne(Seekers::class);
    }

    public function agencies()
    {
        return $this->hasOne(Agencies::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}

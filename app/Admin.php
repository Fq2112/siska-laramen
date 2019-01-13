<?php

namespace App;

use App\Support\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'admins';

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
     * Check whether this user is root or not
     * @return bool
     */
    public function isRoot()
    {
        return ($this->role == Role::ROOT);
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
     * Check whether this user is interviewer or not
     * @return bool
     */
    public function isInterviewer()
    {
        return ($this->role == Role::INTERVIEWER);
    }

    /**
     * Check whether this user is Quiz_staff or not
     * @return bool
     */
    public function isQuizStaff()
    {
        return ($this->role == Role::QUIZ_STAFF);
    }

    /**
     * Check whether this user is Sync_staff or not
     * @return bool
     */
    public function isSyncStaff()
    {
        return ($this->role == Role::SYNC_STAFF);
    }


    public function carousels()
    {
        return $this->hasMany(Carousel::class);
    }
}

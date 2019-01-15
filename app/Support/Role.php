<?php
/**
 * Created by PhpStorm.
 * User: fiqy_
 * Date: 5/28/2018
 * Time: 12:20 AM
 */

namespace App\Support;


class Role
{
    //admin Privilege
    const ROOT = 'root';
    const VACANCY_STAFF = 'vacancy_staff';
    const QUIZ_STAFF = 'quiz_staff';
    const SYNC_STAFF = 'sync_staff';
    const INTERVIEWER = 'interviewer';

    //other Privilege
    const SEEKER = 'seeker';
    const AGENCY = 'agency';

    const ALL = [
        Role::AGENCY,
        Role::SEEKER,
        Role::INTERVIEWER,
        Role::QUIZ_STAFF,
        Role::SYNC_STAFF,
        Role::VACANCY_STAFF,
        Role::ROOT,
    ];

    /**
     * check whether the role is exist or not
     * @param $role_name
     * @param null $delimitter
     * @return bool
     */
    public static function check($role_name, $delimitter = null)
    {
        if (is_null($delimitter)) {
            if (in_array($role_name, Role::ALL)) {
                return true;
            }
        }

        return false;
    }
}
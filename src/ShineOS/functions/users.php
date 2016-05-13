<?php

/* Functions for Users */

use ShineOS\Core\Users\Entities\Users;


    function findByUserID($id)
    {
        return Users::where('user_id','=',$id)->first();
    }

    function findByColumn($column)
    {
        return Users::get($column);
    }

    function getUserPhoto()
    {
        $user = Session::get('_global_user');
        $xuser = findByUserID($user->user_id);

        //refresh session
        Session::put('_global_user', $xuser);

        return $xuser->profile_picture;
    }

    function getUserByFacilityUserID($id)
    {

    }

    function getRoleByFacilityUserID($id = NULL)
    {
        $role = DB::table('roles_access')
            ->join('roles', 'roles.role_id', '=', 'roles_access.role_id')
            ->select('roles.role_name')
            ->where('roles_access.facilityuser_id', $id)
            ->first();

        return $role;
    }

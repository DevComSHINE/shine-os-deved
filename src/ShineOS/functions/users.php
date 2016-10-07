<?php

/* Functions for Users */

use ShineOS\Core\Users\Entities\Users;


    function findByUserID($id)
    {
        return Users::where('user_id','=',$id)->first();
    }

    function findUserByUserID($id)
    {
        $user = DB::table('users')
            ->join('user_md', 'user_md.user_id', '=', 'users.user_id')
            ->join('user_contact', 'user_contact.user_id', '=', 'users.user_id')
            ->where('users.user_id', $id)
            ->first();
        if($user){
            return $user;
        } else {
            return NULL;
        }
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

    function getRoleByFacilityUserID($id = NULL)
    {
        $role = DB::table('roles_access')
            ->join('roles', 'roles.role_id', '=', 'roles_access.role_id')
            ->select('roles.role_name')
            ->where('roles_access.facilityuser_id', $id)
            ->first();

        return $role;
    }

    function getRoleInfoByFacilityUserID($id = NULL)
    {
        $role = DB::table('roles_access')
            ->join('roles', 'roles.role_id', '=', 'roles_access.role_id')
            ->where('roles_access.facilityuser_id', $id)
            ->first();

        return $role;
    }

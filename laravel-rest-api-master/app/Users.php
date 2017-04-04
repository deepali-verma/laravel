<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public static function getUsers(){
        $users =  Users::where('delete_flag',0)->orderBy("id","ASC")->get(['id','first_name','last_name','email']);
        return $users;
    }
}

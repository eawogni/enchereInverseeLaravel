<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

     /**
     * La liste des utilisateurs associés à ce rôle
     */
    public function Users(){
        return $this->belongsToMany('App\User', 'users_roles', 'role_id', 'user_id');
    }
}

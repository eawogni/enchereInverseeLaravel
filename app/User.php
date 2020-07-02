<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        protected $fillable = [
            'login', 'nom', 'prenom', 'date_de_naissance', 'email', 'password',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Récupères toutes les mises de ce utilisateur
     * @return collection
     */
    public function mises(){
        return $this->hasMany(Mise::class);
    }

    /**
     * La liste des rôles auquels l'utilisateur est associé
     */
    public function roles(){
        return $this->belongsToMany('App\Role', 'users_roles', 'user_id', 'role_id');
    }

    /**
     * Vérifie que l'utilisateur possède un rôle bien définit
     * @param $role le rôle à vérifier
     * @return boolean
     */
    public function hasRole($role){
        $collectionRoles = $this->roles->pluck('nom');
        return $collectionRoles->contains($role);
    }

    /**
     * Vérifie que l'utilisateur ne possède aucun rôle atrement dit est juste un utilisateur inscrit
     * @return boolean
     */
    public function hasNoRole(){
        $collectionRoles = $this->roles->pluck('nom');
        return $collectionRoles->count()==0;
    }

}

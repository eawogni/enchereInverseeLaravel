<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mise extends Model
{
     /**
     * Récupères l'enchre associé à cette mise
     * @return \App\Enchere
     */
    public function Enchere(){
        return $this->belongsTo(Enchere::class);
    }

     /**
     * Récupères l'utilisateur associé à cette mise
     * @return \App\User
     */
    public function User(){
        return $this->belongsTo(User::class);
    }
}

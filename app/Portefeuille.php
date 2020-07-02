<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portefeuille extends Model
{
    protected $fillable = [
        'solde','id_user'
    ];
}

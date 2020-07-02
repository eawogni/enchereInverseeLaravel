<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable =['libelle'];
    
    public function produits(){
        return $this->hasMany(Produit::class);
    }
}

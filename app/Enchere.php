<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enchere extends Model
{
    protected $fillable =['date_debut','date_fin','cout_mise','prix_indicatif','produit_id'];
    /**
     * Retourne le produit assici à cet enchère
     * @return \App\Produit
     */
    public function produit(){
        return $this->belongsTo(Produit::class);
    }

    /**
     * Retourne le numéro de l'enchère 
     * @return string
     */
    public function libelle(){
        return 'enchere_'.$this->id.'_'.$this->produit->nom;
    }
}

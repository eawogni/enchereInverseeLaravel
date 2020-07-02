<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produit extends Model
{
    /**
     * 
     */
    protected $fillable = ['nom','description','categorie_id','image1','image2','image3'];

    /**
     * Retourne la cat�gorie auquelle est associé à ce produit
     * @return \App\Categorie
     */
    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Retourne l'ensemble des encheres associées ce produit
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function encheres(){
        return $this->hasMany(Enchere::class);
    }

     /**
     * Retourne l'ensemble des encheres associées ce produit
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function encheresEnCours(){
       $encheres =$this->encheres;
       return $encheres->where("date_fin",'>=',date('Y-m-d'));
    }
}

<?php

namespace App\Http\Controllers\FO;

use App\Administrateur;
use App\Categorie;
use App\Enchere;
use App\Http\Controllers\Controller;
use App\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class ProduitController extends Controller
{
    private $produits = null;
    private $criteres=[
        'categorie'=>'',
        'enchere_en_cours'=>false
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  

       $produits = $this->produits == null? Produit::paginate(2) : $this->produits;
       $categories = Categorie::all();
       $criteres= $this->criteres;
       return view('fo.produit.index', compact('produits','categories','criteres'));
    }

     /**
     *Recherche les produits ayants la categories passé en paramètres
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByCategorie(Categorie $categorie)
    {
        $this->produits =Produit::where('categorie_id',$categorie->id)->paginate(5);
        $this->criteres['categorie'] = $categorie->libelle;
        return  $this->index();
    }

    /**
     *Recherche le produit ayant le nom en paramètre
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBySearch(Request $request)
    {
        $this->produits =Produit::where('nom','like',"%".$request->nomProduit."%")->paginate(5);
        return  $this->index();
    }

     /**
     * Selectionne les produits qui sont en cours d'encères
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByEnchere()
    {
      $listeIdEncheres =Enchere::where('date_fin','>=',date('Y-m-d'))->pluck('produit_id');
      $this->produits =Produit::whereIn('id',$listeIdEncheres)->paginate(2);
      $this->criteres['enchere_en_cours']= true;
      return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        return view('fo.produit.show',compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //
    }
}

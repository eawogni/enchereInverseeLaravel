    @extends('layouts.app')
    @section('content')
       <h5>Bienvenue {{Auth::user()->login}}
        <div>
            <a href={{route('categorie_index')}} >Catégories</a>
            <a href={{route('produit_index')}} >Produits</a>
            <a href={{route('enchere_index')}} >Enchere</a>    
        </div>
    @endsection


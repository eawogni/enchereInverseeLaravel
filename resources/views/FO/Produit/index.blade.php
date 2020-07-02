@extends('layouts.app')

@section('content')
  <div class="">
    <div class="row">
      <div class="col-sm-3">
        <div>
          <form method='POST' action="{{route('fo_produit_by_search')}}">
            @csrf
            <div class="form-group col">
              <div class="col-sm-10">
                <input type="text" 
                  name='nomProduit' 
                  class="form-control form-control-sm d-inline"
                  id="" 
                  placeholder="Rechercher un produit"
                  >
              </div>
            </div>
            <div class="form-group col">
              <div class="col-auto d-inline">
                  <button type="submit" class="btn btn-primary mb-2">@lang('Rechercher')</button>
              </div>
            </div>
         </form>
        </div>

        <h5>Catégories</h5>
        <ul style="list-style-type:none">
          @foreach ($categories as $categorie)
              <li><input name="test" id="" type="radio" {{$categorie->libelle == $criteres['categorie'] ? "checked":''}} onclick="window.location.assign('{{route('fo_produit_by_category',['categorie'=>$categorie])}}')"> {{$categorie->libelle}} </li>
          @endforeach  
        </ul>  
        <hr>
         <h5>Enchères</h5>
        <ul style="list-style-type:none">
            <li><input type="radio"{{$criteres['enchere_en_cours']==true ? "checked":''}}  onclick="window.location.assign('{{route('fo_produit_by_enchere_en_cours')}}')"> En cours d'enchère</li> 
        </ul>   
      </div>
   

      <div class="col-sm-9">
        <div class="row">
          @forelse ($produits as $produit)
          <a href="{{route('fo_produit_show',['produit'=>$produit->id])}}">
              <div class="card mr-3 mb-3" style="width: 18rem;">
                <h5 class="card-title">{{$produit->nom}}</h5>
                <img class="card-img-top" src={{asset('storage/produits/'.$produit->image1)}} alt="">
                <div class="card-body">
                  {{--}} <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                </div>
              </div>
          </a>
          @empty
            <div> @lang('Aucun produit trouvé')</div>
          @endforelse
        </div>
      </div>
  </div>
    {{$produits->links() }}
  <div>

  </div>
@endsection
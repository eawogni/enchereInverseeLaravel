@extends('layouts.app')

@section('content')
  <div class="container">
    <div class='row'>
     @forelse($categories as $categorie)
  
      <div class="card mr-2 mb-2" style="width: 10rem;">
        <div class="card-body">
          <h5 class="card-title d-inline">{{$categorie->libelle}}<span class="badge badge-primary badge-pill d-inline">{{count($categorie->produits)}}</span></h5>
        {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
        <br>
          <a href={{route('fo_produit_by_category',['categorie'=>$categorie->id])}} class="btn btn-primary">Voir</a>
        </div>
      </div>
    @empty
      <div> @lang("Aucune catégorie trouvée")</div>
     @endforelse
    </div>
  </div>
  <div>{{$categories->links()}}</div>
@endsection

  
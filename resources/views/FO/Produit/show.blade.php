@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-5">
        <div class="text-center"><h4>{{$produit->nom}}</h4></div>
        <div id="carousselImagesProduit" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="rounded" widith=400 height=250 src={{asset('storage/produits/'.$produit->image1)}} alt="Image 1">
            </div>
            <div class="carousel-item">
              <img class="rounded"  widith=400 height=250 src={{asset('storage/produits/'.$produit->image2)}} alt="Image 2">
            </div>
            <div class="carousel-item">
              <img class="rounded"  widith=400 height=250 src={{asset('storage/produits/'.$produit->image3)}} alt="Image 3">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carousselImagesProduit" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">@lang('Préccédent')</span>
          </a>
          <a class="carousel-control-next" href="#carousselImagesProduit" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">@lang('Suivant')</span>
          </a>
        </div>
      </div>
      <div class="col-7">
      <br>
          {{$produit->description}}
      </div>
    </div>
    @if($produit->encheresEnCours()->count())!=0)
      <p>
        <div class="row">
            <table class="table table-striped text-center ">
              <thead>
                <tr>
                  <th scope="col">Début enchère</th>
                  <th scope="col">Fin Enchère</th>
                  <th scope="col">Coût mise</th>
                  <th scope="col">Prix indicatif</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($produit->encheresEnCours() as $enchere)
                    <tr>
                      <td>{{$enchere->date_debut}}</td>
                      <td>{{$enchere->date_fin}}</td>
                      <td>{{$enchere->cout_mise}}</td>
                      <td>{{$enchere->prix_indicatif}}</td>
                      <td>
                        <form class="inline" method='POST' action={{route('categorie_store')}}>
                        @csrf
                          <div class="row">
                            <div class="">
                              <input type="number" 
                                name='montant_mise' 
                                class="form-control form-control-sm @error('montant_mise') is-invalid @enderror" 
                                id="montant_mise" 
                                placeholder="Insérer votre montant de mise"
                                value={{old('montant_mise')}}
                                >
                              @error('montant_mise')
                                  <p class="text-danger">
                                      {{$message}}
                                  </p>
                              @enderror
                            </div>
                            <div>
                              <button type="submit" class="btn btn-primary mb-2">@lang('Miser')</button>
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </p>
    @endif
  </div>   
@endsection


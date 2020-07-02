@extends('layouts.app')

@section('content') 
  <div class="container">  
    <form method='POST' action="{{route('enchere_update',['enchere'=>$enchere->id])}}">
    @csrf
    @method('PUT')
    {{-- date de début --}}
      <div class="form-group col">
        <label for="date_debut" class="col-sm-2 col-form-label col-form-label-sm">@lang('Date de début')</label>
        <div class="col-sm-10">
          <input type="date"
            name='date_debut' 
            class="form-control form-control-sm @error('date_debut') is-invalid @enderror" 
            id="date_debut"
            value={{ $errors->has('date_debut')? old('date_debut'): $enchere->date_debut }}
            >   
          @error('date_debut')
              <p class="text-danger">
                  {{$message}}
              </p>
          @enderror
        </div>
      </div>

      {{-- date de fin --}}
      <div class="form-group col">
      <label for="date_fin" class="col-sm-2 col-form-label col-form-label-sm">@lang('Date de fin')</label>
        <div class="col-sm-10">
          <input type="date"
            name='date_fin' 
            class="form-control form-control-sm @error('date_fin') is-invalid @enderror" 
            id="date_fin"
            value={{ $errors->has('date_fin')? old('date_fin'): $enchere->date_fin }}
            > 
          @error('date_fin')
              <p class="text-danger">
                  {{$message}}
              </p>
          @enderror
        </div>
      </div>

      {{-- co�t mise --}}
      <div class="form-group col">
      <label for="date_debut" class="col-sm-2 col-form-label col-form-label-sm">@lang('Coût mise')</label>
        <div class="col-sm-10">
          <input type="number"
            step="0.01"
            name='cout_mise' 
            class="form-control form-control-sm @error('date_fin') is-invalid @enderror" 
            id="date_fin"
            value={{ $errors->has('cout_mise')? old('cout_mise'): $enchere->cout_mise }}
            > 
          @error('date_fin')
              <p class="text-danger">
                  {{$message}}
              </p>
          @enderror
        </div>
      </div>

      {{-- prix indicatif --}}
      <div class="form-group col">
      <label for="prix_indicatif" class="col-sm-2 col-form-label col-form-label-sm">@lang('Prix indicatif')</label>
        <div class="col-sm-10">
          <input type="number"
            step="0.01"
            name='prix_indicatif' 
            class="form-control form-control-sm @error('prix_indicatif') is-invalid @enderror" 
            id="prix_indicatif"
            value={{ $errors->has('prix_indicatif')? old('prix_indicatif'): $enchere->prix_indicatif }}
            > 
          @error('prix_indicatif')
              <p class="text-danger">
                  {{$message}}
              </p>
          @enderror
        </div>
      </div>

      {{-- prix indicatif --}}
      <div class="form-group col">
      <label for="produit" class="col-sm-2 col-form-label col-form-label-sm">@lang('Produit')</label>
        <div class="col-sm-10">
          <select name="produit">
            @foreach ($produits as $produit )
                <option value="{{$produit->id}}">{{$produit->nom}}</option>
            @endforeach
          </select>
          @error('produit')
              <p class="text-danger">
                  {{$message}}
              </p>
          @enderror
        </div>
      </div>

      <div class="form-group col">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">@lang('Modifier')</button>
        </div>
      </div> 
    </form>
  </div>
@endsection

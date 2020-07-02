@extends('layouts.app')

@section('errors_messages')
    <div class="container">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>@lang('Veuillez corriger les erreurs ci-dessous')</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{$message}}</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
    </div>
@endsection

@section('content') 
  <div class="container">  
    <form method='POST' action={{route('enchere_store')}}>
    @csrf
      {{-- date de début --}}
      <div class="form-group col">
        <label for="date_debut" class="col-sm-2 col-form-label col-form-label-sm">@lang('Date de début')</label>
        <div class="col-sm-10">
          <input type="date"
            name='date_debut' 
            class="form-control form-control-sm @error('date_debut') is-invalid @enderror" 
            id="date_debut"
            value={{old('date_debut')}}
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
            value={{old('date_fin')}}
            > 
          @error('date_fin')
              <p class="text-danger">
                  {{$message}}
              </p>
          @enderror
        </div>
      </div>
      <input id="jour_precedent" name="jour_precedent" type="hidden" value={{$hier}} >
      

      {{-- coût mise --}}
      <div class="form-group col">
      <label for="date_debut" class="col-sm-2 col-form-label col-form-label-sm">@lang('Coût mise')</label>
        <div class="col-sm-10">
          <input type="number"
            step="0.01"
            name='cout_mise' 
            class="form-control form-control-sm @error('cout_mise') is-invalid @enderror" 
            id="cout_mise"
            value={{old('cout_mise')}}
            > 
          @error('cout_mise')
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
            value={{old('prix_indicatif')}}
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
            <button type="submit" class="btn btn-primary mb-2">@lang('Créer')</button>
        </div>
      </div>
    </form>
  </div>
  @endsection
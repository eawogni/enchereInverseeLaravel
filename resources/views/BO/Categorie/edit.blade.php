@extends('layouts.app')

@section('content')
  <div class="container">
    <form method='POST' action="{{route('categorie_update',['categorie'=>$categorie->id])}}">
    @csrf
    @method('PUT')
      <div class="form-group col">
        <label for="libelle" class="col-sm-2 col-form-label col-form-label-sm">@lang('Libelle')</label>
        <div class="col-sm-10">
          <input type="text" 
            name='libelle' 
            class="form-control form-control-sm @error('libelle') is-invalid @enderror" 
            id="nom_categorie" 
            placeholder="Libelle de la catégorie"
            value="{{ $errors->has('libelle')? old('libelle') : $categorie->libelle }}"
            >
          @error('libelle')
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


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
    <form method='POST' action={{route('categorie_store')}}>
    @csrf
      <div class="form-group col">
        <label for="libelle" class="col-sm-2 col-form-label col-form-label-sm">@lang('Libelle')</label>
        <div class="col-sm-10">
          <input type="text" 
            name='libelle' 
            class="form-control form-control-sm @error('libelle') is-invalid @enderror" 
            id="nom_categorie" 
            placeholder="Libelle de la catégorie"
            value={{old('libelle')}}
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
            <button type="submit" class="btn btn-primary mb-2">@lang('Créer')</button>
        </div>
      </div>
    </form>
  </div>
@endsection
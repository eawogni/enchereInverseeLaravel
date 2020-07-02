@extends('layouts.app')

@section('content') 
  <div class="container">  
    <form method='POST' enctype="multipart/form-data" action={{route('produit_update',['produit'=>$produit->id])}}>
    @csrf
      @method('PUT')
    {{-- Nom--}}
      <div class="form-group col">
        <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Nom')</label>
        <div class="col-sm-10">
          <input type="text" 
            name='nom' 
            class="form-control form-control-sm @error('nom') is-invalid @enderror" 
            id="nom" 
            placeholder="Saisir le nom du produit"
            value="{{ $errors->has('nom')? old('nom') : $produit->nom }}"
            >
            @error('nom')
                <p class="text-danger">
                    {{$message}}
                </p>
            @enderror
        </div>
      </div>

      {{-- Description --}}
      <div class="form-group col">
        <label for="description" class="col-sm-2 col-form-label col-form-label-sm">@lang('Description')</label>
        <div class="col-sm-10">
          <input type="text" 
            name='description' 
            class="form-control form-control-sm @error('description') is-invalid @enderror" 
            id="description" 
            placeholder="Saisir le nom du produit"
            value="{{ $errors->has('description')? old('description') : $produit->description }}"
            >
            @error('description')
                <p class="text-danger">
                    {{$message}}
                </p>
            @enderror
        </div>
      </div>

      {{--Catégorie --}}
          <div class="form-group col">
            <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Catégorie')</label>
            <div class="col-sm-10">

              <select name="categorie">
              @foreach ($categories as $categorie )
                <option value={{$categorie->id}} {{$categorie->id == $produit->categorie_id ? "selected=selected":''}}>
                  {{$categorie->libelle}}
                </option> 
              @endforeach
              </select>

                @error('categorie')
                    <p class="text-danger">
                        {{$message}}
                    </p>
                @enderror
            </div>
      </div>

      {{--Image1--}}
        <div class="form-group col">
          <div class="col-sm-10">
            <label for="image1">@lang('Image 1')</label>
            <input type="file"  name="image1" accept=".png, .jpeg, .jpg" class="form-control-file" id="image1">
                @error('image1')
                      <p class="text-danger">
                          {{$message}}
                      </p>
                @enderror
          </div>   
      </div>

      {{--Image2--}}
        <div class="form-group col">
          <div class="col-sm-10">
            <label for="image2">@lang('Image 2')</label>
            <input type="file" name="image2" accept=".png, .jpeg, .jpg" class="form-control-file" id="image2">
              @error('image2')
                      <p class="text-danger">
                          {{$message}}
                      </p>
            @enderror
          </div>
      </div>

      {{--Image3--}}
        <div class="form-group col">
          <div class="col-sm-10">
            <label for="image3">@lang('Image 3')</label>
            <input type="file" name='image3' accept=".png, .jpeg, .jpg" class="form-control-file" id="image2">
              @error('image3')
                      <p class="text-danger">
                          {{$message}}
                      </p>
              @enderror
          </div>
      </div>

      {{-- boutton d'envoie--}}
      <div class="form-group col">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">@lang('Modifier')</button>
        </div>
      </div>        
    </form>
  </div>
@endsection

@extends('layouts.app')

@section('errors_messages')
    <div class="container">
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
    <form method='POST' enctype="multipart/form-data" action={{route('user_update',['user'=>$user->id])}}>
    @csrf
      @method('PUT')

        {{-- Login--}}
      <div class="form-group col">
        <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Log')</label>
        <div class="col-sm-10">
          <input type="text" 
            name='login' 
            class="form-control form-control-sm @error('nom') is-invalid @enderror" 
            id="login" 
            value="{{ $errors->has('login')? old('login') : $user->login }}"
            >
            @error('login')
                <p class="text-danger">
                    {{$message}}
                </p>
            @enderror
        </div>
      </div>

    {{-- Nom--}}
      <div class="form-group col">
        <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Nom')</label>
        <div class="col-sm-10">
          <input type="text" 
            name='nom' 
            class="form-control form-control-sm @error('nom') is-invalid @enderror" 
            id="nom" 
            value="{{ $errors->has('nom')? old('nom') : $user->nom }}"
            >
            @error('nom')
                <p class="text-danger">
                    {{$message}}
                </p>
            @enderror
        </div>
      </div>

      {{-- Prénom --}}
        <div class="form-group col">
          <label for="prenom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Prenom')</label>
            <div class="col-sm-10">
              <input type="text" 
                name='prenom' 
                class="form-control form-control-sm @error('nom') is-invalid @enderror" 
                id="prenom" 
                value="{{ $errors->has('prenom')? old('prenom') : $user->prenom }}"
              >
              @error('prenom')
                  <p class="text-danger">
                      {{$message}}
                  </p>
              @enderror
          </div>
        </div>

      {{--Date de naissance --}}
      <div class="form-group col">
        <label for="date_de_naissance" class="col-sm-2 col-form-label col-form-label-sm">@lang('Date de naissance')</label>
        <div class="col-sm-10">
            <input id="date_de_naissance" type="date" class="form-control @error('date_de_naissance') is-invalid @enderror" name="date_de_naissance"
              value="{{ $errors->has('date_de_naissance')? old('date_de_naissance') : $user->date_de_naissance }}" required autocomplete="date_de_naissance" autofocus>

            @error('date_de_naissance')
                <p class="text-danger">
                    {{$message}}
                </p>
            @enderror
        </div>
      </div>

      {{--Email --}}
      <div class="form-group col">
        <label for="email" class="col-sm-2 col-form-label col-form-label-sm">@lang('email')</label>
        <div class="col-sm-10">
           <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" 
           value="{{ $errors->has('email')? old('email') : $user->email }}" required autocomplete="email">

            @error('email')
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

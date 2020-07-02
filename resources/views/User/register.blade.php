@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Créer un compte administrateur')</div>

                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('user_store') }}">
                        @csrf
                        {{--Login --}}
                        <div class="form-group row">
                            <label for="login" class="col-md-4 col-form-label text-md-right">@lang('Log')</label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{--Nom--}}
                        <div class="form-group row">
                            <label for="nom" class="col-md-4 col-form-label text-md-right">@lang('Nom')</label>

                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>

                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        {{--Prénom--}}
                        <div class="form-group row">
                            <label for="prenom" class="col-md-4 col-form-label text-md-right">@lang('Prénom')</label>

                            <div class="col-md-6">
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" autofocus>

                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         {{--Date de naisssance--}}
                        <div class="form-group row">
                            <label for="date_de_naissance" class="col-md-4 col-form-label text-md-right">@lang('Date de naissance')</label>

                            <div class="col-md-6">
                                <input id="date_de_naissance" type="date" class="form-control @error('date_de_naissance') is-invalid @enderror" name="date_de_naissance" value="{{ old('date_de_naissance') }}" required autocomplete="date_de_naissance" autofocus>

                                @error('date_de_naissance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{--Email--}}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">@lang('Email')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{--Password--}}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('Password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{--Confirmer mot de passe--}}
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('Confirm Password')</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('Valider')
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

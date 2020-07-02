@extends('layouts.app')

@section('content')
  <div class="container">
  <h4>Mes Informations Personnelles</h4>
        <div class="row">
            <table class="table table-striped text-center ">
              <thead>
                <tr>
                  <th scope="col">Login</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Prénom</th>
                  <th scope="col">Email</th>
                  <th scope="col">Date de naissance</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                    <tr>
                      <td>{{$user->login}}</td>
                      <td>{{$user->nom}}</td>
                      <td>{{$user->prenom}}</td>
                      <td>{{$user->email}}</td>
                      <td>@php echo(date('d-m-Y', strtotime($user->date_de_naissance)))@endphp </td>
                      <td> 
                          <a href="{{route('user_edit',['user'=>$user->id])}}" class="btn btn-primary btn-xs" role="button" aria-disabled="true">@lang('Modifier')</a>
                      </td>
                    </tr>
              </tbody>
            </table>
        </div>
  </div>   
@endsection


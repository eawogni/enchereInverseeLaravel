@extends('layouts.app')

@section('success_msessages')
    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
      <div>
        <a class="btn btn-success btn-sm" href={{route('enchere_create')}}> @lang('Ajouter une enchère') </a>
        <!-- Button trigger modal -->
       <button type="button" id="btnAdd" class="btn btn-success">
        @lang('Ajouter')
      </button>
      </div>
   
      {{--datatable--}}
      {!! $html->table(['class' => 'table table-striped']) !!}
      <div>{{$allEncheres->links()}}</div>
    </div>

    {{--modal--}}
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@lang('Ajouter')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div id="messages"></div>
              <form method='POST' action={{route('enchere_store')}} id="sampleForm">
                @csrf
                      {{-- date de début --}}
                  <div class="form-group col">
                    <label for="date_debut" class="col-sm-2 col-form-label col-form-label-sm d-inline">@lang('Date de début')</label>
                    <div class="col-sm-10">
                      <input type="date"
                        name='date_debut' 
                        class="form-control form-control-sm resource" 
                        id="date_debut"
                      > 
                      <div id="date_debut_error" class="text-danger"></div>  
                    </div>
                  </div>
                  <input id="jour_precedent" name="jour_precedent" type="hidden" value={{$hier}} >

                  {{-- date de fin --}}
                  <div class="form-group col">
                  <label for="date_fin" class="col-sm-2 col-form-label col-form-label-sm d-inline">@lang('Date de fin')</label>
                    <div class="col-sm-10">
                      <input type="date"
                        name='date_fin' 
                        class="form-control form-control-sm resource" 
                        id="date_fin"
                        > 
                      <div id="date_fin_error" class="text-danger"></div>
                    </div>
                  </div>

                  {{-- coût mise --}}
                  <div class="form-group col">
                  <label for="date_debut" class="col-sm-2 col-form-label col-form-label-sm d-inline">@lang('Coût mise')</label>
                    <div class="col-sm-10">
                      <input type="number"
                        step="0.01"
                        name='cout_mise' 
                        class="form-control form-control-sm resource" 
                        id="cout_mise"
                      > 
                      <div id="cout_mise_error" class="text-danger"></div>
                    </div>
                  </div>

                  {{-- prix indicatif --}}
                  <div class="form-group col">
                  <label for="prix_indicatif" class="col-sm-2 col-form-label col-form-label-sm d-inline">@lang('Prix indicatif')</label>
                    <div class="col-sm-10">
                      <input type="number"
                        step="0.01"
                        name='prix_indicatif' 
                        class="form-control form-control-sm resource" 
                        id="prix_indicatif"
                      > 
                      <div id="prix_indicatif_error" class="text-danger"></div>
                    </div>
                  </div>

                  {{-- prix indicatif --}}
                  <div class="form-group col">
                  <label for="produit" class="col-sm-2 col-form-label col-form-label-sm d-inline">@lang('Produit')</label>
                    <div class="col-sm-10">
                      <select name="produit" id="produit" class="form-control form-control-sm resource" >
                        @foreach ($produits as $produit )
                            <option value="{{$produit->id}}">{{$produit->nom}}</option>
                        @endforeach
                      </select>
                      <div id="produit_error" class="text-danger"></div>
                    </div>
                  </div>

                  <div class="form-group col">
                    <div class="col-auto">
                        <button type="submit" id="btnSubmit" class="btn btn-success mb-2">@lang('Ajouter')</button>
                    </div>
                 </div>
                
            </form>
          </div>
        </div>
      </div>
  </div>
     
@endsection

@push('js-bottom')
  {!! $html->scripts() !!}
  <script src="js/formManager.js"></script>
@endpush

  
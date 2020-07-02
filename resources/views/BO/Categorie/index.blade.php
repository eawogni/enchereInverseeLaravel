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
      <a class="btn btn-success btn-sm" href={{route('categorie_create')}}> @lang('Ajouter une catégorie') </a>
        <!-- Button trigger modal -->
       <button type="button" id="btnAdd" class="btn btn-success">
         @lang('Ajouter')
      </button>
   
    </div>
      {{--datatable--}}
      {!! $html->table(['class' => 'table table-striped']) !!}
      {{--pagination--}}
      <div>{{$allCategories->links()}}</div>
  </div>

  <!-- Modal -->
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
            <form method='POST' action={{route('categorie_store')}} id="sampleForm">
              @csrf
              <div class="form-group col">
                <label for="libelle" class="col-sm-2 col-form-label col-form-label-sm">@lang('Libelle')</label>
                <div class="col-sm-10">
                  <input type="text" 
                    name='libelle' 
                    class="form-control form-control-sm resource" 
                    id="libelle" 
                    placeholder="Libelle de la catégorie"
                    >
                  <div id="libelle_error" class="text-danger"></div>
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
  <script src="{{asset('js/formManager.js')}}"></script>
  
@endpush

  
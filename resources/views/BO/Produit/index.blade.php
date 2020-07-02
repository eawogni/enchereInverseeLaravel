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
  <div>
    <a class="btn btn-success btn-sm" href={{route('produit_create')}}> @lang('Ajouter un produit') </a>
     <button type="button" id="btnAdd" class="btn btn-success">
        @lang('Ajouter')
      </button>
  </div>
  {{--datatable--}}
  {!! $html->table(['class' => 'table table-striped']) !!}
  <div>
    {{$allProduits->links()}}
  </div>
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
            <form method='POST' action={{route('produit_store')}} id="sampleForm">
            @csrf
            {{-- Nom--}}
            <div class="form-group col">
              <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Nom')</label>
              <div class="col-sm-10">
                <input type="text" 
                  name='nom' 
                  class="form-control form-control-sm resource" 
                  id="nom" 
                  placeholder="Nom du produit"
                  >
                  <div id="nom_error" class="text-danger"></div>
              </div>
            </div>

            {{-- Description --}}
            <div class="form-group col">
              <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Description')</label>
              <div class="col-sm-10">
                <input type="text" 
                  name='description' 
                  class="form-control form-control-sm resource" 
                  id="description" 
                  placeholder="Description du produit"
                  value={{old('description')}}
                  >
                  <div id="description_error" class="text-danger"></div>
              </div>
            </div>

            {{--Catégorie --}}
              <div class="form-group col">
                <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">@lang('Catégorie')</label>
                <div class="col-sm-10">
                    <select name="categorie" id='categorie' class="form-control form-control-sm resource" >
                      @foreach ($categories as $categorie )
                        <option value={{$categorie->id}}>{{$categorie->libelle}}</option> 
                      @endforeach
                    </select>
                     <div id="categorie_error" class="text-danger"></div>
                </div>
               
              </div>

            {{--Image1--}}
              <div class="form-group col">
                <div class="col-sm-10">
                  <label for="image1">@lang('Image 1')</label>
                  <input type="file"  name="image1" accept=".png, .jpeg, .jpg" class="form-control-sm form-control-file resource" id="image1">
                  <div id="image1_error" class="text-danger"></div> 
                </div>  
               
            </div>

            {{--Image2--}}
              <div class="form-group col">
                <div class="col-sm-10">
                  <label for="image2">@lang('Image 2')</label>
                  <input type="file" name="image2"  accept=".png, .jpeg, .jpg" class="form-control-sm form-control-file resource" id="image2">
                  <div id="image2_error" class="text-danger"></div>
                </div>
            </div>

            {{--Image3--}}
              <div class="form-group col">
                <div class="col-sm-10">
                  <label for="image3">@lang('Image 3')</label>
                  <input type="file" name='image3'  accept=".png, .jpeg, .jpg" class="form-control-sm form-control-file resource" id="image3">
                   <div id="image3_error" class="text-danger"></div>
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
  <script>formManager.editing_mode=false;</script>
@endpush

  
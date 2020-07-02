{{--button de suppression--}}
<form action="{{$deleteAction}}"
        class= "d-inline"
        method="POST"
        onSubmit="return confirm('Voulez-vous vraiment effectuer cette action ?')"
        >
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-2">@lang('Supprimer')</button>
</form>
{{--button d'édition--}}
<div class="d-inline">
        @if($hrefUpdate=="#")
                <a class="btn btn-primary mb-2"  href={{$editHref}}> @lang('Modifier') </a>     
        @else
                <button type="button" class="btn btn-primary mb-2 edit_button"  hrefFormEdit={{$editHref}} hrefupdate={{$hrefUpdate}}> @lang('Modifier') </button> 
        @endif
</div>

{{--button de suppression--}}
<form action="{{$deleteAction}}"
        class= "d-inline"
        method="POST"
        onSubmit="return confirm('Voulez-vous vraiment effectuer cette action ?')"
        >
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-2"><i class="fas fa-trash"></i></button>
</form>
{{--button d'édition--}}
<div class="d-inline">
        @if($hrefUpdate=="#")
                <a class="btn btn-primary mb-2"  href={{$editHref}}><i class="fas fa-edit edit_button"></i></a>     
        @else
                <button class="btn btn-primary mb-2 edit_button"  hrefFormEdit={{$editHref}} hrefupdate={{$hrefUpdate}}> <i class="fas fa-edit "></i> </button>
        @endif
</div>

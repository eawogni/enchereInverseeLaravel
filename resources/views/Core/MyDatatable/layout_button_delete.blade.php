<form action="{{$action}}"
        class='d-inline'
        method="POST"
        onSubmit="return confirm('Voulez-vous vraiment effectuer cette suppression ?')"
        >
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-2">@lang('Supprimer')</button>
</form>

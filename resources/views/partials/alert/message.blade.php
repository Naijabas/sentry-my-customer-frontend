@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-danger') }} show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="">&times;</span>
    </button>
    <strong class="">{{ Session::get('message') }}!</strong>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="">&times;</span>
    </button>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


@extends('layout.base')

@section("custom_css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<style>
    .select2-container--classic .select2-selection--multiple .select2-selection__choice {
        background-color: #5369f8;
        border: 1px solid #5369f8;
    }

    .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }

</style>
@stop

@section('content')
<div class="container-fluid">

    <div class="row page-title align-items-center">
        <div class="col-sm-4 col-xl-6">
            <h4 class="mb-1 mt-0">Compose</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4 float-sm-left">Compose Message</h3>

                    <a href="{{ route('broadcast.index') }}" class="btn btn-primary float-right">
                        Go Back
                    </a>

                    @include('partials.alert.message')

                    <div class="row col-12">
                        <form action="{{ route('broadcast.store') }}" method="POST" class="col-12">
                            @csrf

                            <div class="form-group">
                                <label>Choose customers to receive broadcast</label>
                                <select class="form-control col-12 jstags" multiple name="numbers[]">
                                    @foreach ($customers as $key => $value)
                                    <option value="{{$value}}">{{$key}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Message</label>
                                <textarea rows="5" class="form-control col-12" name="message" maxlength="100">
                                    @if(isset($template))
                                    {{$template}}  
                                    @endif                                                                                   
                                    </textarea>
                            </div>
                            {{--    --}}
                            <button class="btn btn-primary" type="submit">Send &nbsp;<i
                                    class="fa fa-paper-plane my-float"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("javascript")
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(".jstags").select2({
        theme: "classic",
        tags: true,
    });

</script>
@stop

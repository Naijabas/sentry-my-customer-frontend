{{-- inherits base markup --}}
{{-- got my page working im so excited --}}
@extends('layout.base')
{{-- add in the basic styling : check the contents of these stylesheets later --}}
@section("custom_css")
    <link rel="stylesheet" href="{{asset('backend/assets/css/singleCustomer.css')}}">
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css"/>
@stop


{{-- yield body content --}}

@section('content')
    <div class="content">

        <div class="container-fluid">
            {{-- start of page title --}}
            <div class="row page-title">
                <div class="col-md-12">
                    <h4 class="mb-1 mt-0 float-left">Profile</h4>
                    <a href="{{ route('assistants.index') }}" class="btn btn-primary float-right">
                        Go Back
                    </a>
                    <a href="{{route('assistants.edit', $data->_id) }}" class="mr-3 btn btn-success float-right">
                        Edit Assistant
                    </a>
                </div>
            </div>
            @include('partials.dashboard.store_assistant')
        </div>
    </div>
@endsection
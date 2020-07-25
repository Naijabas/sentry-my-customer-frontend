@extends('layout.base')

@section("custom_css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

@stop

@section('content')
    <div class="container-fluid">
        <div class="row page-title align-items-center">
            <div class="col-sm-4 col-xl-6">
                <h4 class="mb-1 mt-0">Dashboard</h4>
            </div>
        </div>
        @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_admin')
            @include('partials.dashboard.store_admin');
        @endif

        @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_assistant')
            @include('partials.dashboard.store_assistant');
        @endif

        @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'super_admin')
            @include('partials.dashboard.super_admin')
        @endif
    </div>
@endsection


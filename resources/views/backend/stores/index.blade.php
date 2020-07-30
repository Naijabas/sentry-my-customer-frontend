@extends('layout.base')
@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('backend/assets/css/store_list.css')}}">
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
                    <div class="customer-heading-container">
                        <h4 class="mb-1 mt-0">All Stores</h4>
                        <button class="add-customer-button btn btn-primary" data-toggle="modal">
                            <a href="{{ route('store.create') }}" class="text-white">
                                Add New <i class="fa fa-plus add-new-icon"></i>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
            @include('partials.alert.message')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="form-group col-lg-12 mt-4">
                                        <div class="row">
                                            <label class="form-control-label">Search Stores</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="search"></i>
                                                </span>
                                                </div>
                                                <input type="text" class="form-control" id="store-name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(\Cookie::get('user_role') == 'super_admin')
                <div class="row" style="margin-top:20px;">
                    @foreach ($response as $store)
                        <div class="col-xl-3 col-sm-6" style="margin-bottom: 20px;">
                            <div id="idd" class="card text-center">
                                <div class="card-body">
                                    <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                @php
                                    $names = explode(" ", strtoupper($store[0]->store_name));
                                    $ch = "";
                                    foreach ($names as $name) {
                                    $ch .= $name[0];

                                    }
                                    echo $ch;
                                @endphp
                            </span>
                                    </div>
                                    <h5 class="font-size-15"><a href="#"
                                                                class="text-dark search-name">{{$store[0]->store_name }}</a>
                                    </h5>
                                    <p class="text-muted">{{$store[0]->email ?? ''}}</p>
                                    <p class="text-muted">{{$store[0]->shop_address ?? ''}}</p>

                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="contact-links d-flex font-size-20">
                                        <div class="flex-fill">
                                            <a href="{{ route('store.show', $store[0]->_id) }}" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="View Store"><i
                                                        data-feather="eye"></i></a>
                                        </div>

                                        <div class="flex-fill">
                                            <a href="{{route('store.edit', $store[0]->_id) }}" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Edit"><i
                                                        data-feather="edit"></i></a>
                                        </div>


                                        <div class="flex-fill">
                                            <a class="" href="#" data-toggle="modal"
                                               data-target="#deleteModal-{{$store[0]->_id}}"><i
                                                        data-feather="trash-2"></i></a>

                                            <div class="modal fade" id="deleteModal-{{$store[0]->_id}}" tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="storeDeleteLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="storeDeleteLabel">Delete Store
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form class="form-horizontal" method="POST"
                                                              action="{{ route('store.destroy', $store[0]->_id) }}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('DELETE')
                                                                <h6>Are you sure you want to
                                                                    delete {{$store[0]->store_name}}</h6>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="">
                                                                    <button type="submit" class="btn btn-primary mr-3"
                                                                            data-dismiss="modal"><i
                                                                                data-feather="x"></i>
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-danger"><i
                                                                                data-feather="trash-2"></i> Delete
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row" style="margin-top:20px;">
                    @foreach ($response as $store)
                        <div class="col-xl-3 col-sm-6" style="margin-bottom: 20px;">
                            <div id="idd" class="card text-center">
                                <div class="card-body">
                                    <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                @php
                                    $names = explode(" ", strtoupper($store->store_name));
                                    $ch = "";
                                    foreach ($names as $name) {
                                    $ch .= $name[0];

                                    }
                                    echo $ch;
                                @endphp
                            </span>
                                    </div>
                                    <h5 class="font-size-15"><a href="#"
                                                                class="text-dark search-name">{{$store->store_name }}</a>
                                    </h5>
                                    <p class="text-muted">{{$store->email ?? ''}}</p>
                                    <p class="text-muted">{{$store->shop_address ?? ''}}</p>

                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="contact-links d-flex font-size-20">
                                        <div class="flex-fill">
                                            <a href="{{ route('store.show', $store->_id) }}" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="View User"><i
                                                        data-feather="eye"></i></a>
                                        </div>

                                        <div class="flex-fill">
                                            <a href="{{route('store.edit', $store->_id) }}" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Edit"><i
                                                        data-feather="edit"></i></a>
                                        </div>


                                        <div class="flex-fill">
                                            <a class="" href="#" data-toggle="modal"
                                               data-target="#deleteModal-{{$store->_id}}"><i data-feather="trash-2"></i></a>

                                            <div class="modal fade" id="deleteModal-{{$store->_id}}" tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="storeDeleteLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="storeDeleteLabel">Delete Store
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form class="form-horizontal" method="POST"
                                                              action="{{ route('store.destroy', $store->_id) }}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('DELETE')
                                                                <h6>Are you sure you want to
                                                                    delete {{$store->store_name}}</h6>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="">
                                                                    <button type="submit" class="btn btn-primary mr-3"
                                                                            data-dismiss="modal"><i
                                                                                data-feather="x"></i>
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-danger"><i
                                                                                data-feather="trash-2"></i> Delete
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="row">
                {{$response->links()}}
            </div>

        </div>
    </div>
@endsection

@section("javascript")

    <script>
        //for search bar
        let storeName = $('#store-name');

        //add input event listener
        storeName.on('keyup', (e) => {
            const users = $('.search-name');
            const filterText = e.target.value.toLowerCase();

            users.each(function (i, item) {
                // console.log($(this).html());
                if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                    $(this).parent().parent().parent().css('display', 'block');

                } else {
                    $(this).parent().parent().parent().css('display', 'none');
                }

            });
        });
    </script>
@stop

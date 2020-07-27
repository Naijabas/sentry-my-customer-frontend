@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="{{asset('backend/assets/css/store_list.css')}}">
@stop

@if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_admin')

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
                                            <input type="text" class="form-control" id="customer-name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">
                            List of all stores
                        </p>
                        <div class="table-responsive">
                            <table class="table mb-0" id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($response as $index => $store )
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="store-name">{{ $store->store_name }}</td>
                                        <td>{{ $store->shop_address }}</td>
                                        <td>
                                            <div class="btn-group mt-2 mr-1">
                                                <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('store.show', $store->_id) }}">View
                                                        Store</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('store.edit', $store->_id) }}">Edit
                                                        store</a>
                                                    <a class="dropdown-item" href="" data-toggle="modal"
                                                        data-target="#storeDelete">Deleted store</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                    {{-- Modal for delete Store --}}
                                    <div class="modal fade" id="storeDelete" tabindex="-1" role="dialog"
                                        aria-labelledby="storeDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="storeDeleteLabel">Delete Transaction
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('store.destroy', $store->_id ?? '') }}">
                                                    <div class="modal-body">
                                                        @csrf
                                                        @method('DELETE')
                                                        <h6>Are you sure you want to delete this Store</h6>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="">
                                                            <button type="submit" class="btn btn-primary mr-3"
                                                                data-dismiss="modal"><i data-feather="x"></i>
                                                                Close</button>
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    data-feather="trash-2"></i> Delete</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section("javascript")
<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {});

</script>

<script>
    //for search bar
    let userText = document.querySelector('#customer-name')
    let rows = document.querySelectorAll('.store-name')

    //add input event listener
    userText.addEventListener('keyup', showFilterResults)

    function showFilterResults(e) {
        const users = rows;
        const filterText = e.target.value.toLowerCase();

        users.forEach(function (item) {
            if (item.textContent.toLowerCase().indexOf(filterText) !== -1) {
                item.parentElement.style.display = 'table-row'

            } else {
                item.parentElement.style.display = 'none'

            };
        });
    };

</script>
@stop
@endif

@if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'super_admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <div class="customer-heading-container">
                    <h4 class="mb-1 mt-0">All Stores</h4>

                </div>
            </div>
        </div>
       
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
                                            <input type="text" class="form-control" id="customer-name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">
                            List of all stores
                        </p>
                        <div class="table-responsive">
                            <table class="table mb-0" id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Store Email</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $count = 0
                                    @endphp
                                    @foreach ($response as $index => $stores )
                                    @foreach ($stores as $store)
                                    <tr>
                                        <td>{{ $count += 1 }}</td>
                                        <td class="store-name">{{ $store->store_name }}</td>
                                        <td class="store-email">{{ $store->email }}</td>
                                        <td>{{ $store->shop_address }}</td>
                                        <td>
                                            <div class="btn-group mt-2 mr-1">
                                                <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('store.show', $store->_id) }}">View
                                                        Store</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('store.edit', $store->_id) }}">Edit
                                                        store</a>
                                                    <a class="dropdown-item" href="" data-toggle="modal"
                                                        data-target="#storeDelete">Deleted store</a>
                                                 
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @endforeach

                                    {{-- Modal for delete Store --}}
                                    <div class="modal fade" id="storeDelete" tabindex="-1" role="dialog"
                                        aria-labelledby="storeDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="storeDeleteLabel">Delete Transaction
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
                                                        <h6>Are you sure you want to delete this Store</h6>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="">
                                                            <button type="submit" class="btn btn-primary mr-3"
                                                                data-dismiss="modal"><i data-feather="x"></i>
                                                                Close</button>
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    data-feather="trash-2"></i> Delete</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section("javascript")
<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {});

</script>

<script>
    //for search bar
    let userText = document.querySelector('#customer-name')
    let rows = document.querySelectorAll('.store-name')

    //add input event listener
    userText.addEventListener('keyup', showFilterResults)

    function showFilterResults(e) {
        const users = rows;
        const filterText = e.target.value.toLowerCase();

        users.forEach(function (item) {
            if (item.textContent.toLowerCase().indexOf(filterText) !== -1) {
                item.parentElement.style.display = 'table-row'

            } else {
                item.parentElement.style.display = 'none'

            };
        });
    };

</script>

@stop
@endif

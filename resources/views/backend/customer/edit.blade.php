{{-- inherits base markup --}}
@extends('layout.base')

{{-- add in the basic styling : check the contents of these stylesheets later --}}
@section("custom_css")
<link rel="stylesheet" href="{{asset('backend/assets/css/singleCustomer.css')}}">
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
@stop


{{-- yield body content --}}

@section('content')
<div class="content">
    @isset($response)
    <div class="container-fluid">
        @include('partials.alert.message')

        {{-- start of page title --}}
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0 float-left">Edit Profile Page</h4>
                <a href="{{ route('customer.index') }}" class="btn btn-primary float-right">
                    Go Back {{-- &nbsp;<i class="fa fa-plus my-float"></i> --}}
                </a>
            </div>
        </div>
        {{-- end of page title --}}

        {{-- start of content section --}}
        <div class="row contentrow">
            {{--start of person profile--}}
            <div class="col-lg-3 col-md-4 col-sm-5" id="h1IdTop">
                <div class="card">
                    <div class="card-body text-center text-muted">
                        {{-- <img src="../../backend/assets/images/users/avatar-7.jpg" alt="Customer 1" class="img-fluid rounded-circle"> --}}
                        <h4>{{ ucfirst($response->customer->name) }}</h4>
                        {{-- <h5 class="cust-email">{{ $response->email }}</h5> --}}
                    </div>
                    {{-- <div class="address">
                         <h5>House Address</h5>
                         <p class="customer-address">1975, Boring Lane, San <br>Francisco, California, United<br> States - 94108</p>
                     </div> --}}
                </div>
            </div>
            {{--end of person profile--}}

            <div class="col-lg-9 col-md-8 col-sm-7">
                {{-- start of card --}}

                <div class="card">
                    <div class="card-body">
                        <form id="submitForm" class="form-horizontal" role="form" method="post"
                            action="{{ route('customer.update', $response->storeId.'-'.$response->customer->_id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Full Name:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text"
                                        value="{{old('name', $response->customer->name)}}" name="name" required
                                        pattern=".{5,30}"
                                        title="Customer name must be at least 5 characters and not more than 30 characters">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Tel:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="tel" id="phone"
                                        value="{{old('phone_number', $response->customer->phone_number)}}"
                                        aria-describedby="helpPhone" name='' pattern=".{6,16}"
                                        title="Phone number must be between 6 to 16 characters" required>
                                    <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                                    <small id="helpPhone" class="form-text text-muted">Enter your number without the
                                        starting 0, eg 813012345</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Store Name:</label>
                                <div class="col-lg-8">
                                    <select name="store_name" class="form-control" disabled required>
                                        @if ( isset($stores) )
                                        @foreach ($stores as $store)
                                        <option @if ( ($store->store_name == $response->storeName) )
                                            value="{{$store->_id}}" disabled selected @endif>{{$response->storeName}}
                                        </option>
                                        @endforeach
                                        @else
                                        <option disabled selected value="">-- You have not registered a store yet --
                                        </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                    <span></span>
                                    <input type="reset" class="btn btn-default" value="Cancel">
                                </div>
                            </div>
                        </form>

                        {{--customer basic info end--}}
                    </div>
                </div>
                <!-- end card -->
            </div>
            {{--End of person profile--}}
        </div>



        {{--end of column--}}
    </div>
    @endisset
</div>

@endsection

@section("javascript")
<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        // any initialisation options go here
    });


    //phone Number format

    var input = document.querySelector("#phone");
    var test = window.intlTelInput(input, {
        // any initialisation options go here
    });

    $("#phone").keyup(() => {
        if ($("#phone").val().charAt(0) == 0) {
            $("#phone").val($("#phone").val().substring(1));
        }
    });

    $("#submitForm").submit((e) => {
        e.preventDefault();
        const dialCode = test.getSelectedCountryData().dialCode;
        if ($("#phone").val().charAt(0) == 0) {
            $("#phone").val($("#phone").val().substring(1));
        }

        if (dialCode != undefined) {
            $("#phone_number").val(dialCode + $("#phone").val());
            $("#submitForm").off('submit').submit();
        } else {
            $("#phone_number").val($("#phone").val());
            $("#submitForm").off('submit').submit();
        }
    });

</script>
@stop

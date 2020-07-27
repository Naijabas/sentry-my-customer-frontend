@extends('layout.authbase')
@section("custom_css")

<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/sign-up-valid.css" rel="stylesheet" type="text/css" />

@stop


@section('content')
<div class="container-fluid">
    @include('partials.alert.message')

    <div class="row ">
        <div class="col-lg-4 bg-white">
            <div class=" m-h-100">
                <div class="account-pages pt-5">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12 p-5">
                                        <div class="mx-auto mb-5">
                                            <a href="{{ route('home') }}">
                                                <img src="{{ ('/frontend/assets/images/fulllogo.png') }}" alt=""
                                                    height="auto" /> </a>
                                        </div>
                                        <h3 class="h3 mb-0 mt-4 text-center">Register</h3>

                                        <form action="{{route('register')}}" class="authentication-form" method="POST"
                                            id="submitForm">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-control-label mt-0 mb-2">Phone Number</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                    </div>
                                                    <input type="number" id="phone" name="" class="form-control"
                                                        value="" aria-describedby="helpPhone" placeholder="813012345"
                                                        required>
                                                    <input type="hidden" name="phone_number" id="phone_number"
                                                        class="form-control">
                                                    <div class="red-warn">Please enter a valid phone number</div>
                                                </div>
                                                <small id="helpPhone" class="form-text text-muted">Enter your number
                                                    without the starting 0, eg 813012345</small>
                                                <label class="form-control-label mt-2 mb-2">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password" name="password"
                                                        class="form-control" required>
                                                </div>
                                                <div class="pass-feedback"></div>
                                            </div>

                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit"> Get
                                                    Started
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Back to <a href="{{ route('login') }}"
                                        class="text-primary font-weight-bold ml-1">Login</a>
                                </p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                    <!-- end row -->
                    <!-- end container -->
                </div>
                <!-- end page -->


            </div>
        </div>
        <div class="col-lg-8 d-none d-md-block bg-cover"
            style="background-image: url(/backend/assets/images/login.svg);">

        </div>
    </div>
</div>

@endsection


@section("javascript")
<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script>
    $(document).ready(function () {
        var input = document.querySelector("#phone");
        var test = window.intlTelInput(input, {
            separateDialCode: true,
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
            $("#phone_number").val(dialCode + $("#phone").val());
            $("#submitForm").off('submit').submit();

        });
    });

</script>
<script src="/backend/assets/js/pages/sign-up-valid.js"></script>


@stop

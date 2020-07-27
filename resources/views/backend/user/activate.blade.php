@extends('layout.authbase')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />

@stop



@section('content')

{{-- error messages --}}
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
                                                <img src="{{ ('/frontend/assets/images/fulllogo.png') }}" alt="" height="auto" /> </a>
                                        </div>

                                        <h6 class="h5 mb-0 mt-4">Verify Code</h6>
                                        <p class="text-muted mt-1 mb-5">
                                            Please enter the 6-digit code we sent on your number as SMS
                                        </p>
                                        <div class="alert alert-danger alert-dismissible" id="error" style="display: none">
                                            <span id="error-message"> </span>

                                        </div>
                                        <div class="alert alert-success alert-dismissible" id="success" style="display: none">
                                            <span id="success-message">Your account has been activated.
                                                <a href="{{ route('dashboard') }}}">Click Here if you were not redirected</a>
                                            </span>

                                        </div>
                                        <form action="#" class="authentication-form">
                                            <div class="form-group mt-4">
                                                <label class="form-control-label">Enter 6 digit code</label>
                                                <a href="" class="float-right text-muted text-unline-dashed ml-1" id="resend_code">resend code</a>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="lock"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="code" placeholder="X X X X X X">
                                                </div>
                                            </div>

                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit" id="verify">
                                                    Verify
                                                </button>
                                                <button class="btn btn-primary btn-block disabled" type="submit" id="verifying" style="display:none" disabled="disabled">
                                                    Verifying ...
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted">Back to <a href="{{ route('logout') }}"
                                    class="text-primary font-weight-bold ml-1">Login</a>
                                    </p>
                                    <form action="{{route('activate.save')}}" method="POST">
                                        @csrf
                                        <p class="text-muted">
                                            <input type="hidden" name="skip">
                                            <button href="{{ route('dashboard') }}" class="btn text-primary font-weight-bold ml-1">Skip for
                                                now
                                            </button>
                                    </form>
                                    </p>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                        </div> <!-- end col -->
                        <!-- end row -->

                    </div> <!-- end col -->
                    <!-- end row -->
                    <!-- end container -->
                </div>
                <!-- end page -->


            </div>
        </div>
        <div class="col-lg-8 d-none d-md-block bg-cover" style="background-image: url(/backend/assets/images/login.svg);">

        </div>
    </div>
</div>

@endsection


@section("javascript")

<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script>
    $(document).ready(function($) {
        const verifying = $("#verifying");
        const verify = $("#verify");
        const error = $("#error");
        const error_message = $("#error-message");
        const success = $("#success");
        const success_message = $("#success-message");
        let timer = 0;
        verify.click(function(e) {
            e.preventDefault();
            hide_messages();
            $(this).hide();
            verifying.show();
            const data = {
                api_token: '{{$apiToken}}',
                // token: $("#code").val(),
                verify: $("#code").val()
                , phone_number: '{{$phoneNumber}}'
            };
            $.ajax({
                url: "{{env('API_URL') }}/otp/verify"
                , headers: {
                    'x-access-token': '{{$apiToken}}'
                }
                , data: data
                , type: "POST"
            }).done((data) => {
                $(this).show();
                verifying.hide();

                // change is_active cookie to true
                $.post("{{route('activate.save')}}", {
                    "_token": "{{ csrf_token() }}"
                }, () => {
                    success_message.html("Your account has been activated.<br/>" +
                        "<a href='{{route('dashboard')}}'>Click Here if you were not redirected</a>");
                    success.show();
                    window.location = "{{url('/admin/dashboard')}}";
                }).fail(() => {
                    error_message.text("Please Try Again Later or Logout and Login Again");
                    error.show();
                });

            }).fail((e) => {
                e = JSON.parse(e.responseText);
                error_message.text(e.message);
                error.show();
                $(this).show();
                verifying.hide();
            });
        });
        $("#resend_code").click(function(e) {
            e.preventDefault();
            hide_messages();
            if (timer <= 0) {
                verify.hide();
                verifying.show();
                const data = {
                    api_token: '{{$apiToken}}'
                    , phone_number: '{{$phoneNumber}}'
                , };
                $.ajax({
                    url: "{{ env('API_URL') }}/otp/send"
                    , headers: {
                        'x-access-token': '{{$apiToken}}'
                    }
                    , data: data
                    , type: "POST"
                }).done((data) => {
                    let app_env = "{{ env('APP_ENV') }}";
                    if (app_env == 'local') {
                        success_message.html(
                        'Your code has been sent. You can request a new code in 60 seconds' +
                        '<kbd>Your code is ' + data.data.otp + '</kbd>'
                        );
                    }  else {
                        success_message.html(
                        'A new code has been sent to your Phone. You can request a new code in 60 seconds'
                        );
                    }
                    success.show();
                    verify.show();
                    verifying.hide();
                    start_timer();
                }).fail((e) => {
                    e = JSON.parse(e.responseText);
                    error_message.text(e.message);
                    error.show();
                    verify.show();
                    verifying.hide();
                });
            } else {
                error_message.text("You can request a new code in " + timer + " seconds");
                error.show();
            }
        });

        function start_timer() {
            timer = 60;
            let interval = setInterval(() => {
                if (timer > 0)
                    timer -= 1;
                else
                    clearInterval(interval);
            }, 1000);
        }

        function hide_messages() {
            error.hide();
            success.hide();
        }
    });
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        // any initialisation options go here
    });

</script>

@stop

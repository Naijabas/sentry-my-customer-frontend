<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <title>mycustomer - Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="MyCustomer - JusticeLeague" name="description" />
    <meta content="JusticeLeague" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="/frontend/assets/favicon.ico">

    <!-- plugins -->
    <link href="/backend/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/assets/css/custom.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shepherd/2.0.0-beta.1/css/shepherd-theme-arrows.css" />
    <link href="{{asset('backend/assets/css/tourguide.css')}}" rel="stylesheet" type="text/css">
    @if(\Cookie::get('theme') == 'dark')
        <link href="{{asset('backend/assets/css/dark-css.css')}}" rel="stylesheet" type="text/css">
    @endif
    <style>
        .dissapear {
            display: none !important;
        }
    </style>

    <!-- Other Style CSS -->
    @yield('custom_css')


</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">
        @include('partials.bsidebar')

        <!--====================  heaer area ====================-->
        @include('partials.bheader')
        <!--====================  End of heaer area  ====================-->
        <div class="content-page">
            <div class="content">

                @yield('content')

            </div>

            @include('partials.modal.change_profile_pic_modal')

            <!--====================  footer area ====================-->
            @include('partials.bfooter')
            <!--====================  End of footer area  ====================-->
        </div>



    </div>

    <!-- JS============================================ -->

    <!-- Vendor js -->
    <script src="/backend/assets/js/vendor.min.js"></script>
    
    <!-- optional plugins -->
    <script src="/backend/assets/libs/moment/moment.min.js"></script>
    <script src="/backend/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/backend/assets/libs/flatpickr/flatpickr.min.js"></script>
    
    <!-- page js -->
    {{-- <script src="/backend/assets/js/pages/dashboard.init.js"></script> --}}
    <script src="/backend/assets/js/pages/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shepherd/2.0.0-beta.1/js/shepherd.js"></script>
    
    
    <!-- App js -->
    <script src="/backend/assets/js/app.min.js"></script>
    <script src="/backend/assets/js/alert.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    @yield('javascript')
</body>

</html>
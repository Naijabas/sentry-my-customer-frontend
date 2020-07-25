@extends('layout.base')

@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />

    <style>
        .line-head {
            border-bottom: solid 1px #dddddd;
            margin-top: 0 !important;
            margin-bottom: 15px;
        }
        .screen:not(.active) {
            visibility: hidden !important;
            opacity: 0;
            width: 0;
            padding: 0;
            height: 0;
            overflow: hidden;
            transition: opacity .3s ease-in-out;
        }
        .screen.active {
            opacity: 1;
            transition: opacity .3s ease-in-out;
        }
        .profile-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        /* nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: #495057;
            background-color: #FFF;
            border-color: #dee2e6 #dee2e6 #FFF;
        } */
/*
        .nav-tabs li a.active {
            border-left: 5px solid #5369f8 !important;
            border-bottom: none !important;
        } */
    </style>

@stop

@section('content')

    <div class="account-pages my-5">
        <div class="container-fluid">
            <div class="row-justify-content-center">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }} inline">{{ Session::get('message') }}</p>
                @endif
                <div class="h2"><i data-feather="file-text" class="icon-dual"></i> Settings Page</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3">
                            <h4 class="line-head h5 pb-2">Personal Data</h4>
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-3">
                                        <object
                                            data="{{Cookie::get('image')? Cookie::get('image'):'/backend/assets/images/users/avatar-1.jpg'}}"
                                            type="image/jpg"
                                            class="avatar-sm rounded-circle mr-2"
                                        >
                                            <img src="/backend/assets/images/users/default.png" class="avatar-sm rounded-circle mr-2" alt="Shreyu"/>
                                        </object>
                                    </div>
                                    <div class="col-9 pt-1" style="margin-left: -25px;padding-left: 0;">
                                        <p class="mb-1">
                                            <b>
                                                {{ isset($user_details['first_name'])  &&  isset($user_details['last_name']) ? $user_details['first_name'] ." ". $user_details['last_name']: "please update your name" }}
                                            </b>
                                        </p>
                                        <p class="my-0">
                                            {{ isset($user_details['email']) ? $user_details['email'] : "plese update your email"}}
                                        </p>
                                        @php if (isset($user_details['is_active'])): @endphp
                                        <p class="my-0 text-success">
                                            Active
                                        </p>
                                        @php else: @endphp
                                        <p class="my-0 text-dange">
                                            Inactive
                                        </p>
                                        @php endif; @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="card">
                            <ul class="nav flex-column nav-tabs user-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#user-details" data-toggle="tab">Personal Data</a></li>
                                <li class="nav-item"><a class="nav-link" href="#user-profile" data-toggle="tab">Edit Data</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{route('change_password')}}">Change Password</a></li>
                                {{-- <li class="nav-item"><a class="nav-link" href="{{route('change_profile_picture')}}">Change Profile Picture</a></li> --}}
                            </ul>
                        </div>
                    </div> -->
                    <div class="col-md-8">
                        <div class="card p-3">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link hash-candidate active edit-profile" href="#edit-profile">Edit Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link hash-candidate change-password" href="#change-password">Change Password</a>
                                    </li>
                                </ul>
                                <div class="content pt-3">
                                    <div id="edit-profile" class="screen hash-candidate active">
                                        <form method="POST"  action="{{ route('setting') }}" class="profile-form">
                                            @csrf
                                            <div class="row mb-12" style="width: 100%;">
                                                <div class="col-md-8 offset-2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="first_name" placeholder="{{ isset($user_details['first_name']) ? $user_details['first_name'] : "First Name" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="last_name" placeholder="{{ isset($user_details['last_name']) ? $user_details['last_name'] : "Last Name" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Email</label>
                                                            <input class="form-control" type="text" name="email" placeholder="{{ isset($user_details['email']) ? $user_details['email'] : "Email" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Phone Number</label>
                                                           <input class="form-control" type="text" id ="phone" name="phone_number" value="{{ isset($user_details['phone_number']) ? $user_details['phone_number'] : "" }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <input type="text" value="profile_update" name="control" hidden>
                                                </div>

                                                {{-- <div class="col-md-3">
                                                    <img id="preview" class="img img-responsive img-thumbnail" src="{{('backend/assets/images/users/avatar-7.jpg')}}" />

                                                    <div class="form-group">
                                                        <label for="exampleInputFile">File input</label>
                                                        <input class="form-control-file" id="profile_image" type="file" aria-describedby="fileHelp" name="image">
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <br>
                                            <div class="row mb-12">
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="change-password" class="hash-candidate screen">
                                        <form action="{{ route('setting') }}" method="POST" onSubmit="return checkPassword(this)">
                                            {{ csrf_field() }}
                                            <div class="col-8 offset-2">

                                            <label class=" control-label">Current Password</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class=" fa fa-lock"></i></span></div>
                                                    <input class="form-control" name="current_password" type="password" required>
                                                </div>
                                            </div>
                                            <label class="control-label">New Password</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class=" fa fa-lock"></i></span></div>
                                                    <input id="password" class="form-control" name="new_password" type="password" required minlength="6">
                                                </div>
                                            </div>
                                            <label class="control-label">Confirm New Password</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class=" fa fa-lock"></i></span></div>
                                                    <input id="passwordr" class="form-control" name="new_password_confirmation" type="password" required minlength="6">
                                                </div>
                                                <div class="invalid-feedback">
                                                    New Password and confirm new password must be the same
                                                </div>
                                            </div>
                                            <input type="hidden" name="control" value="password_change">
                                            </div>
                                            <div class="d-flex justify-content-center">
                                            <button class="btn btn-primary" type="submit">Update Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-8">
                        <div class="card p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="user-details">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Personal Data</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Fullname</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ isset($user_details['first_name'])  &&  isset($user_details['last_name']) ? $user_details['first_name'] ." ". $user_details['last_name']: "full name" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Email</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ isset($user_details['email']) ? $user_details['email'] : "Email" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Status</b></label>
                                            </div>
                                            <div class="col-md-6">
                                               @isset($user_details['is_active'])
                                                    @if (  $user_details['is_active'] )
                                                    Activated
                                                @else
                                                    Not Activated
                                                @endif
                                               @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Removed by Eni4sure because Node is no longer giving CreatedAt and UpdatedAt --}}
                                    {{-- @php
                                        function time_relative_to_time($ts) {
                                            if(!ctype_digit($ts))
                                                $ts = strtotime($ts);

                                            $diff = time() - $ts;
                                            if($diff == 0)
                                                return 'now';
                                            elseif($diff > 0)
                                            {
                                                $day_diff = floor($diff / 86400);
                                                if($day_diff == 0)
                                                {
                                                    if($diff < 60) return 'just now';
                                                    if($diff < 120) return '1 minute ago';
                                                    if($diff < 3600) return floor($diff / 60) . ' minutes ago';
                                                    if($diff < 7200) return '1 hour ago';
                                                    if($diff < 86400) return floor($diff / 3600) . ' hours ago';
                                                }
                                                if($day_diff == 1) return 'Yesterday';
                                                if($day_diff < 7) return $day_diff . ' days ago';
                                                if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
                                                if($day_diff < 60) return 'last month';
                                                return date('F Y', $ts);
                                            }
                                            else
                                            {
                                                $diff = abs($diff);
                                                $day_diff = floor($diff / 86400);
                                                if($day_diff == 0)
                                                {
                                                    if($diff < 120) return 'in a minute';
                                                    if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
                                                    if($diff < 7200) return 'in an hour';
                                                    if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
                                                }
                                                if($day_diff == 1) return 'Tomorrow';
                                                if($day_diff < 4) return date('l', $ts);
                                                if($day_diff < 7 + (7 - date('w'))) return 'next week';
                                                if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
                                                if(date('n', $ts) == date('n') + 1) return 'next month';
                                                return date('F Y', $ts);
                                            }
                                        }
                                    @endphp
                                    <div class="tab-pane" id="user-timeline">
                                        <div class="tile user-settings">
                                            <h4 class="line-head">Timeline</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label><b>Created</b></label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{ time_relative_to_time($user_details['local']['createdAt']) }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label><b>Last Updated</b></label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{ time_relative_to_time($user_details['local']['updatedAt']) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                {{-- Removed by Eni4sure because Node is no longer giving CreatedAt and UpdatedAt --}}

                                <div class="tab-pane fade" id="user-profile">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Edit Data</h4>
                                        <form method="POST"  action="{{ route('setting') }}">
                                            @csrf
                                            <div class="row mb-12">
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="first_name" value="{{ isset($user_details['first_name']) ? $user_details['first_name'] : "" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="last_name" value="{{ isset($user_details['last_name']) ? $user_details['last_name'] : "" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Email</label>
                                                            <input class="form-control" type="text" name="email" value="{{ isset($user_details['email']) ? $user_details['email'] : "" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Phone Number</label>
                                                            <input class="form-control" type="text" name="phone_number" value="{{ isset($user_details['phone_number']) ? $user_details['phone_number'] : "" }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <input type="text" value="profile_update" name="control" hidden>
                                                </div>

                                                {{-- <div class="col-md-3">
                                                    <img id="preview" class="img img-responsive img-thumbnail" src="{{('backend/assets/images/users/avatar-7.jpg')}}" />

                                                    <div class="form-group">
                                                        <label for="exampleInputFile">File input</label>
                                                        <input class="form-control-file" id="profile_image" type="file" aria-describedby="fileHelp" name="image">
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <br>
                                            <div class="row mb-12">
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- <div class="tab-pane" id="assistant">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Staff Assistant</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p><b>Staff Assigned to You:</b></p>
                                            </div>
                                            <div class="col-md-6">Sean Jones</div>
                                            <div class="col-md-6">
                                                <p>seanjones@customerpay.me</p>
                                                <p>+2345667788912</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div> -->
                </div>

            </div>
        </div>
    </div>

@endsection

@section("javascript")

     <script src="/backend/assets/build/js/intlTelInput.js"></script>
     <script>
         var input = document.querySelector("#phone");
                var test = window.intlTelInput(input, {
                    separateDialCode: true,
                    //initialCountry: "de",
                    // any initialisation options go here
                });

                test.setNumber("+" + ($("#phone").val()));

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
     </script>
<script>    
    var navigation = () => {
  var locationHash = window.location.hash || "#edit-profile";
  $(".hash-candidate").removeClass("active");
  $(locationHash).addClass("active");
  if (locationHash === "#change-password") {
    $(".change-password").addClass("active");
  } else {
    $(".edit-profile").addClass("active");
  }
};
window.onhashchange = navigation;
navigation();

// Function to check Whether both passwords
function checkPassword(form) {
        password1 = form.new_password.value;
        password2 = form.new_password_confirmation.value;
        // If Not same return False.
        if (password1 != password2) {
            return false;
        }
        // If same return True.
        else {
            return true;
        }
    }

    $('#password').keyup(() => {
        let pw = $('#password').val();
        let pwr = $('#passwordr').val();
        if (pw == pwr) {
            $('#passwordr').removeClass('is-invalid');
            $('.invalid-feedback').hide();

        } else {
            $('#passwordr').addClass('is-invalid');
            $('.invalid-feedback').show();
        }
    })

    $('#passwordr').keyup(() => {
        let pw = $('#password').val();
        let pwr = $('#passwordr').val();
        if (pw == pwr) {
            $('#passwordr').removeClass('is-invalid');
            $('.invalid-feedback').hide();

        } else {
            $('#passwordr').addClass('is-invalid');
            $('.invalid-feedback').show();
        }
    })

</script>

@stop
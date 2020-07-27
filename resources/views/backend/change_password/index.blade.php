@extends('layout.base')

@section("custom_css")

<style>
    .line-head {
        border-bottom: solid 1px #dddddd;
        margin-top: 0 !important;
        margin-bottom: 15px;
    }

    nav-tabs .nav-link.active,
    .nav-tabs .nav-item.show .nav-link {
        color: #495057;
        background-color: #FFF;
        border-color: #dee2e6 #dee2e6 #FFF;
    }

    .nav-tabs li a.active {
        border-left: 5px solid #5369f8 !important;
        border-bottom: none !important;
    }

</style>

@stop

@section('content')

<div class="account-pages my-5">
    <div class="container-fluid">
        <div class="row-justify-content-center">
            <div class="h2"><i data-feather="edit" class="icon-dual"></i> Change Password</div>
            <div class="col-md-9 " style="margin: 0 auto">
                @include('partials.alert.message')

                <div class="card p-4">
                    <div class="" id="password-change">
                        <div class="tile user-settings">
                            <form action="{{ route('setting') }}" method="POST" onSubmit="return checkPassword(this)">
                                {{ csrf_field() }}
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
                                <button class="btn btn-primary" type="submit">Update Password</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>

@endsection

@section("javascript")
<script>
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

@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="/backend/assets/build/css/all_users.css">
@stop
@section('content')
<div class="content">
    {{-- <a href="#" class="float" data-toggle="modal"
                                        data-target="#myModal">
<i class="fa fa-plus my-float" ></i>
</a> --}}
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <div class="customer-heading-container">

                    <button class="add-customer-button btn btn-primary" onclick="showModal()">

                        Add New Assistant <i class="fa fa-plus add-new-icon"></i>

                    </button>{{--
                        <button class="add-customer-button btn btn-primary" data-toggle="modal"
                                data-target="#AssistantModal">

                            Add New Assistant <i class="fa fa-plus add-new-icon"></i>

                        </button>--}}
                </div>
            </div>
        </div>

        @include('partials.alertMessage')

        <div class="row page-title">

            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Assistants</h4>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title mt-0 mb-1">Basic Data Table</h4> --}}
                        <p class="sub-header">
                            Find Assistant
                        </p>
                        <div class="container-fluid">
                            <div class="row">
                            <div class="form-group col-lg-12 mt-4">
                                    <div class="row">
                                        <label class="form-control-label">Search Assistants</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="search"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="assistant-name">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>


        <div class="row">
            @foreach ($assistants as $assistant)
            <div  class="col-xl-3 col-sm-6">
                <div id="idd" class="card text-center">
                    <div  class="card-body">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                             @php
                             $names = explode(" ", strtoupper($assistant->name));
                                $ch = "";
                                foreach ($names as $name) {
                                $ch .= $name[0];
                                
                                }
                                echo $ch;
                             @endphp
                            </span>
                        </div>
                        <h5 class="font-size-15"><a href="#" class="text-dark">{{$assistant->name }}</a></h5>
                        <p class="text-muted">{{$assistant->phone_number}} | {{$assistant->email ?? ''}}</p>

                        <div>
                            @if ($assistant->user_role == "store_admin")
                            @endif
                            @if($assistant->is_active)
                            <span class="badge badge-success">Activated</span>

                            @else
                            <span class="badge badge-secondary">Not activated</span>

                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <div class="contact-links d-flex font-size-20">
                            <div class="flex-fill">
                                <a href="{{ route('assistants.show', $assistant->_id) }}" data-toggle="tooltip"
                                    data-placement="top" title="" data-original-title="View User"><i
                                        data-feather="eye"></i></a>
                            </div>

                            <div class="flex-fill">
                                <a href="{{route('assistants.edit', $assistant->_id) }}" data-toggle="tooltip"
                                    data-placement="top" title="" data-original-title="Edit"><i
                                        data-feather="edit"></i></a>
                            </div>


                            <div class="flex-fill">
                                {{-- <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#DeleteModal{{$assistant->_id}}">
                                Delete Assistant</a> --}}


                                <a class="" href="#" data-toggle="modal"
                                    data-target="#DeleteModal{{$assistant->_id}}"><i data-feather="trash-2"></i></a>

                                <div id="DeleteModal{{$assistant->_id}}" class="modal fade bd-example-modal-sm"
                                    tabindex="-2" role="dialog" aria-labelledby="DeleteModal{{$assistant->_id}}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Title{{$assistant->_id}}">
                                                    Delete Assistant </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Do you want to delete {{$assistant->name}}?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('assistants.destroy', $assistant->_id) }}"
                                                    method="POST" id="form">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No,
                                                    I changed my mind
                                                </button>
                                            </div>
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



    </div>
    <div id="AssistantModal" class="modal fade" tabindex="-4" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Assistant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action=" {{ route('assistants.store') }}" method="POST"
                        class="mt-4 mb-3 form-horizontal my-form" id="submitForm">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="name" class="col-2 col-sm-3 col-form-label my-label">Name:</label> <br>
                            <br>
                            <div class="col-10 col-sm-7">
                                <input name="name" type="text" class="form-control" id="name"
                                    placeholder="Enter name here" value="{{old('name')}}">
                            </div>
                        </div>
                        <br>

                        <div class="form-group row mb-3">
                            <label for="address" class="col-2 col-sm-3 col-form-label my-label">Email:</label>
                            <br>
                            <div class="col-10 col-sm-7">
                                <input name="email" type="email" class="form-control" id="email"
                                    placeholder="Enter Address" value="{{old('email')}}">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row mb-3">
                            <label for="number" class="col-2 col-sm-3 col-form-label my-label">Phone
                                Number:</label>
                            <br>
                            <div class="col-10 col-sm-7">
                                <input type="tel" id="phone" name="" class="form-control"
                                    value="" required>
                                <input type="hidden" name="phone_number" id="phone_number" class="form-control">

                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="number" class="col-2 col-sm-3 col-form-label my-label">Store:</label>
                            <br>
                            <div class="col-10 col-sm-7">
                                <select name="store_id" id="store_id" class="form-control">
                                    <option value=""> Select Store</option>
                                    @foreach($stores as $store)
                                    <option value="{{$store->_id}}">{{$store->store_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="email" class="col-2 col-sm-3 col-form-label my-label">Password:</label>
                            <br>
                            <div class="col-10 col-sm-7">
                                <input name="password" type="password" class="form-control" id="fullname"
                                    placeholder="Enter password">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="email" class="col-2 col-sm-3 col-form-label my-label"></label>
                            <div class="col-10 col-sm-7">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-button btn-block">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        var test = window.intlTelInput(input, {
            separateDialCode: true,
            // any initialisation options go here
        });
        //  $("#phone").css('paddingLeft', '96%'); // fix issue with too long number field when modal is opened

        if ($("#phone").val().trim() != '')
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

        function showModal() {
            $('#phone').css('paddingLeft', "unset");
            $("#AssistantModal").modal('show');
        }

        let assistantName = $('#assistant-name');
        let assistantEmail = $('#assistant-email');
        let assistantPhone = $('#assistant-phone');

        //add input event listener
        assistantName.on('keyup', (e) => {
            assistantEmail.val('');
            assistantPhone.val('');
            const assistants = $('.assistant-name');
            const filterText = e.target.value.toLowerCase();

            assistants.each(function (i, item) {
                if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                    $(this).parent().css('display', 'table-row');

                } else {
                    $(this).parent().css('display', 'none');
                }

            });
        });
        assistantEmail.on('keyup', (e) => {
            assistantPhone.val('');
            assistantName.val('');
            const assistants = $('.assistant-email');
            const filterText = e.target.value.toLowerCase();

            assistants.each(function (i, item) {
                if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                    $(this).parent().css('display', 'table-row');

                } else {
                    $(this).parent().css('display', 'none');

                }

            });
        });
        assistantPhone.on('keyup', (e) => {
            assistantEmail.val('');
            assistantName.val('');
            const assistants = $('.assistant-phone');
            const filterText = e.target.value.toLowerCase();

            assistants.each(function (i, item) {
                if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                    $(this).parent().css('display', 'table-row');

                } else {
                    $(this).parent().css('display', 'none');

                }

            });
        });


</script>
<script>

  //for search bar
  let userText = document.querySelector('#assistant-name')
  let rows = document.querySelectorAll('#idd')

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
<script>
    var nombrePage = $("#idd").length;

    showPage = function (pagination) {
    if (pagination < 2 || pagination >= nombrePage) return;

    $("#idd").hide().eq(pagination).show();
    $("#pagin li").removeClass("active").eq(pagination).addClass("active");
    };

    // Go to Left
    // $(".prev").click(function () {
    // showPage($("#pagin ul .active").index() - 1);
    // });

    // // Go to Right
    // $(".next").click(function () {
    // showPage($("#pagin .active").index() + 1);
    // });

    // $("#pagin ul a").click(function (e) {
    // e.preventDefault();
    // showPage($(this).parent().index());
    // });

    showPage(0);

</script>
{{-- @if (\Illuminate\Support\Facades\Cookie::get('is_first_time_user') == true) --}}
<script>
    var assistant_intro_shown = localStorage.getItem('assistant_intro_shown');

    if (!assistant_intro_shown) {

        const tour = new Shepherd.Tour({
            defaults: {
                classes: "shepherd-theme-arrows"
            }
        });

        tour.addStep("step", {
            text: "Welcome to Assistants Page, here you can add your assistants to manage your stores",
            buttons: [
                {
                    text: "Next",
                    action: tour.next
                }
            ]
        });

        // tour.addStep("step2", {
        //     text: "First thing you do is create a store",
        //     attachTo: { element: ".second", on: "right" },
        //     buttons: [
        //         {
        //             text: "Next",
        //             action: tour.next
        //         }
        //     ],
        //     beforeShowPromise: function() {
        //         document.body.className += ' sidebar-enable';
        //         document.getElementById('sidebar-menu').style.height = 'auto';
        //     },
        // });
        tour.start();
        localStorage.setItem('assistant_intro_shown', 1);
    }
</script>
{{-- @else --}}
@stop
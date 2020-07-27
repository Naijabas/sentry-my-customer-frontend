@extends('layout.base')
@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop
@section('content')
    <div class="container-fluid">
        <div class="content">
            <div class="container-fluid">
                @include('partials.alert.message')

                <div class="row page-title">
                    <div class="col-md-12">
                        <h4 class="card-header mb-1 mt-0 float-left h5">List of Registered Customers</h4>
                        @if(Cookie::get('user_role') != 'store_assistant')
                            <a href="#" class="btn btn-primary float-right" data-toggle="modal"
                               data-target="#CustomerModal">
                                New &nbsp;<i class="fa fa-plus my-float"></i>
                            </a>
                        @endif
                        <div class="btn-group float-right mr-2">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class='uil uil-file-alt mr-1'></i>Export
                                <i class="icon"><span data-feather="chevron-down"></span></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button id="ExportReporttoExcel" class="dropdown-item notify-item">
                                    <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                    <span>Excel</span>
                                </button>
                                <button id="ExportReporttoPdf" class="dropdown-item notify-item">
                                    <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                    <span>PDF</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @if ( isset($response) && count($response) > 0 )
                    <div class="card-body p-1 card">
                        <div class="table-responsive table-data" style="padding: 10px">
                            <table id="customerTable"
                                   class="table dt-responsive nowrap table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Tel</th>
                                    {{-- <th>Amount Due</th> --}}
                                    <th>Store Name</th>
                                    <th>Actions</th>
                                </tr>

                                <tbody>
                                @foreach($response as $i => $customer)
                                    <tr>
                                        <td>{{$i + 1}}</td>
                                        <td>{{ ucfirst($customer->name) }}</td>
                                        <td>{{ $customer->phone_number }}</td>
                                        <td>{{ $customer->store_name }}</td>

                                        <td>
                                            <div class="btn-group mt-2 mr-1">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(Cookie::get('user_role') == 'store_admin')
                                                        <a class="dropdown-item"
                                                           href="{{ route('customer.edit', $customer->store_id.'-'.$customer->_id) }}">
                                                            Edit Customer</a>
                                                    @endif
                                                    <a class="dropdown-item"
                                                       href="{{ route('customer.show', $customer->store_id.'-'.$customer->_id) }}">View
                                                        Profile</a>
                                                    {{-- <a class="dropdown-item"
                                                                        href="{{ route('transaction.index') }}">View
                                                    Transaction</a>
                                                    <a class="dropdown-item" href="{{ route('debtor.create') }}">Send
                                                        Reminder</a> --}}
                                                    @if(Cookie::get('user_role') == 'store_admin')
                                                        <a class="text-danger dropdown-item" href="#" data-toggle="modal"
                                                           data-target="#DeleteModal{{$customer->_id}}">Delete</a>

                                                    @endif
                                                </div>
                                                @if(Cookie::get('user_role') == 'store_admin')
                                                    <div id="DeleteModal{{$customer->_id}}"
                                                         class="modal fade bd-example-modal-sm"
                                                         tabindex="-2" role="dialog"
                                                         aria-labelledby="DeleteModal{{$customer->_id}}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="Title{{$customer->_id}}">
                                                                        Delete Customer </h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Do you want to delete {{$customer->name}}?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('customer.destroy', $customer->_id) }}"
                                                                          method="POST" id="form">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="submit"
                                                                                class="btn btn-primary btn-danger">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">No,
                                                                        I changed my mind
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="card-body p-1 card">
                        <h3 style="font-style: italic; text-align: center;">No registered customers</h3>
                    </div>
            @endif
            <!-- end card -->
            </div>
        </div>

    </div>
    @if(Cookie::get('user_role') != 'store_assistant')
        <div id="CustomerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="{{ route('customer.store') }}"
                              id="submitForm">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="inputphone" class="col-3 col-form-label">Phone Number</label>
                                <div class="col-9">
                                    <input type="tel" class="form-control" id="phone" placeholder="Phone Number"
                                           aria-describedby="helpPhone" name="" required pattern=".{6,16}"
                                           title="Phone number must be between 6 to 16 characters">
                                    <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                                    <small id="helpPhone" class="form-text text-muted">Enter your number without the
                                        starting 0,
                                        eg 813012345
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="inputPassword3" class="col-3 col-form-label">Customer Name</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="inputPassword3"
                                           placeholder="Customer name"
                                           name="name" required pattern=".{5,30}"
                                           title="Customer name must be at least 5 characters and not more than 30 characters">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="inputPassword3" class="col-3 col-form-label">Store Name</label>
                                <div class="col-9">
                                    <!-- <input type="text" class="form-control" id="inputPassword3" placeholder="Store name"
                                        name="store_name"> -->
                                    <select name="store_id" class="form-control" required>
                                        @if ( isset($stores) && count($stores) )
                                            <option disabled selected value="">-- Select store --</option>
                                            @foreach ($stores as $store)
                                                <option value="{{$store->_id}}">{{$store->store_name}}</option>
                                            @endforeach
                                        @else
                                            <option disabled selected value="">-- You have not registered a store yet
                                                --
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group row mb-3">
                                    <label for="inputPassword5" class="col-3 col-form-label">Re Password</label>
                                    <div class="col-9">
                                        <input type="password" class="form-control" id="inputPassword5" placeholder="Retype Password" name="repassword">
                                    </div>
                                </div> -->
                            <div class="form-group mb-0 justify-content-end row">
                                <div class="col-9">
                                    <button type="submit" class="btn btn-primary btn-block ">Create Customer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endif

    <div id="DebtModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Debtor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group row mb-3">
                            <label for="inputphone" class="col-3 col-form-label">Phone Number</label>
                            <div class="col-9">
                                <input type="tel" class="form-control" id="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="inputPassword3" class="col-3 col-form-label">Password</label>
                            <div class="col-9">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="inputPassword5" class="col-3 col-form-label">Re Password</label>
                            <div class="col-9">
                                <input type="password" class="form-control" id="inputPassword5"
                                       placeholder="Retype Password">
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-primary btn-block ">Create User</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="CreditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Creditor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group row mb-3">
                            <label for="inputphone" class="col-3 col-form-label">Phone Number</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="inputPassword3" class="col-3 col-form-label">Password</label>
                            <div class="col-9">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="inputPassword5" class="col-3 col-form-label">Re Password</label>
                            <div class="col-9">
                                <input type="password" class="form-control" id="inputPassword5"
                                       placeholder="Retype Password">
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-primary btn-block ">Create User</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection


@section("javascript")

    {{-- <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    <script src="/backend/assets/build/js/intlTelInput.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js"></script>
    <script>
        const export_filename = 'Mycustomers';
        $(document).ready(function () {
            $('#customerTable').DataTable({
                dom: 'frtipB',
                buttons: [
                    {
                        extend: 'excel',
                        className: 'd-none',
                        title: export_filename,
                    }, {
                        extend: 'pdf',
                        className: 'd-none',
                        title: export_filename,
                        extension: '.pdf'
                    }
                ]
            });
            $("#ExportReporttoExcel").on("click", function () {
                $('.buttons-excel').trigger('click');
            });
            $("#ExportReporttoPdf").on("click", function () {
                $('.buttons-pdf').trigger('click');
            });

            var input = document.querySelector("#phone");
            var test = window.intlTelInput(input, {
                // separateDialCode: true,
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
    {{-- @if ( Cookie::get('is_first_time_user') == true) --}}
    <script>
        var customer_intro_shown = localStorage.getItem('customer_intro_shown');

        if (!customer_intro_shown) {

            const tour = new Shepherd.Tour({
                defaults: {
                    classes: "shepherd-theme-arrows"
                }
            });

            tour.addStep("step", {
                text: "Welcome to Customer Page, here you can create your customers",
                buttons: [{
                    text: "Next",
                    action: tour.next
                }]
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
            localStorage.setItem('customer_intro_shown', 1);
        }
    </script>
    {{-- @endif --}}
@stop

@extends('layout.base')

@section("custom_css")
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="css/app.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="container-fluid">
    <div class="content">
        <div class="container-fluid">

            <div class="card" style="margin-top: 10px;">
                <div id="wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">
                                    <div>
                                        @if( \Session::has('success'))
                                        <div class="alert alert-success">
                                            {!! \Session::get('success') !!}
                                        </div>
                                        @endif
                                        @if( \Session::has('error'))
                                        <div class="alert alert-danger">
                                            {!! \Session::get('error') !!}
                                        </div>
                                        @endif
                                    </div>

                                    <a href="{{ route('complaint.create') }}" class="btn btn-primary float-right">
                                        Add Complaint &nbsp;<i class="fa fa-plus my-float"></i>
                                    </a>
                                    <h4 class="header-title mt-0 mb-1">Complaints Submitted</h4>
                                    <p class="sub-header">
                                        This is the list of all complaints submitted:
                                    </p>
                                    <table id="basic-datatable" class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th style="max-width: 120px;">Complaint ID</th>
                                                <th>Subject</th>
                                                <th>Status</th>
                                                <th style="min-width: 90px;">Date</th>
                                                @if ( \Cookie::get('user_role') == "super_admin")
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ( \Cookie::get('user_role') == "super_admin")
                                            @foreach($responses->data as $index => $response)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a href="{{ route('complaint.show', $response->_id) }}">{{ $response->_id}}
                                                </td>
                                                <td>{{ $response->subject}}</td>
                                                <td>
                                                    @if ( $response->status == 'New' )
                                                    <div class="badge badge-pill badge-secondary">New</div>
                                                    @elseif ( $response->status == 'Pending' )
                                                    <div class="badge badge-pill badge-primary">Pending</div>
                                                    @elseif ( $response->status == 'Resolved' )
                                                    <div class="badge badge-pill badge-success">Resolved</div>
                                                    @elseif ( $response->status == 'Closed' )
                                                    <div class="badge badge-pill badge-dark">Closed</div>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($response->date)->diffForHumans() }}</td>
                                                <td>
                                                    <form action="{{ route('complaint.destroy', $response->_id) }}"
                                                        method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            @foreach($responses->data->complaints as $index => $response)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a href="{{ route('complaint.show', $response->_id) }}">{{ $response->_id}}
                                                </td>
                                                <td>{{ $response->subject}}</td>
                                                <td>
                                                    @if ( $response->status == 'New' )
                                                    <div class="badge badge-pill badge-secondary">New</div>
                                                    @elseif ( $response->status == 'Pending' )
                                                    <div class="badge badge-pill badge-primary">Pending</div>
                                                    @elseif ( $response->status == 'Resolved' )
                                                    <div class="badge badge-pill badge-success">Resolved</div>
                                                    @elseif ( $response->status == 'Closed' )
                                                    <div class="badge badge-pill badge-dark">Closed</div>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($response->date)->diffForHumans() }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

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

<!-- datatable js -->
<script src="/backend/assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="/backend/assets/libs/datatables/responsive.bootstrap4.min.js"></script>

<script src="/backend/assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.html5.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.flash.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.print.min.js"></script>

<script src="/backend/assets/libs/datatables/dataTables.keyTable.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.select.min.js"></script>

<!-- Datatables init -->
<script src="/backend/assets/js/pages/datatables.init.js"></script>
{{-- @if (\Illuminate\Support\Facades\Cookie::get('is_first_time_user') == true) --}}
<script>
    var complaints_intro_shown = localStorage.getItem('complaints_intro_shown');

    if (!complaints_intro_shown) {

        const tour = new Shepherd.Tour({
            defaults: {
                classes: "shepherd-theme-arrows"
            }
        });

        tour.addStep("step", {
            text: "Welcome to Complaints Page, here you can make your complaints",
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
        localStorage.setItem('complaints_intro_shown', 1);
    }
</script>
{{-- @else --}}
@stop
@extends('layout.base')

@section('content')
    <div class="account-pages my-5">
        <div class="container-fluid">
            <div class="row-justify-content-center">
                <div class="row">
                    <div class="col">
                        <div class="card">

                            <div class="card-body p-0">
                                <div>
                                    @if( \Session::has('error'))
                                        <div class="alert alert-danger">
                                            {!! \Session::get('error') !!}
                                        </div>
                                    @endif
                                </div>
                                <br>
                                <div style="padding: 20px;">
                                    <a href="{{ route('complaint.index') }}" class="btn btn-primary float-right"> Back &nbsp;<i class="fa fa-plus my-float"></i> </a>
                                    <h4 class="header-title mt-0 mb-1">Complaint Overview</h4>
                                </div>
                                <div class="row py-1">
                                    <div class="col-xl-4 col-sm-6">
                                        <div class="media p-3">
                                            <i data-feather="grid" class="align-self-center icon-dual icon-sm mr-4"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-0">{{ $response->data->complaint->_id }}</h6>
                                                <span class="text-muted font-size-13">Complaint ID</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-6">
                                        <div class="media p-3">
                                            <i data-feather="check-square" class="align-self-center icon-dual icon-sm mr-4"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-0">
                                                    @if ( $response->data->complaint->status == 'New' )
                                                        <div class="badge badge-pill badge-secondary">New</div>
                                                    @elseif ( $response->data->complaint->status == 'Pending' )
                                                        <div class="badge badge-pill badge-primary">Pending</div>
                                                    @elseif ( $response->data->complaint->status == 'Resolved' )
                                                        <div class="badge badge-pill badge-success">Resolved</div>
                                                    @elseif ( $response->data->complaint->status == 'Closed' )
                                                        <div class="badge badge-pill badge-dark">Closed</div>
                                                    @endif
                                                </h6>
                                                <span class="text-muted">Status</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="media p-3">
                                            <i data-feather="user-check" class="align-self-center icon-dual icon-sm mr-4"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-0">{{ \Cookie::get('phone_number') }}</h6>
                                                <span class="text-muted">Phone Number</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="media p-3">
                                            <i data-feather="clock" class="align-self-center icon-dual icon-lg mr-4"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-0">
                                                    {{ \Carbon\Carbon::parse($response->data->complaint->date)->diffForHumans() }}
                                                </h6>
                                                <span class="text-muted">Date Created</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mt-0 header-title">Subject</h6>
                                <div class="text-muted mt-3">
                                    <p>{{ $response->data->complaint->subject }}</p>
                                    <h6 class="mt-0 header-title">Message</h6>
                                    <p>{{ $response->data->complaint->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body pt-2">
                                <div class="dropdown mt-2 float-right">
                                    <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                        <i class="uil uil-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if ( \Cookie::get('user_role') == "super_admin")
                                            <a href="{{ route('complaint.edit', $response->data->complaint->_id) }}" class="dropdown-item"><i class="uil uil-refresh mr-2"></i>Update Status</a>
                                            <div class="dropdown-divider"></div>
                                        @endif
                                        <a href="{{ route('complaint.index') }}" class="dropdown-item text-danger"><i class="uil uil-exit mr-2"></i>Exit</a>
                                    </div>
                                </div>
                                <h5 class="mb-4 header-title">Recent Conversation</h5>
                                <div class="chat-conversation">
                                    <ul class="conversation-list slimscroll" style="max-height: 328px;" id="chat_message_body">
                                        <div class="card-body p-5 card" id="loading_card">
                                            <h4 class="text-center">Loading ...</h4>
                                        </div>
                                    </ul>
                                    <form novalidate action="javascript:void(0);">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Enter your text" id="chat_msg_send" />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-danger btn-block" onclick="add_feedback()">Send</button>
                                            </div>
                                        </div>
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

@section('javascript')
    <script>
        $().ready(function () {
            get_feedback();
        });

        function get_feedback()
        {
            window.setTimeout(function () {
                $.ajax({
                    url: "{{ env('API_URL', 'https://dev.api.customerpay.me') }}/complaint/feedbacks/{{ $response->data->complaint->_id }}",
                    type: "GET",
                    headers: {
                        "x-access-token" : "{{ \Cookie::get('api_token') }}",
                    },
                    success: function (result) {

                        $('#loading_card').remove();
                        $('#no_feedback').remove();

                        if(result.data.feedbacks.length != 0){

                            var feedback_history_array = result.data.feedbacks;

                            var messages_gotten;

                            for (var i = 0; i < feedback_history_array.length; i++) {
                                if ( feedback_history_array[i].userRole != "super_admin" ){
                                    messages_gotten += `
                                        <li class="clearfix odd">
                                            {{-- <div class="chat-avatar">
                                                <img src="/backend/assets/images/users/default.png">
                                                <i>10:01</i>
                                            </div> --}}
                                            <div class="conversation-text">
                                                <div class="ctext-wrap">
                                                    <i>You</i>
                                                    <p>
                                                        `+ feedback_history_array[i].messages +`
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    `;
                                } else {
                                    messages_gotten += `
                                        <li class="clearfix">
                                            {{-- <div class="chat-avatar">
                                                <img src="/backend/assets/images/users/default.png">
                                                <i>10:01</i>
                                            </div> --}}
                                            <div class="conversation-text">
                                                <div class="ctext-wrap">
                                                    <i>Super Admin</i>
                                                    <p>
                                                        `+ feedback_history_array[i].messages +`
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    `;
                                }
                            }

                            $("#chat_message_body").html(messages_gotten);

                        } else {

                            $("#chat_message_body").html(`
                                <div class="card-body p-5 card" id="no_feedback">
                                    <h4 class="text-center">No feedbacks yet ...</h4>
                                </div>
                            `);
                        }
                        // Get Latest Messages
                        get_feedback();
                    },
                    error: function () {

                        // Retry getting latest messages
                        get_feedback();
                    }});
            }, 3000);
        }

        function add_feedback()
        {
            if( $('#chat_msg_send').val().trim() != "" ){
                var feedback_msg = $('#chat_msg_send').val().trim();
                $.ajax({
                    url: "{{ env('API_URL', 'https://dev.api.customerpay.me') }}/complaint/feedback/{{ $response->data->complaint->_id }}",
                    type: "post",
                    headers: {
                        "x-access-token" : "{{ \Cookie::get('api_token') }}",
                    },
                    data: {
                        messages: feedback_msg
                    },
                    success: function (result) {

                        $('#loading_card').remove();
                        $('#no_feedback').remove();
                        $('#chat_msg_send').val("");
                        $(".invalid-feedback").hide()
                    },
                    error: function () {

                        $(".invalid-feedback").show();
                        $(".invalid-feedback").html('Error sending message. Check Internet and retry.');
                    }
                });
            } else {

                $(".invalid-feedback").show();
                $(".invalid-feedback").html('Please enter your messsage');
            }
        }
    </script>
@endsection

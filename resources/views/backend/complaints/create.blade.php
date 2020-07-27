@extends('layout.base')

@section("custom_css")

@stop

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row page-title">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb" class="float-right mt-1"></nav>
                    @include('partials.alert.message')

                    <h4 class="mb-1 mt-0">Submit a Complaint</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-1">Complaint Submission</h4>
                            <p class="sub-header">
                                Please enter your details carefully and click send to submit your complaint
                            </p>

                            <form method="post" action="{{route('complaint.store')}}">
                                @csrf
                                <h5>Log your Complaint</h5>
                                <br/>
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Subject</label>
                                        <div class="col-lg-10">
                                            <input type="text" name="subject" class="form-control"
                                                   placeholder="Subject"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Message</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="message" rows="5"
                                                      placeholder="Please enter your complaint here">{{old('message')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <button class="btn btn-primary">Send</button>
                                    </div>

                                    <a href="{{ route('complaint.index') }}" class="btn btn-danger">Cancel</a>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section("javascript")
    <script type="text/javascript" src="/backend/assets/js/materialize.min.js"></script>
@stop

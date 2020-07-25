{{-- inherits base markup --}}
{{-- got my page working im so excited --}}
@extends('layout.base')
{{-- add in the basic styling : check the contents of these stylesheets later --}}
@section("custom_css")
<link rel="stylesheet" href="{{asset('backend/assets/css/singleCustomer.css')}}">
@stop


{{-- yield body content --}}

@section('content')

<div class="content">

    <div class="container-fluid">
        {{-- start of page title --}}
        <div class="row page-title">
            <div class="col-md-12">
                <h6 class="mb-1 mt-0 float-left">Customer Profile</h6>
                <a href="{{ route('customer.index') }}" class="btn btn-primary float-right">
                    Go Back
                </a>
                @if(Cookie::get('user_role') == 'store_admin')
                    <a href="{{ route('customer.edit', $customer->storeId.'-'.$customer->customer->_id ) }}"
                        class="mr-3 btn btn-success float-right">
                        Edit Customer
                    </a>
                @endif
            </div>
        </div>
        {{-- end of page title --}}
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    @if(Cookie::get('user_role') != 'store_assistant')
                                    {{-- Checks are for super admin because vvariable naming is different from admin --}}
                                    <h5 class="text-primary">
                                        <a href="{{ route('store.show', isset($customer->storeId) ? $customer->storeId : $customer->customer->store_ref_id) }}">
                                            {{ isset($customer->storeName) ? $customer->storeName : $customer->customer->store_name }}
                                        </a></h5>
                                    @else
                                    <h5 class="text-primary">{{ $customer->storeName }}</h5>
                                    @endif
                                    <p>Store Name</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="/backend/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pt-4">

                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="font-size-15">{{ $result->transactions }}</h5>
                                            <p class="text-muted mb-0">Transactions</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="font-size-15">$ {{ number_format($result->total_revenue,2) }}</h5>
                                            <p class="text-muted mb-0">Revenue</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="btn btn-primary waves-effect waves-light btn-sm">Delete
                                            Customer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-4">Personal Information</h6>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Full Name :</th>
                                        <td>{{ucfirst($customer->customer->name)}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Mobile :</a></th>
                                        <td> <a href="tel:+{{ $customer->customer->phone_number }}">{{ $customer->customer->phone_number }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end card -->

            </div>

            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Revenue</p>
                                        <h4 class="mb-0">$ {{ number_format($result->total_revenue,2) }}</h4>
                                    </div>

                                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Debt</p>
                                        <h4 class="mb-0">$ {{ number_format($result->total_debt,2) }}</h4>
                                    </div>

                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Receivables</p>
                                        <h4 class="mb-0">$ {{ number_format($result->total_receivables, 2) }}</h4>
                                    </div>

                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body pb-5">
                        <h6 class="card-title mb-4 float-left">Transactions</h6>
                        <div class="btn-group float-right">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class='uil uil-file-alt mr-1'></i>Export
                                <i class="icon"><span data-feather="chevron-down"></span></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item notify-item">
                                    <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                    <span>Excel</span>
                                </a>
                                <a href="#" class="dropdown-item notify-item">
                                    <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                    <span>PDF</span>
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div id="customer-chart" class="apex-charts mt-5" style="min-height: 365px;"></div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-4">Recent Transactions</h6>
                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#Ref ID</th>
                                        <th scope="col">Transaction Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"> </th>
                                    </tr>
                                </thead>
                            <tbody>
                                    @if(count($customer->customer->transactions) < 1)
                                    <tr>
                                        <td colspan="4" class="text-center"> No Recent Transactions</td>
                                    </tr>
                                    @else
                                        @foreach($customer->customer->transactions as $transaction)
                                        <tr>
                                        <th scope="row">{{ $transaction->_id }}</th>
                                            <td>{{ $transaction->type }}</td>
                                            <td>{{ number_format($transaction->amount,2) }}</td>
                                            <td>
                                                @if($transaction->status == false)
                                                <span class="badge badge-danger">Unpaid</span>
                                                @else
                                                <span class="badge badge-success">Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                            <a class="btn btn-info btn-small py-1 px-2"
                                                href="{{ route('transaction.show', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}">
                                                View More
                                            </a>
                                            </td>
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

@endsection
@section('javascript')
<script>
    var chartData = @json($chartData) ;
    var options = {
          series: [{
          name: 'amount',
          data: chartData,
        },],
          chart: {
          height: 350,
          type: 'area'
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
        },
        toolbar: {
        show: true,
        tools: {
          download: true,
          selection: true,
          zoom: true,
          zoomin: true,
          zoomout: true,
          pan: true,
        },
        },
        };

    var chart = new ApexCharts(document.querySelector("#customer-chart"), options);
    chart.render();
</script>
@endsection

@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="{{asset('backend/assets/css/store_list.css')}}">
<link href="/backend/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@stop


@php
$storeData = $response['storeData'];
$transactions = $response['transactions'];
@endphp

@section('content')

<!-- Start Content-->

<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <a href="{{ url()->previous() }}" class="btn btn-primary go-back">Go Back</a>
        </nav>
        <h4 class="mt-2">My Store</h4>
    </div>
</div>

@include('partials.alert.message')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            <h4 class="card-title">{{ucfirst($storeData->store_name) }} Revenue Overview</h4>
                                    
                                    <table id="datatable-buttons" class="table dt-responsive">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer Name </th>
                                            <th data-priority="1">Amount</th>
                                            <th data-priority="3">Transaction Type</th>
                                            <th data-priority="3">Created</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($response['storeData']->customers as $customers)
                                        
                                        @foreach ($customers->transactions as $index => $transaction)  
                                        @if ($transaction->type == "paid" || $transaction->type == "Paid")
                                        <tr>
                                            <td>{{$number++ }}</td>
                                            <th>{{$customers->name}}<span class="co-name"></span>
                                                <br> <span class="font-light">{{$customers->phone_number}}</span>
                                            </th>
                                            <td>{{$transaction->amount}}</td>
                                            <td>{{$transaction->type}}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->createdAt)->diffForhumans() }}</td>
                                        </tr> 
                                        @endif
                                        @endforeach
                                        @endforeach
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
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection

@section("javascript")
<script src="/backend/assets/build/js/intlTelInput.js"></script>
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
<script src="/backend/assets/js/pages/datatables.init.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.select.min.js"></script>
<script>
    $(document).ready(function () {
    // start of transaction charts
    var options = {
    series: [{
    name: 'Likes',
    data: [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7, 5]
    }],
    chart: {
    height: 350,
    type: 'line',
    },
    stroke: {
    width: 7,
    curve: 'smooth'
    },
    xaxis: {
    type: 'datetime',
    categories: ['1/11/2000', '2/11/2000', '3/11/2000', '4/11/2000', '5/11/2000', '6/11/2000', '7/11/2000', '8/11/2000',
    '9/11/2000', '10/11/2000', '11/11/2000', '12/11/2000', '1/11/2001', '2/11/2001', '3/11/2001','4/11/2001' ,'5/11/2001'
    ,'6/11/2001'],
    },
    title: {
    text: '',
    align: 'left',
    style: {
    fontSize: "16px",
    color: '#666'
    }
    },
    fill: {
    type: 'gradient',
    gradient: {
    shade: 'dark',
    gradientToColors: [ '#FDD835'],
    shadeIntensity: 1,
    type: 'horizontal',
    opacityFrom: 1,
    opacityTo: 1,
    stops: [0, 100, 100, 100]
    },
    },
    markers: {
    size: 4,
    colors: ["#FFA41B"],
    strokeColors: "#fff",
    strokeWidth: 2,
    hover: {
    size: 7,
    }
    },
    yaxis: {
    min: -10,
    max: 40,
    title: {
    text: 'Cash Flow',
    },
    }
    };
    
    var chart = new ApexCharts(document.querySelector("#transactionchart"), options);
    chart.render();
    
    
    });
    
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        // any initialisation options go here
    });
   
</script>
@stop
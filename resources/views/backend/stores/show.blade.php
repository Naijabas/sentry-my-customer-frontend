@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/backend/assets/css/transac.css') }}">
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

@php
$totalDept = 0;
$total_interest = 0;
$total_Revenue = 0;
$total_interestRevenue = 0;
$total_Receivables = 0;
$total_interestReceivables = 0;
@endphp

@foreach ($response['storeData']->customers as $transactions)

@foreach ($transactions->transactions as $index => $transaction)

@php
//get for all debts
if ($transaction->type == "debt") {
$eachDept = $transaction->amount;
$totalDept += $eachDept;
$each_interest = $transaction->interest;
$total_interest += $each_interest;
}

//get for all revenues
if ($transaction->type == "paid") {
$eachRevenue = $transaction->amount;
$total_Revenue += $eachRevenue;
$each_interestRevenue = $transaction->interest;
$total_interestRevenue += $each_interestRevenue;
}

//get for all Receivables
if ($transaction->type == "receivables") {
$eachReceivables = $transaction->amount;
$total_Receivables += $eachReceivables;
$each_interestReceivables = $transaction->interest;
$total_interestReceivables += $each_interestReceivables;
}

@endphp
@endforeach
@endforeach


@section('content')

<!-- Start Content-->
@include('partials.alert.message')
<div class="row page-title">

    

    <div class="col-md-12">
        @if(Cookie::get('user_role') == 'store_admin')
        <nav aria-label="breadcrumb" class="float-right mt-1">


            <a data-toggle="modal" data-target="#storeDelete" href="" class="btn btn-danger float-right">
                Delete
            </a>
            <a href="{{ route('store.edit', $storeData->_id) }}" class="mr-3 btn btn-primary float-right">
                Edit Store
            </a>
            @endif
            {{-- Modal for delete Store --}}
            <div class="modal fade" id="storeDelete" tabindex="-1" role="dialog" aria-labelledby="storeDeleteLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="storeDeleteLabel">Delete Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-horizontal" method="POST"
                            action="{{ route('store.destroy', $storeData->_id) }}">
                            <div class="modal-body">
                                @csrf
                                @method('DELETE')
                                <h6>Are you sure you want to delete this Store</h6>
                            </div>
                            <div class="modal-footer">
                                <div class="">
                                    <button type="submit" class="btn btn-primary mr-3" data-dismiss="modal"><i
                                            data-feather="x"></i>
                                        Close</button>
                                    <button type="submit" class="btn btn-danger"><i data-feather="trash-2"></i>
                                        Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <h4 class="mt-2">My Store</h4>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-4">
        <div class="card bg-soft-primary">
            <div>
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">{{ ucfirst($storeData->store_name) }}</h5>

                            <ul class="pl-3 mb-0">
                                <li class="py-1">Assistants: {{count( $storeData->assistants )}}</li>
                                <li class="py-1">Customers: {{count( $storeData->customers )}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="/backend/assets/images/profile-img.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">

        <div class="row">
            <div class="col-sm-4"><a href="{{ route('store_revenue', $storeData->_id) }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Revenue</p>
                                    <h4 class="mb-0">{{ format_money($total_Revenue) }}</h4>

                                </div>

                                <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="uil-atm-card font-size-14"></i>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex">
                                <span class="badge badge-soft-primary font-size-12"> {{ $total_interestRevenue }}%
                                </span> <span class="ml-2 text-truncate text-primary">From previous Month</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4"><a href="{{ route('store_receivable', $storeData->_id) }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Receivables</p>
                                      <h4 class="mb-0">{{ format_money($total_Receivables) }}</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="uil-atm-card font-size-14"></i>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex">
                                <span class="badge badge-soft-primary font-size-12">
                                    {{ $total_interestReceivables }}% </span> <span
                                    class="ml-2 text-truncate text-primary">From previous period</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4">
                <div class="card"><a href="{{ route('store_debt', $storeData->_id) }}">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Debt</p>
                                    <h4 class="mb-0">{{ format_money($totalDept) }}</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="uil-atm-card font-size-14"></i>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex">
                                <span class="badge badge-soft-primary font-size-12">{{ $total_interest }}%</span>
                                <span class="ml-2 text-truncate text-primary">From previous Month</span>
                            </div>
                        </div>
                </div>
            </div></a>
        </div>
    </div>
    <!-- end row -->
</div>
</div>

<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card">

            <div class="card-body pl-3 pr-3 padup">
                <div class="text-center">
                    <h6>Choose Business Card</h6>
                </div>
              

                <div class="row" id="gallery" data-toggle="modal" data-target="#exampleModal">
                    <div class="col-6 col-md-4 col-lg-12">
                      <img class="w-100" src="{{asset('backend/assets/images/card_v2.PNG')}}" data-target=”#carouselExamples” data-slide-to="0">
                    </div>
                    <div class="col-6 col-md-4 col-lg-12">
                      <img class="w-100" src="{{asset('backend/assets/images/card_vv1.PNG')}}" data-target=”#carouselExamples” data-slide-to="1">
                    </div>
                   
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-8">
    <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4 float-sm-left">Transaction Overview {{date('Y')}}</h6>
                <div class="clearfix"></div>
                <div id="transactionchart"></div>
            </div>
        </div>

    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="btn-group float-right">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class='uil uil-file-alt mr-1'></i>Export
                                        <i class="icon"><span data-feather="chevron-down"></span></i></button>
                                    <div class=" dropdown-menu dropdown-menu-right">
                                        <button id="downloadLink"
                                            onclick="exportTableToExcel('basic-datatables', '{{ ucfirst($storeData->store_name) }} Transaction Overview')"
                                            class=" dropdown-item notify-item">
                                            <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                            <span>EXCEL</span>
                                        </button>
                                        <button id="pdf" class="dropdown-item notify-item">
                                            <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                            <span>PDF</span>
                                        </button>
                                    </div>
                                </div>
                                <h4 class="card-title">{{ ucfirst($storeData->store_name) }} Transaction Overview</h4>
                                <br>
                                
                                    @foreach ($response['storeData']->customers as $transactions)
                                    @foreach ($transactions->transactions as $i => $transaction)
                                    @php
                                    $date = date("m-d-Y", strtotime(date($transaction->createdAt)));
                                    var_dump($date);
                                    
                                    
                                    @endphp
                                    @endforeach
                                    @endforeach
                                    

                                <table id="basic-datatables" class="table dt-responsive nowrap">
                                    
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer Name </th>
                                            <th>Phone Number </th>
                                            <th>Transaction Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response['storeData']->customers as $transactions)

                                        @foreach ($transactions->transactions as $index => $transaction)
                                        <tr>
                                            <td>{{ $number++ }}</td>
                                            <th>{{$transactions->name}}<span class="co-name">
                                            </th>
                                            <td class="font-light">{{$transactions->phone_number}}</td>
                                            <td>{{$transaction->type}}</td>
                                            <td>{{$transaction->amount}}</td>
                                            <td>
                                                <label class="switch">
                                                    @if(Cookie::get('user_role') != 'store_assistant') disabled
                                                    <input class="togBtn" type="checkbox" id="togBtn"
                                                        {{ $transaction->status == true ? 'checked' : '' }}
                                                        data-id="{{ $transaction->_id }}"
                                                        data-store="{{ $transaction->store_ref_id }}"
                                                        data-customer="{{ $transaction->customer_ref_id}}">
                                                    @else
                                                    <input type="checkbox" id="togBtn"
                                                        {{ $transaction->status == true ? 'checked' : '' }} disabled>
                                                    @endif
                                                    <div class="slider round">
                                                        <span class="on">Paid</span><span class="off">Pending</span>
                                                    </div>
                                                </label>
                                                <div id="statusSpiner"
                                                    class="spinner-border spinner-border-sm text-primary d-none"
                                                    role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </td>
                                            <td> <a href="{{ route('transaction.show', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}"
                                                    class="btn btn-primary waves-effect waves-light"> View
                                                    Transaction</a>
                                            </td>
                                        </tr>

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

<div class="modal fade " tabindex="-1" role="dialog" id="downloadModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Format</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('download', $storeData->_id)}}" method="post" id="download-form">
                    @csrf
                    <input type="hidden" name="version" class="version">
                    <input type="hidden" name="type">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="format" id="exampleRadios1" value="image"
                            checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Image Format
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="format" id="exampleRadios2" value="pdf">
                        <label class="form-check-label" for="exampleRadios2">
                            PDF Format
                        </label>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button id="download" class="btn btn-success mr-2">
                    <i class="far mr-2 fa-card">
                    </i>Download</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


  <div class="modal fade" id="exampleModal" tabindex="-1 role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Available Cards</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Carousel markup goes in the modal body -->
          
          <div id="carouselExamples" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active"  data-version="v2">
                <img class="d-block w-100" src="{{asset('backend/assets/images/card_v2.PNG')}}">
              </div>
              <div class="carousel-item"  data-version="v1">
                <img class="d-block w-100" src="{{asset('backend/assets/images/card_vv1.PNG')}}">
              </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExamples" role="button" data-slide="prev">
              <span  aria-hidden="true" class="text-dark"><i class="fa fa-chevron-left"></i></span>
              <span class="sr-only" class="text-dark">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExamples" role="button" data-slide="next">
              <span  aria-hidden="true" class="text-dark"><i class="fa fa-chevron-right"></i></span>
              <span class="sr-only" class="text-dark">Next</span>
            </a>
          </div>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> --}}
        
    </div>
    <div class="text-center padup">
        <form action="{{route('preview', $storeData->_id)}}" method="post" id="preview-form">
            @csrf
                <input type="hidden" name="version" class="version">
            </form>
            <button
            data-toggle="modal" 
            data-target="#downloadModal"
            id="first_download_button"
                    class="btn btn-success mr-2">
                    <i class="far mr-2 fa-card">
                </i>Download</button>
            <button
            
            id="preview"
            class="btn btn-primary mr-2">
            <i class="far mr-2 fa-card"></i>
            Preview</button>
  </div>
  </div>

@endsection

@section("javascript")
<script src="/backend/assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="/backend/assets/libs/datatables/responsive.bootstrap4.min.js"></script>

<script src="/backend/assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.flash.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.html5.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.print.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.keyTable.min.js"></script>
<script src="/backend/assets/js/pages/datatables.init.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.10/jspdf.plugin.autotable.min.js"></script>
<script src="/backend/assets/libs/datatables/tableHTMLExport.js"></script>

<script>
    $('#basic-datatables').dataTable({
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ]
    });
    $('#pdf').on('click', function () {
        $("#basic-datatables").tableHTMLExport({
            type: 'pdf',
            filename: '{{ ucfirst($storeData->store_name) }} Transaction Overview.pdf'
        });
    })

</script>

<script>
    jQuery(function ($) {
        const token = "{{Cookie::get('api_token')}}"
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

        $('.togBtn').change(function () {
            $(this).attr("disabled", true);
            $('#statusSpiner').removeClass('d-none');

            var id = $(this).data('id');
            var store = $(this).data('store');
            let _status = $(this).is(':checked') ? 1 : 0;
            let _customer_id = $(this).data('customer');

            $.ajax({
                url: `${host}/transaction/update/${id}`,
                headers: {
                    'x-access-token': token
                },
                data: {
                    store_id: store,
                    status: _status,
                    customer_id: _customer_id,
                },
                type: 'PATCH',
            }).done(response => {
                if (response.success != true) {
                    $(this).prop("checked", !this.checked);
                    $('#error').show();
                    alert("Oops! something went wrong.");
                }
                alert("Operation Successful.");
                $(this).removeAttr("disabled")
                $('#statusSpiner').addClass('d-none');
            }).fail(e => {
                $(this).removeAttr("disabled")
                $(this).prop("checked", !this.checked);
                $('#statusSpiner').addClass('d-none');
                alert("Oops! something went wrong.");
            });
        });

    });


    $("#first_download_button").click(function(){
        $("#exampleModal").modal('hide');
    })


    $('#preview').click(function(){
        let activeSlide = $(".carousel-item.active");

        let version = activeSlide.data('version');
        
        $(".version").val(version);
        $("#preview-form").submit();
        // console.log();
    })


    $('#download').click(function(){
        
        let activeSlide = $(".carousel-item.active");

        let version = activeSlide.data('version');
      
        $(".version").val(version);
        $("#download-form").submit();
        $("#downloadModal").modal('hide');
        // console.log();
    })

</script>

<script>
    function exportTableToExcel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }

</script>
<script>
    $(document).ready(function () {

// start of transaction charts

var options = {

    series: [{
        name: 'Transaction',
        data: {{json_encode($chart)}},
    }],
    chart: {
        height: 350,
        type: 'line',
    },
    stroke: {
        width: 7,
        curve: 'smooth'
    },xaxis: {
            type: 'text',
            categories: ['JAN', 'FEB', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUG',
                'SEPT', 'OCT', 'NOV', 'DEC'],
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
                gradientToColors: ['#FDD835'],
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

        title: {
            text: "{{ ucfirst($storeData->store_name) }}'s Amount",
        },
    }
};

var chart = new ApexCharts(document.querySelector("#transactionchart"), options);
chart.render();


});

</script>
@stop

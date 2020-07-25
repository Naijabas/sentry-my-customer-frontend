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

{{-- @if ($transaction->type == "debt")
    {{ $totalDept = 0 }}
    {{ $totalDept += $transaction->amount }}
    
@else
    {{ $totalDept = $transaction->amount}}                               

@endif --}}

@php
//get for all debts
    if ($transaction->type == "debt") {
        $eachDept = $transaction->amount;
        $totalDept += $eachDept;
        $each_interest = $transaction->interest;
        $total_interest += $each_interest;
    }

//get for all revenues
    if ($transaction->type == "Paid") {
        $eachRevenue = $transaction->amount;
        $total_Revenue += $eachRevenue;
        $each_interestRevenue = $transaction->interest;
        $total_interestRevenue += $each_interestRevenue;
    }

    //get for all receivables
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

<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <a href="javascript: void(0);" class="btn btn-warning waves-effect waves-light"> Edit Business Card</a>

            <a href="{{ route('store.edit', $storeData->_id) }}" class="btn btn-success mr-2"><i class="far mr-2 fa-edit"></i>Edit
                Store</a>
            

                <a data-toggle="modal" data-target="#storeDelete" href="" class="btn btn-danger">
                    Delete &nbsp;<i data-feather="delete"></i>
                </a>



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
                        <button type="submit" class="btn btn-primary mr-3" data-dismiss="modal"><i data-feather="x"></i>
                            Close</button>
                        <button type="submit" class="btn btn-danger"><i data-feather="trash-2"></i> Delete</button>
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

@if(session('data'))
<p class="alert alert-success">{{ session('data') }}</p>
@endif

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
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-xs mr-3">
                                <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-10">
                                    <i class="uil-atm-card"></i>
                                </span>
                            </div>
                            <h5 class="font-size-14 mb-0">Revenue</h5>
                        </div>
                        <div class="text-muted mt-4">
                            <h4> {{ $total_Revenue }} <i class="mdi mdi-chevron-up ml-1 text-success"></i></h4>
                            <div class="d-flex">
                                <span class="badge badge-soft-success font-size-12"> {{ $total_interestRevenue }}% </span> <span
                                    class="ml-2 text-truncate">From previous Month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-xs mr-3">
                                <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-10">
                                    <i class="uil-atm-card"></i>
                                </span>
                            </div>
                            <h5 class="font-size-14 mb-0">Receivables</h5>
                        </div>
                        <div class="text-muted mt-4">
                            <h4>{{ $total_Receivables }} <i class="mdi mdi-chevron-up ml-1 text-success"></i></h4>
                            <div class="d-flex">
                                <span class="badge badge-soft-success font-size-12"> {{ $total_interestReceivables }}% </span> <span
                                    class="ml-2 text-truncate">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card"><a href="{{ route('store_debt', $storeData->_id) }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-xs mr-3">
                                <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-10">
                                    <i class="uil-atm-card"></i>
                                </span>
                            </div>
                            <h5 class="font-size-14 mb-0 text-info">Debt</h5>
                        </div>
                        <div class="text-muted mt-4">
                            {{-- showing all depts --}}

                            <h4 class="text-info"> 
                                {{ $totalDept }}<i class="mdi mdi-chevron-up ml-1 text-success"></i></h4>

                                

                            <div class="d-flex">
                                <span class="badge badge-soft-warning font-size-12">{{ $total_interest }}%</span> <span
                                    class="ml-2 text-truncate text-info">From previous Month</span>
                            </div>
                        </div>
                    </div></a>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>

{{-- end --}}

<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body pl-3 pr-3 padup">
                <div class="text-center">

                    Business card should be here
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4 float-sm-left">Transaction Chart</h6>
                <div class="btn-group float-right">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class='uil uil-file-alt mr-1'></i>Export
                                        <i class="icon"><span data-feather="chevron-down"></span></i></button>
                                    <div class=" dropdown-menu dropdown-menu-right">
                                        <button id="downloadLink" onclick="exportTableToExcel('basic-datatables', '{{ ucfirst($storeData->store_name) }} Transaction Overview')" class=" dropdown-item notify-item">
                                            <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                            <span>EXCEL</span>
</button>
                                        <button id="pdf" class="dropdown-item notify-item">
                                            <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                                            <span>PDF</span>
</button>
                                    </div>
                                </div>
                                <h4 class="card-title">{{ ucfirst($storeData->store_name) }} Transaction Overview</h4><br>
                                

                                <table id="basic-datatables" class="table dt-responsive nowrap">
                                    @php
                                        
                                        $view = 2;
                                        
                                        $c =[];
                                        foreach ($response['storeData']->customers as $transactions)
                                    {   
                                        foreach ($transactions->transactions as $i => $transaction)
                                    {
                                        $date = date("m-d-Y", strtotime(date($transaction->createdAt)));
                                        $value = $transaction->amount;
                                    
                                            
                                        $key = $i;

                                        if ($view > 0)
                                        {
                                            $key = array_search($date, array_column($c, 'date'));
                                            if ($key !== false)
                                            {
                                                $value = $c[$key]['value'] + $value;
                                            }
                                            else
                                            {
                                                $key = count($c); // Create a new index here instead of $i
                                            }
                                        }
                                        else
                                        {
                                            $key = $i;
                                        }

                                        $c[$key]['name'] = 'Combined';
                                        $c[$key]['date'] = $date;
                                        $c[$key]['value'] = $value;
                                    }
                                }
                                    @endphp
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer Name </th>
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
                                            <th>{{$transactions->name}}<span class="co-name"></span>
                                                <br> <span class="font-light">{{$transactions->phone_number}}</span>
                                            </th>
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
                                                        <input type="checkbox" id="togBtn" {{ $transaction->status == true ? 'checked' : '' }} disabled>
                                                    @endif

                                                    <div class="slider round">
                                                        <span class="on">Paid</span><span class="off">Pending</span>
                                                    </div>
                                                </label>
                                                    <div id="statusSpiner" class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                </div>
                                            </td>
                                            <td> <a href="{{ route('transaction.show', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}" class="btn btn-primary waves-effect waves-light"> View Transaction</a>
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
<script type=text/javascript>
  var product = <?php echo json_encode( $c ) ?>;
</script>
<script>
    $('#basic-datatables').dataTable( {
  "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
} );
</script>
<script>
   $('#pdf').on('click',function(){
    $("#basic-datatables").tableHTMLExport({type:'pdf',filename:'{{ ucfirst($storeData->store_name) }} Transaction Overview.pdf'});
  })
</script>
  <script>
     function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
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
    jQuery(function ($) {
        const token = "{{Cookie::get('api_token')}}"
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

        $('.togBtn').change(function () {
            $(this).attr("disabled", true);
            $('#statusSpiner').removeClass('d-none');

            const id = $(this).data('id');
            const store = $(this).data('store');
            let _status = $(this).is(':checked') ? 1 : 0;
            let _customer_id = $(this).data('customer');

           $.ajax({
            url: `${host}/transaction/update/${id}`,
             headers: {'x-access-token': token},
             data: {
                 store_id:store,
                 status:_status,
                 customer_id:_customer_id,
                 },
             type: 'PATCH',
            }).done(response => {
                if (response.success != true) {
                    $(this).prop("checked", !this.checked);
                }
                $(this).removeAttr("disabled")
                $('#statusSpiner').addClass('d-none');
            }).fail( e => {
                $(this).removeAttr("disabled")
                $(this).prop("checked", !this.checked);
                $('#statusSpiner').addClass('d-none');
            });
        });
    });

</script>
<script>
    $(document).ready(function() {
        // start of transaction charts
        var options = {
            
            series: [{
                name: 'Amount',
                data: [<?php foreach($c as $key){                                            
                            $aaa = (string)$key['value'].",";                                            
                                echo $aaa;}?>]
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
                
                categories: [<?php foreach($c as $key){                                            
                            $aaa = "'".$key['date']."'".",";
                                echo $aaa;}?>],
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

    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        // any initialisation options go here
    });
</script>
@stop
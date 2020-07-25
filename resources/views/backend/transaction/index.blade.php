@extends('layout.base')
@section("custom_css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('/backend/assets/css/store_list.css') }}">
<link rel="stylesheet" href="{{ asset('/backend/assets/css/transac.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="mb-0 d-flex justify-content-between align-items-center page-title">
            <div class="h6"><i data-feather="file-text" class="icon-dual"></i> Transaction Center</div>
            @if(Cookie::get('user_role') != 'store_assistant')
            <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#addTransactionModal">
                New &nbsp;<i class="fa fa-plus my-float"></i>
            </a>
            @endif
        </div>
        @include('partials.alertMessage')
        <div class="card mt-0">
            <div class="card-header">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
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
            <div class="card-body">
                <div class="table-responsive table-data">
                    <table id="transactionTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Store</th>
                                <th>Amount</th>
                                <th>Interest</th>
                                <th>Type</th>
                                <th>Due</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $index => $transaction )
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if(Cookie::get('user_role') != 'store_assistant')
                                        {{-- check for supper admin, response does not return store name --}}
                                    @isset($transaction->store_name)
                                        <a class="" href="{{ route('store.show', $transaction->store_ref_id) }}">
                                            {{ $transaction->store_name }}
                                        </a>
                                    @endif
                                    @else
                                        {{ $transaction->store_name }}
                                    @endif

                                </td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->interest }} %</td>
                                <td>{{ $transaction->type }}</td>

                                <td>
                                @isset($transaction->expected_pay_date)
                                    @if ( \Carbon\Carbon::parse($transaction->expected_pay_date)->isPast())
                                        <span
                                            class="badge badge-soft-danger">{{ \Carbon\Carbon::parse($transaction->expected_pay_date)->diffForhumans() }}</span>
                                    @else
                                        @if (\Carbon\Carbon::parse($transaction->expected_pay_date)->isToday())
                                            <span
                                                class="badge badge-soft-warning">{{ \Carbon\Carbon::parse($transaction->expected_pay_date)->diffForhumans() }}</span>
                                        @endif
                                        <span
                                            class="badge badge-soft-success">{{ \Carbon\Carbon::parse($transaction->expected_pay_date)->diffForhumans() }}</span>
                                    @endif
                                @endif
                                </td>
                                <td> {{ \Carbon\Carbon::parse($transaction->createdAt)->diffForhumans() }}</td>
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
                                <td>
                                    <a class="btn btn-info btn-small py-1 px-2"
                                        href="{{ route('transaction.show', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}">
                                        View More
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addTransactionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Add New Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- {{dd($stores)}} --}}

            <div class="modal-body">
                <form class="form-horizontal" id="addTransaction" method="POST"
                    action="{{ route('transaction.store') }}">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="store" class="col-3 col-form-label">Store</label>
                        <div class="col-9">
                            <select class="form-control" name="store" id="store" required>
                                <option value="" selected disabled>None selected</option>
                                @isset($stores)
                                @if(Cookie::get('user_role') != 'super_admin')
                                    @foreach ($stores as $store)
                                    <option value="{{ $store->_id }}">{{ $store->store_name }}</option>
                                    @endforeach
                                @else
                                    @foreach ($stores as $userStores)
                                        @foreach($userStores as $store)
                                        <option value="{{ $store->_id }}">{{ $store->store_name }}</option>
                                        @endforeach
                                    @endforeach
                                @endif
                                @endisset
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="amount" class="col-3 col-form-label">Amount</label>
                        <div class="col-9">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="0000"
                                required min="0">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="interest" class="col-3 col-form-label">Interest</label>
                        <div class="col-9">
                            <input type="number" class="form-control" id="interest" name="interest" placeholder="0%">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="description" class="col-3 col-form-label">Description</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="pay_date" class="col-3 col-form-label">Expected Pay Date</label>
                        <div class="col-9">
                            <input type="date" class="form-control" id="expected_pay_date" name="expected_pay_date"
                                min="2019-02-06">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="customer" class="col-3 col-form-label">Customer</label>
                        <div class="col-9">
                            <select class="form-control" name="customer" id="customer" required>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="transaction_type" class="col-3 col-form-label">Transaction Type</label>
                        <div class="col-9">
                            <select id="type" name="type" class="form-control">
                                <option value="debt">Debt</option>
                                <option value="paid">Paid</option>
                                <option value="receivables">Receivables</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0 justify-content-end row">
                        <div class="col-9">
                            <button type="submit" class="btn btn-primary btn-block ">Create Transaction</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

@endsection

@section("javascript")

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/assets/build/js/intlTelInput.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js"></script>

<script>
    $(document).ready(function () {
        var export_filename = 'MycustomerTransactions';
        $('#transactionTable').DataTable({
            dom: 'frtipB',
            buttons:[
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
        } );
        $("#ExportReporttoExcel").on("click", function() {
            $( '.buttons-excel' ).trigger('click');
        });
        $("#ExportReporttoPdf").on("click", function() {
            $( '.buttons-pdf' ).trigger('click');
        });
    });
</script>

<script>
    jQuery(function ($) {
        const token = "{{Cookie::get('api_token')}}"
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

        $('select[name="store"]').on('change', function () {
            var storeID = $(this).val();
            var host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

            if (storeID) {
                $('select[name="customer"]').empty();
                jQuery.ajax({
                    url: host + "/store/" + encodeURI(storeID),
                    type: "GET",
                    dataType: "json",
                    contentType: 'json',
                    headers: {
                        'x-access-token': token
                    },
                    success: function (data) {
                        var new_data = data.data.store.customers;
                        var i;
                        new_data.forEach(customer => {
                            $('select[name="customer"]').append('<option value="' + customer._id + '">' +
                                customer.name + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="store"]').empty();
            }
        });

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
@stop

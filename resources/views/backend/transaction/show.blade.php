@extends('layout.base')
@section("custom_css")
<link rel="stylesheet" href="{{ asset('/backend/assets/css/transac.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@stop
@section('content')

<div class="account-pages my-2">
    <div class="container-fluid">
        <div class="row-justify-content-center">
            @include('partials.alertMessage')
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between px-4 py-2 border-bottom align-items-center">
                                <div>
                                    <h6 class="card-title">Transaction Overview - Created
                                        {{ \Carbon\Carbon::parse($transaction->createdAt)->diffForhumans() }}</h6>
                                </div>
                                <div>
                                    <a href="" data-toggle="modal" data-target="#sendReminderModal"
                                        class="btn btn-warning mr-3"> Send Debt Reminder </i>
                                    </a>
                                    @if(Cookie::get('user_role') == 'store_admin')
                                    <a href="#" class="btn btn-primary mr-3" data-toggle="modal"
                                        data-target="#editTransactionModal"> Edit &nbsp;<i data-feather="edit-3"></i>
                                    </a>

                                    <a data-toggle="modal" data-target="#deleteModal" href="" class="btn btn-danger">
                                        Delete &nbsp;<i data-feather="delete"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 1 -->
                                    <div class="media">
                                        <i data-feather="grid" class="align-self-center icon-dual icon-sm mr-2"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-0">{{ $transaction->_id }}</h6>
                                            <span class="text-muted font-size-13">Transaction Reference code</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 2 -->
                                    <div class="media">
                                        <i data-feather="check-square"
                                            class="align-self-center icon-dual icon-sm mr-2"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-0 text-capitalize">{{ $transaction->type }}</h6>
                                            <span class="text-muted">Transaction Type</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 3 -->
                                    <div class="media">
                                        <i data-feather="users" class="align-self-center icon-dual icon-sm mr-2"></i>
                                        <div class="media-body">
                                            @foreach ($stores as $store)
                                            @foreach ($store->customers as $customer)
                                            @if ($customer->_id === $transaction->customer_ref_id)
                                            <h6 class="m-0">
                                                <a
                                                    href="{{ route('customer.show', $transaction->store_ref_id.'-'.$transaction->customer_ref_id)}}">{{ $customer->name }}
                                                </a>
                                            </h6>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            <span class="text-muted">Customer Name</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 3 -->
                                    <div class="media">
                                        <i data-feather="clock" class="align-self-center icon-dual icon-lg mr-2"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-0">
                                                @foreach ($stores as $store)
                                                @foreach ($store->customers as $customer)
                                                @if ($customer->_id === $transaction->customer_ref_id)
                                                <h6 class="m-0">
                                                    <a href="tel:+{{ $customer->phone_number }}">{{ $customer->phone_number }}
                                                    </a>
                                                </h6>
                                                @endif
                                                @endforeach
                                                @endforeach
                                            </h6>
                                            <span class="text-muted">Customer Phone Number</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end --}}

            <div class="col-xl-12 col-md-12 col-sm-12 pt-2">
                <div class="row">
                    <div class="col p-0">
                        <div class="card">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="mt-0 ">Description</h6>
                                        <textarea name="" readonly id="" cols="auto" rows="3" sty
                                            class="form-control w-100 flex-1">{{ $transaction->description }}</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-between">
                                            <div class="list-group">
                                                <h6 class="">Financial Details</h6>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Amount</th>
                                                                <td colspan="2">{{ $transaction->amount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Interest</th>
                                                                <td colspan="2">{{ $transaction->interest }} % / Yr</td>
                                                            </tr>
                                                            <tr class="font-weight-bolder">
                                                                <th scope="row">Total Amount</th>
                                                                <td colspan="2">
                                                                    {{ (($transaction->interest / 100) * $transaction->amount) + $transaction->amount }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="">
                                                <h6 class="">Store Name:</h6>
                                                <p>
                                                    @if(Cookie::get('user_role') != 'store_assistant')
                                                    <a href="{{ route('store.show', $transaction->store_ref_id)}}"
                                                        class="mr-2 text-uppercase">
                                                        {{ $transaction->store_name }}
                                                    </a>
                                                    @else
                                                    {{ $transaction->store_name }}
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="">
                                                <h6 class="">Transaction Status:
                                                </h6>
                                                <label class="switch">
                                                    @if(Cookie::get('user_role') != 'store_assistant') disabled
                                                    <input type="checkbox" id="togBtn"
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
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end --}}

            <div class="card mt-0">
                <div class="card-header">
                    <div class="">History: Debt Reminder Messages</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-data">
                        <table id="transactionTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Reference id</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date Sent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->debts as $index => $Debts)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $Debts->message }}
                                    </td>
                                    <td><span class="badge badge-success">{{ $Debts->status }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($Debts->createdAt)->diffForhumans() }}</td>
                                    <td><a href="" data-toggle="modal"
                                            onclick="return previousMessage('{{ $Debts->message }}')"
                                            data-target="#ResendReminderModal" class="btn btn-primary btn-sm mt-2">
                                            Resend
                                        </a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- start of edit transaction modal --}}
            <div id="editTransactionModal" class="modal fade" tabindex="-1" role="dialog"
                aria-labelledby="editTransactionLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTransactionLabel">Update Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="editTransaction" method="POST"
                                action="{{ route('transaction.update', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group row mb-3">
                                    <label for="amount" class="col-3 col-form-label">Amount</label>
                                    <div class="col-9">
                                        <input type="number" class="form-control" id="amount" name="amount"
                                            placeholder="0000.00" value="{{$transaction->amount}}" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="interest" class="col-3 col-form-label">Interest</label>
                                    <div class="col-9">
                                        <input type="number" class="form-control" id="interest"
                                            value="{{ old('interest', $transaction->interest) }}" name="interest"
                                            placeholder="0%">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="description" class="col-3 col-form-label">Description</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="description"
                                            value="{{ old('description', $transaction->description) }}"
                                            name="description" placeholder="Description">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="transaction_type" class="col-3 col-form-label">Transaction Type</label>
                                    <div class="col-9">
                                        <select class="form-control" id="type" name="type">
                                            <option value="paid"
                                                {{ old('type', $transaction->type) == 'paid' ? 'selected' : '' }}>
                                                Paid</option>
                                            <option value="debt"
                                                {{ old('type', $transaction->type) == 'debt' ? 'selected' : '' }}>
                                                Debt</option>
                                            <option value="receivable"
                                                {{ old('type', $transaction->type) == 'receivable' ? 'selected' : '' }}>
                                                Receivable
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="description" class="col-3 col-form-label">Due Date</label>
                                    <div class="col-9">
                                        <input type="date" class="form-control" id="expected_pay_date"
                                            name="expected_pay_date"
                                            value="{{ old('expected_pay_date', \Carbon\Carbon::parse($transaction->expected_pay_date)->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="store" class="col-3 col-form-label">Store</label>
                                    <div class="col-9">
                                        <select name="store" class="form-control">
                                            @foreach($stores as $store)
                                            @if ($store->storeId === $transaction->store_ref_id)
                                            <option class="text-uppercase form-control" value="{{ $store->storeId }}">
                                                {{ $store->storeName }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="customer" class="col-3 col-form-label">Customer</label>
                                    <div class="col-9">
                                        <select name="customer" class="form-control">
                                            @foreach($stores as $store)
                                            @foreach ($store->customers as $customer)
                                            @if ($customer->_id === $transaction->customer_ref_id)
                                            <option class="text-uppercase form-control" value="{{ $customer->_id }}">
                                                {{ $customer->name }}</option>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label"> Status </label>
                                    <div class="col-9">

                                        <select class="form-control" name="status">
                                            <option value="0"
                                                {{ old('type', $transaction->status) == '0' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="1"
                                                {{ old('type', $transaction->status) == '1' ? 'selected' : '' }}>Paid
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-0 justify-content-end row">
                                    <div class="col-9">
                                        <button type="submit" class="btn btn-primary btn-block ">
                                            Update Transaction
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal for Resend reminder --}}
<div class="modal fade" id="ResendReminderModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form
                    action="{{ route('reminder', $transaction->store_ref_id.'-'.$transaction->customer_ref_id.'-'.$transaction->_id) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{old('transaction_id', $transaction->_id)}}">

                    <div class="form-group">
                        <label>Message</label>

                        <textarea name="message" id="R_debtMessage"
                            class="form-control @error('message') is-invalid @enderror" placeholder="Message"
                            maxlength="140"></textarea>
                        @error('message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Resend Reminder</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal for send reminder --}}
<div class="modal fade" id="sendReminderModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form
                    action="{{ route('reminder', $transaction->store_ref_id.'-'.$transaction->customer_ref_id.'-'.$transaction->_id) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{old('transaction_id', $transaction->_id)}}">

                    <div class="form-group">
                        <label>Message</label>
                        <p>
                            <span>characters remaining: <span id="rem_reminderMessage" title="140"></span></span>
                        </p>
                        <textarea name="message" class="countit form-control" id="reminderMessage" placeholder="Message" maxlength="140" row="10">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Send Reminder</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal for delete transaction --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="POST"
                action="{{route('transaction.destroy', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id)}}">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <h6>Are you sure you want to delete this transaction</h6>
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

@endsection

@section('javascript')
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js">
</script>
<script>
    $(function () {
        const api = "{{ Cookie::get('api_token') }}";
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

        $('#togBtn').change(function () {
            $(this).attr("disabled", true);
            $('#statusSpiner').removeClass('d-none');

            const id = $(this).data('id');
            const store = $(this).data('store');
            let _status = $(this).is(':checked') ? 1 : 0;
            let _customer_id = $(this).data('customer');

            $.ajax({
                url: `${host}/transaction/update/${id}`,
                headers: {
                    'x-access-token': api
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
                }
                $(this).removeAttr("disabled")
                $('#statusSpiner').addClass('d-none');
            }).fail(e => {
                $(this).removeAttr("disabled")
                $(this).prop("checked", !this.checked);
                $('#statusSpiner').addClass('d-none');
            });
        });
    });


    //Character count in dept reminder modal
    $(".countit").keyup(function () {
        var cmax = $("#rem_" + $(this).attr("id")).attr("title");

        if ($(this).val().length >= cmax) {
            $(this).val($(this).val().substr(0, cmax));
        }

        $("#rem_" + $(this).attr("id")).text(cmax - $(this).val().length);

    });

    // copy resend debt message

    function previousMessage(message) {
        $('#R_debtMessage').val(message);
    }

    // pagination for debts
    $(() => {
        $('#transactionTable').DataTable({});
    });

</script>
@endsection

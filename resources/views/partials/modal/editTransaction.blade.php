<div id="editTransactionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editTransactionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTransactionLabel">Update Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="editTransaction" method="POST" action="{{ route('transaction.update', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row mb-3">
                        <label for="amount" class="col-3 col-form-label">Amount</label>
                        <div class="col-9">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="0000.00" value="{{ old('amount', $transaction->amount )}}" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="interest" class="col-3 col-form-label">Interest</label>
                        <div class="col-9">
                            <input type="number" class="form-control" id="interest" value="{{ old('interest', $transaction->interest) }}" name="interest" placeholder="0%">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="description" class="col-3 col-form-label">Description</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="description" value="{{ old('description', $transaction->description) }}" name="description" placeholder="Description">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="transaction_type" class="col-3 col-form-label">Transaction Type</label>
                        <div class="col-9">
                            <select class="form-control" id="type" name="type">
                                <option value="paid" {{ old('type', $transaction->type) == 'paid' ? 'selected' : '' }}>
                                    Paid</option>
                                <option value="debt" {{ old('type', $transaction->type) == 'debt' ? 'selected' : '' }}>
                                    Debt</option>
                                <option value="receivable" {{ old('type', $transaction->type) == 'receivable' ? 'selected' : '' }}>
                                    Receivable
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="description" class="col-3 col-form-label">Due Date</label>
                        <div class="col-9">
                            <input type="date" class="form-control" id="expected_pay_date" name="expected_pay_date" value="{{ old('expected_pay_date', \Carbon\Carbon::parse($transaction->expected_pay_date)->format('Y-m-d')) }}">
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
                                <option value="0" {{ old('type', $transaction->status) == '0' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="1" {{ old('type', $transaction->status) == '1' ? 'selected' : '' }}>Paid
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

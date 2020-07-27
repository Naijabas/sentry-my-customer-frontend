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

            <div class="modal-body">
                <form class="form-horizontal" id="addTransaction" method="POST"
                    action="{{ route('transaction.store') }}">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="store" class="col-md-3 col-form-label">Store</label>
                        <div class="col-md-9">
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
                        <label for="amount" class="col-md-3 col-form-label">Amount</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="0000"
                                required min="0" value="{{ old('amount') }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="interest" class="col-md-3 col-form-label">Interest</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="interest" name="interest" placeholder="0%" value="{{ old('interest') }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="description" class="col-md-3 col-form-label">Description</label>
                        <div class="col-md-9">
                            <textarea name="description" class="counter form-control" id="description" placeholder="description..." maxlength="140">{{ old('description') }}</textarea>
                            <p class="charNum m-0 p-0 h6 text-capitalize"></p>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="pay_date" class="col-md-3 col-form-label">Expected Pay Date</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" id="expected_pay_date" name="expected_pay_date"
                                min="2019-02-06" value="{{ old('expected_pay_date') }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="customer" class="col-md-3 col-form-label">Customer</label>
                        <div class="col-md-9">
                            <select class="form-control" name="customer" id="customer" required>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="transaction_type" class="col-md-3 col-form-label">Transaction Type</label>
                        <div class="col-md-9">
                            <select id="type" name="type" class="form-control">
                                <option value="debt" {{ old('type') == 'debt' ? 'selected' : ' ' }}>Debt</option>
                                <option value="paid" {{ old('type') == 'paid' ? 'selected' : ' ' }}>Paid</option>
                                <option value="receivables" {{ old('type') == 'receivables' ? 'selected' : ' ' }}>Receivables</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0 justify-content-end row">
                        <div class="col-md-9">
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

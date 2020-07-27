<div class="modal fade" id="sendReminderModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                @isset($transaction)
                <form action="{{ route('reminder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{old('transaction_id', $transaction->_id)}}">
                    <input type="hidden" name="customer_id" value="{{old('customer_id', $transaction->customer_ref_id)}}">
                    <input type="hidden" name="store_id" value="{{old('store_id', $transaction->store_ref_id)}}">
                    @else
                    <form
                        action="{{ route('reminder') }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{old('transaction_id', $debtor->_id)}}">
                        <input type="hidden" name="customer_id" value="{{old('customer_id', $debtor->customer_ref_id)}}">
                        <input type="hidden" name="store_id" value="{{old('store_id', $debtor->store_ref_id)}}">
                        @endisset

                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="counter form-control" id="reminderMessage"
                                placeholder="Message" maxlength="140">{{ old('message') }}</textarea>
                            <p class="charNum m-0 p-0"></p>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Send Reminder</button>
                    </form>
            </div>
        </div>
    </div>
</div>

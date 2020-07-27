<div class="modal fade" id="ResendReminderModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form
                    action="{{ route('reminder') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{old('transaction_id', $transaction->_id)}}">
                    <input type="hidden" name="store_id" value="{{old('transaction_id', $transaction->store_ref_id)}}">
                    <input type="hidden" name="customer_id" value="{{old('transaction_id', $transaction->customer_ref_id)}}">

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

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

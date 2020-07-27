<div id="deleteModal-{{$assistant->_id}}" class="modal fade bd-example-modal-sm" tabindex="-2" role="dialog"
    aria-labelledby="deleteModal-{{$assistant->_id}}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModal-{{$assistant->_id}}">
                    Delete Assistant </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to delete {{$assistant->name}}?
            </div>
            <div class="modal-footer">
                <form action="{{ route('assistants.destroy', $assistant->_id) }}" method="POST" id="form">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary btn-danger">
                        Delete
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No,
                    I changed my mind
                </button>
            </div>
        </div>
    </div>
</div>

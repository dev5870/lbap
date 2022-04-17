<div class="modal fade deleteModal" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Modal
                <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="text-center m-3 modal-body">
                <p class="mb-0">{{ __('title.headers.sure') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">{{ __('title.btn.close') }}</button>
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('title.btn.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

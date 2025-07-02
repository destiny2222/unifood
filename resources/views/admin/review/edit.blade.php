<!-- top modal -->
<div id="topModal-{{ $review->id  }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="topModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.review.update', $review->id ) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name" class="form-label">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="0" {{ $review->status == 0 ? 'selected' : '' }} >InActive</option>
                            <option value="1" {{ $review->status == 1 ? 'selected' : ''}}>Active</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Update" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div> <!-- end modal content -->
    </div> <!-- end modal dialog -->
</div> <!-- end modal -->
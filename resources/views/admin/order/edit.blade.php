<!-- top modal -->
<div id="topModal-{{ $orderItem->id  }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="topModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.order.update', $orderItem->id ) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name" class="form-label">Payment Status</label>
                        <select name="payment_status" id="" class="form-control">
                            <option value="0" {{ $orderItem->payment_status == 0 ? 'selected' : '' }} >Pending</option>
                            <option value="1" {{ $orderItem->payment_status == 1 ? 'selected' : ''}}>Success</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Order Status</label>
                        <select name="order_status" id="" class="form-control">
                            <option value="0" {{ $orderItem->order_status == 0 ? 'selected' : ''}}>Pending</option>
                            <option value="1" {{ $orderItem->order_status == 1 ? 'selected' : ''}}>In Progress</option>
                            <option value="2" {{ $orderItem->order_status == 2 ? 'selected' : ''}}>Delivered</option>
                            <option value="3" {{ $orderItem->order_status == 3 ? 'selected' : ''}}>Completed</option>
                            <option value="4" {{ $orderItem->order_status == 4 ? 'selected' : ''}}>Declined</option>
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
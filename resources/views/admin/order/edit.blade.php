<!-- top modal -->
<div id="topModal-{{ $orderItem->order->id  }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="topModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.order.update', $orderItem->order->id ) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name" class="form-label">Payment Status</label>
                        <select name="payment_status" id="" class="form-control">
                            <option value="paid" {{ $orderItem->order->payment_status == 'paid' ? 'selected' : '' }} >Paid</option>
                            <option value="unpaid" {{ $orderItem->order->payment_status == 'unpaid' ? 'selected' : ''}}>Unpaid</option>
                            <option value="pending" {{ $orderItem->order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Order Status</label>
                        <select name="order_status" id="" class="form-control">
                            <option value="pending" {{ $orderItem->order->order_status == 'pending' ? 'selected' : ''}}>Pending</option>
                            <option value="processing" {{ $orderItem->order->order_status == 'processing' ? 'selected' : ''}}>In Progress</option>
                            <option value="delivered" {{ $orderItem->order->order_status == 'delivered' ? 'selected' : ''}}>Delivered</option>
                            <option value="cancelled" {{ $orderItem->order->order_status == 'cancelled' ? 'selected' : ''}}>Canceled</option>
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
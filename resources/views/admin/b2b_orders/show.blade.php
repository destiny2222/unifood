@extends('layouts.master')
@section('content')
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row mb-4">
                    <div class="col-6">
                        <a href="{{ route('admin.b2b-orders.index') }}" class="btn btn-primary">Return Back</a>
                        <a href="#!" id="printBtn" class="btn btn-info ps-3 pe-3">
                            <i class='bx bx-printer'></i> Print
                        </a>
                    </div>
                </div>
                <div id="printSection">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-5">
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">#{{ $order->internal_reference }}</h4>
                                            @if($order->po_number)
                                                <p class="mb-0">PO Number: <span class="fw-semibold text-dark">{{ $order->po_number }}</span></p>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">Payment Information:</h4>
                                            <p class="mb-0">Payment Method: {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                                            <p class="mb-0">Status: <span class="badge bg-primary-subtle text-primary px-2 py-1 fs-13">{{ $order->status }}</span></p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">Delivery Information:</h4>
                                            @if($order->shippingAddress)
                                                <p class="mb-1">Contact: {{ $order->shippingAddress->contact_name ?? $order->user->name }}</p>
                                                <p class="mb-1">Company: {{ $order->shippingAddress->company_name ?? ($order->user->kyc->company_name ?? '') }}</p>
                                                <p class="mb-1">Phone: {{ $order->shippingAddress->phone ?? $order->user->phone }}</p>
                                                <p class="mb-1">Address: {{ $order->shippingAddress->address_line_1 }}</p>
                                                @if($order->shippingAddress->address_line_2)
                                                    <p class="mb-1">{{ $order->shippingAddress->address_line_2 }}</p>
                                                @endif
                                                <p class="mb-1">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}</p>
                                                <p class="mb-1">{{ $order->shippingAddress->country }}</p>
                                            @else
                                                <p class="text-muted mb-1">No shipping address recorded.</p>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">Order Information:</h4>
                                            <p class="mb-1">Date: {{ $order->created_at->format('d M Y') }}</p>
                                            <p class="mb-1">Recurring Order: {{ $order->is_recurring ? 'Yes' : 'No' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Order Summary</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 table-hover table-centered">
                                            <thead class="bg-light-subtle border-bottom">
                                                <tr>
                                                    <th>Product Name & Variant</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantity</th>
                                                    <th class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $subtotal = 0;
                                                @endphp
                                                @foreach ($order->items as $item)
                                                @php
                                                    $itemTotal = $item->unit_price * $item->quantity;
                                                    $subtotal += $itemTotal;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                <img src="{{ $item->product->images }}" alt="" class="avatar-md">
                                                            </div>
                                                            <div>
                                                                <span class="text-dark fw-medium fs-15">{{ $item->product->title }}</span>
                                                                @if($item->productVariant)
                                                                    <small class="text-muted d-block">Size: {{ $item->productVariant->size }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>£{{ number_format($item->unit_price, 2) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td class="text-end">£{{ number_format($itemTotal, 2) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="4" class="text-end pb-3"><span class="fw-semibold">Subtotal:</span> £{{ number_format($subtotal, 2) }}</td>
                                                </tr>
                                                @if($order->discount_amount > 0)
                                                <tr>
                                                    <td colspan="4" class="text-end pb-3 text-danger"><span class="fw-semibold">Discount (-):</span> -£{{ number_format($order->discount_amount, 2) }}</td>
                                                </tr>
                                                @endif
                                                @if($order->shipping_amount > 0)
                                                <tr>
                                                    <td colspan="4" class="text-end pb-3"><span class="fw-semibold">Shipping:</span> £{{ number_format($order->shipping_amount, 2) }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="4" class="text-end pb-3 fw-bold fs-16 text-dark"><span class="fw-bold">Grand Total:</span> £{{ number_format($order->total_amount, 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ route('admin.b2b-orders.update', $order->id ) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="status" class="form-label">Order / Payment Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Submitted" {{ $order->status === 'Submitted' ? 'selected' : '' }}>Submitted</option>
                                    <option value="Approved" {{ $order->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Shipped" {{ $order->status === 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="Invoiced" {{ $order->status === 'Invoiced' ? 'selected' : '' }}>Invoiced</option>
                                    <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ $order->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="submit" value="Update Status" class="btn btn-primary">
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('printBtn').addEventListener('click', function () {
        const content = document.getElementById('printSection').innerHTML;
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        printWindow.document.write('<html><head><title>Invoice</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
        printWindow.document.write('</head><body><div class="container py-4">');
        printWindow.document.write(content);
        printWindow.document.write('</div></body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 500);
    });
</script>
@endpush

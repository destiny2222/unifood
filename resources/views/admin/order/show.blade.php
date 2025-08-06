@extends('layouts.master')
@section('content')
    <!-- Start Container -->
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row mb-4">
                    <div class="col-6">
                        <a href="{{ route('admin.order.list') }}" class="btn btn-primary">Return Back</a>
                        <a href="#!" id="printBtn" class="btn btn-info ps-3 pe-3">
                            <i class='bx bx-printer'  ></i>  Print
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
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">#{{ $orderItem->invoice_number }}  </h4>
                                            {{-- <p class="mb-0">Order / Order Details / #0758267/90 - April 23 , 2024 at 6:23 pm --}}
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">Payment Information:</h4>
                                            <p class="mb-0">Payment Method: {{ $orderItem->payment_method ?? ''}}</p>
                                            <p class="mb-0">Status: 
                                                @if ($orderItem->payment_status == 1)
                                                    <span class="badge bg-success-subtle text-success  px-2 py-1 fs-13">Success</span>
                                                @else
                                                    <span class="badge bg-success-subtle text-success  px-2 py-1 fs-13">Pending</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">Delivery Information:</h4>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->user->name ?? '' }}</p>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->user->email ?? '' }}</p>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->user->phone ?? '' }}</p>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->address ?? '' }}</p>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->state ?? '' }}</p>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->city ?? '' }}</p>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->postal_code ?? '' }}</p>
                                            <p class="mb-1">{{ $orderItem->shippingAddress->country ?? '' }}</p>
                                        </div>
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">Order Information:</h4>
                                            <p class="mb-1">Date: {{ $orderItem->created_at->format('d M Y') }}</p>
                                            <p class="mb-1">Status: 
                                                @if ($orderItem->order_status == 1)
                                                <span class="badge px-2 border border-warning text-warning px-2 py-1 fs-13" text-capitalized="">In Progress</span>
                                                @elseif ($orderItem->order_status == 2)
                                                <span class="badge px-2 border border-info text-info px-2 py-1 fs-13" text-capitalized="">Delivered</span>
                                                @elseif ($orderItem->order_status == 3)
                                                <span class="badge px-2 border border-success text-success  px-2 py-1 fs-13" text-capitalized="">Completed</span>
                                                @elseif ($orderItem->order_status == 4)
                                                <span class="badge px-2 border border-danger text-danger px-2 py-1 fs-13" text-capitalized="">Declined</span>
                                                @elseif ($orderItem->order_status == 0)
                                                <span class="badge px-2 border border-danger text-danger px-2 py-1 fs-13" text-capitalized="">Pending</span> 
                                                @endif
                                            </p>
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
                                                    <th>Product Name & Size</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                <img src="{{ $orderItem->product->images }}" alt="" class="avatar-md">
                                                            </div>
                                                            <div>
                                                                <a href="#!" class="text-dark fw-medium fs-15">
                                                                    {{ $orderItem->product->title }}
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>${{ $orderItem->price }}</td>
                                                    <td> {{ $orderItem->quantity }}</td>
                                                    <td> ${{ $orderItem->price * $orderItem->quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-end">Subtotal : €{{ $orderItem->price * $orderItem->quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-end">Discount: €0</td>
                                                </tr>
                                                <tr>
                                                    @if ($orderItem->product->has_variants == 1)
                                                        <td>
                                                            @foreach ($ as $item)
                                                                
                                                            @endforeach
                                                        </td>
                                                    @else
                                                        <td colspan="4" class="text-end">Weight: {{ number_format($orderItem->product->weight, 2) }} {{ $orderItem->product->unit }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-end">
                                                        Grand Total : €
                                                        {{
                                                            ($orderItem->price * $orderItem->quantity) 
                                                        }}
                                                    </td>
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

        printWindow.document.write(`
            <html>
            <head>
                <title>Invoice</title>
                <link href="/backend/css/vendor.min.css" rel="stylesheet" type="text/css" />
                <link href="/backend/css/icons.min.css" rel="stylesheet" type="text/css" />
                <link href="/backend/css/app.min.css" rel="stylesheet" type="text/css" />
            </head>
            <body>
                ${content}
            </body>
            </html>
        `);

        printWindow.document.close();

        // Wait for styles to load before printing
        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        };
    });
</script>

@endpush

@extends('layouts.master')
@section('heading', 'B2B Orders')
@section('content')
<div class="container-xxl">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">All B2B Purchase Orders</h4>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th>PO Number</th>
                                    <th>Ref ID</th>
                                    <th>Created at</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-medium text-dark">{{ $order->po_number ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.b2b-orders.show', $order->id) }}" class="link-primary">{{ $order->internal_reference }}</a>
                                    </td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $order->user->name }}</span>
                                        @if($order->user->kyc && $order->user->kyc->company_name)
                                            <small class="text-muted d-block">{{ $order->user->kyc->company_name }}</small>
                                        @endif
                                    </td>
                                    <td>£{{ number_format($order->total_amount, 2) }}</td>
                                    <td>£{{ number_format($order->discount_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
                                    </td>
                                    <td>
                                        @if ($order->status == 'Submitted')
                                            <span class="badge bg-warning-subtle text-warning px-2 py-1 fs-13">Submitted</span>
                                        @elseif ($order->status == 'Approved')
                                            <span class="badge bg-info-subtle text-info px-2 py-1 fs-13">Approved</span>
                                        @elseif ($order->status == 'Completed')
                                            <span class="badge bg-success-subtle text-success px-2 py-1 fs-13">Completed</span>
                                        @elseif ($order->status == 'Invoiced')
                                            <span class="badge bg-primary-subtle text-primary px-2 py-1 fs-13">Invoiced</span>
                                        @elseif ($order->status == 'Cancelled')
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1 fs-13">Cancelled</span>
                                        @else
                                            <span class="badge bg-light text-dark px-2 py-1 fs-13">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.b2b-orders.show', $order->id) }}" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a>
                                            
                                            <a href="#!" data-bs-toggle="modal" data-bs-target="#statusModal-{{$order->id}}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                            
                                            <a href="{{ route('admin.b2b-orders.delete', $order->id) }}" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this order?')) { document.getElementById('delete-form-{{$order->id}}').submit(); }" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                            <form class="d-none" action="{{ route('admin.b2b-orders.delete', $order->id) }}" method="post" id="delete-form-{{$order->id}}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Status Modal -->
                                <div class="modal fade" id="statusModal-{{ $order->id }}" tabindex="-1" aria-labelledby="statusModalLabel-{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="statusModalLabel-{{ $order->id }}">Update Order Status (#{{ $order->internal_reference }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.b2b-orders.update', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Order Status</label>
                                                        <select name="status" class="form-control" required>
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
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">No B2B orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer border-top">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.master')
@section('content')
<div class="container-xxl">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <div>
                            <h4 class="card-title">All Order List</h4>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded" data-bs-toggle="dropdown" aria-expanded="false">
                            This Month
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Download</a>
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Export</a>
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Import</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Created at</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th>Items</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orderItems as $orderItem)
                                    <tr>
                                        <td>
                                            #583488/80
                                        </td>
                                        <td>{{ $orderItem->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="#!" class="link-success fw-medium">{{ $orderItem->user->name }}</a>
                                        </td>
                                        <td> &#8358;{{ number_format($orderItem->price, 2) }} </td>
                                        <td> 
                                            @if ($orderItem->payment_status == 1)
                                             <span class="badge bg-success text-light  px-2 py-1 fs-13">Paid</span>
                                            @elseif ($orderItem->payment_status == 2)
                                             <span class="badge bg-light text-dark  px-2 py-1 fs-13">Processing</span>
                                            @elseif ($orderItem->payment_status == 3)
                                             <span class="badge bg-light text-dark  px-2 py-1 fs-13">Unpaid</span>
                                            @else
                                             <span class="badge bg-light text-dark  px-2 py-1 fs-13">Pending</span>
                                            @endif
                                        </td>
                                        <td> {{ $orderItem->quantity }} </td>
                                        <td> 
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
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.order.show', $orderItem->id) }}" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" data-bs-toggle="modal" data-bs-target="#topModal-{{$orderItem->id}}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <a href="{{ route('admin.order.delete',$orderItem->id) }}" onclick="return('Are you sure you want to delete this item?') event.preventDefault(); document.getElementById('delete-form-{{$orderItem->id}}').submit();" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <form  class="d-none" action="{{ route('admin.order.delete',$orderItem->id) }}" method="post" id="delete-form-{{$orderItem->id}}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('admin.order.edit')
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
                <div class="card-footer border-top">
                    @if ($orderItems->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mb-0">
                            {{-- Previous Page Link --}}
                            @if ($orderItems->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orderItems->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif
                
                            {{-- Pagination Elements --}}
                            @foreach ($orderItems->getUrlRange(1, $orderItems->lastPage()) as $page => $url)
                                @if ($page == $orderItems->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                
                            {{-- Next Page Link --}}
                            @if ($orderItems->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orderItems->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
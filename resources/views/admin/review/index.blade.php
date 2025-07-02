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
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Product</th>
                                        <th> Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reviews as $review)
                                    <tr>
                                        <td>
                                           {{ $loop->index + 1 }}
                                        </td>
                                        <td>{{ $review->user->name }}</td>
                                        <td>
                                            {{ $review->product->title }}
                                        </td>
                                        <td> 
                                            @if ($review->status == 1)
                                             <span class="badge border border-success text-success px-2 py-1 fs-13">Active</span>
                                            @else
                                             <span class="badge border border-warning text-warning  px-2 py-1 fs-13">In Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#!" data-bs-toggle="modal" data-bs-target="#topModal-{{$review->id}}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <a href="{{ route('admin.review.delete',$review->id) }}" onclick="return('Are you sure you want to delete this item?') event.preventDefault(); document.getElementById('delete-form-{{$review->id}}').submit();" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <form  class="d-none" action="{{ route('admin.review.delete',$review->id) }}" method="post" id="delete-form-{{$review->id}}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('admin.review.edit')
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
                <div class="card-footer border-top">
                    @if ($reviews->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mb-0">
                            {{-- Previous Page Link --}}
                            @if ($reviews->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $reviews->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif
                
                            {{-- Pagination Elements --}}
                            @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                                @if ($page == $reviews->currentPage())
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
                            @if ($reviews->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $reviews->nextPageUrl() }}" rel="next">Next</a>
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
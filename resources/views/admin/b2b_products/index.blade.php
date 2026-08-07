@extends('layouts.master')
@section('heading', 'B2B Wholesale Products')
@section('content')
<div class="container-xxl">

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="card-title">B2B Dedicated Product Catalog</h4>
                        <p class="text-muted mb-0 fs-13">Manage wholesale products, minimum order quantities (MOQ), and volume discounts</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm">+ Add New Product</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.b2b-products.index') }}" class="row g-3 mb-3">
                        <div class="col-md-5">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search B2B products by title...">
                        </div>
                        <div class="col-md-4">
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-secondary w-100">Filter</button>
                            @if(request('search') || request('category_id'))
                                <a href="{{ route('admin.b2b-products.index') }}" class="btn btn-light">Reset</a>
                            @endif
                        </div>
                    </form>

                    <!-- Bulk Delete Form Wrapper -->
                    <form id="bulk-delete-form" action="{{ route('admin.b2b-products.bulk-delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected items? This action cannot be undone.')">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <button type="submit" id="btn-bulk-delete" class="btn btn-danger btn-sm" disabled>
                                    <i class="bx bx-trash"></i> Delete Selected (0)
                                </button>
                                @if(request()->filled('category_id'))
                                    @php
                                        $selectedCat = $categories->firstWhere('id', request('category_id'));
                                    @endphp
                                    <button type="submit" name="delete_all_category" value="1" onclick="return confirm('CAUTION: Are you sure you want to delete ALL products in {{ $selectedCat->title ?? 'this category' }}?')" class="btn btn-outline-danger btn-sm">
                                        <i class="bx bx-trash-alt"></i> Delete All in Category ({{ $selectedCat->title ?? '' }})
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 40px;">
                                            <input type="checkbox" id="check-all" class="form-check-input">
                                        </th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Standard Price</th>
                                        <th>MOQ</th>
                                        <th>Volume Discounts</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="form-check-input product-select-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                    @if($product->images)
                                                        <img src="{{ $product->images }}" alt="" class="avatar-md rounded">
                                                    @else
                                                        <iconify-icon icon="solar:box-bold-duotone" class="fs-24 text-secondary"></iconify-icon>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.product.edit', $product->id) }}" class="text-dark fw-medium">{{ $product->title }}</a>
                                                    <small class="text-muted d-block">{{ $product->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->title ?? 'Uncategorized' }}</td>
                                        <td>£{{ number_format($product->price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info px-2 py-1 fs-12">
                                                MOQ: {{ $product->minimum_order_quantity ?? 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->volumeDiscounts->count() > 0)
                                                <span class="badge bg-success-subtle text-success">
                                                    {{ $product->volumeDiscounts->count() }} Tiers Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->availability == 'in_stock' || (is_numeric($product->availability) && $product->availability > 0))
                                                <span class="text-success fw-medium">In Stock ({{ $product->availability }})</span>
                                            @else
                                                <span class="text-danger fw-medium">Out of Stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-soft-primary btn-sm">Edit</a>
                                                <button type="submit" name="ids[]" value="{{ $product->id }}" class="btn btn-soft-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No B2B wholesale products found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    </form>
                </div>
                <div class="card-footer border-top">
                    @if ($products->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mb-0">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->appends(request()->query())->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif
                
                            {{-- Pagination Elements --}}
                            @php
                                $start = max(1, $products->currentPage() - 2);
                                $end = min($products->lastPage(), $products->currentPage() + 2);
                            @endphp
                            @foreach ($products->appends(request()->query())->getUrlRange($start, $end) as $page => $url)
                                @if ($page == $products->currentPage())
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
                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->appends(request()->query())->nextPageUrl() }}" rel="next">Next</a>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('check-all');
    const checkboxes = document.querySelectorAll('.product-select-checkbox');
    const btnBulkDelete = document.getElementById('btn-bulk-delete');

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkCount();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkCount);
    });

    function updateBulkCount() {
        const checkedCount = document.querySelectorAll('.product-select-checkbox:checked').length;
        if (btnBulkDelete) {
            btnBulkDelete.disabled = checkedCount === 0;
            btnBulkDelete.innerHTML = `<i class="bx bx-trash"></i> Delete Selected (${checkedCount})`;
        }
        if (checkAll) {
            checkAll.checked = checkedCount > 0 && checkedCount === checkboxes.length;
        }
    }
});
</script>
@endpush

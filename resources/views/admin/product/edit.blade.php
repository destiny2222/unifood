@extends('layouts.master')
@section('heading', 'Edit Product')
@section('content')
<div class="container-xxl">

    <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xl-12 col-lg-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Product Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="product-name" class="form-label">Product Name</label>
                                    <input type="text" id="product-name" name="title" value="{{ $product->title }}" class="form-control" placeholder="Product Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="product-categories" class="form-label">Product Categories</label>
                                <select class="form-control" id="product-categories" data-choices data-choices-groups data-placeholder="Select Categories" name="category_id">
                                    <option value="">Choose a categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"  {{ $product->category_id == $category->id ? 'selected' : ''}}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="product-stock" class="form-label">Stock</label>
                                    <input type="number" id="product-stock" name="availability" value="{{ $product->availability }}" class="form-control" placeholder="Stock">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="description" name="description"  placeholder="Short description about the product">{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pricing Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="product-price" class="form-label">Price</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20"><i class='bx bx-discount'></i></span>
                                    <input type="number" id="product-price" name="price" step="0.01" value="{{ $product->price }}" class="form-control" placeholder="00.00">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label for="product-discount" class="form-label">Discount</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20"><i class='bx bxs-discount'></i></span>
                                    <input type="number" id="product-discount" name="discount" step="0.01" value="{{ $product->discount }}" class="form-control" placeholder="00.00">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label for="product-stock" class="form-label">Status</label>
                                <select name="status" class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem">
                                    <option value="1" {{ ($product->status == 1) ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{ $product->status == 0 ? 'selected' : ''}}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>Today Special <span class="text-danger">*</span></label>
                                <select name="today_special" class="form-control">
                                    <option value="0" {{ ($product->status == 1) ? 'selected' : ''}}>No</option>
                                    <option value="1" {{ $product->status == 0 ? 'selected' : ''}}>Yes</option>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3 " id="single-product-fields">
                                <label>Weight</label>
                                <input type="number" step="0.01" name="weight" value="{{ $product->weight }}" class="form-control" placeholder="Weight (e.g. 2.5)">
                            </div>
                            <div class="col-lg-3 mb-3 " id="single-product-fields">
                                <label>Unit</label>
                                <input type="text" name="unit" class="form-control" value="{{ $product->unit }}" placeholder="e.g. kg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"></h4>
                        <div class="mb-3">
                            <label>
                                <input type="checkbox" name="has_variants" id="has_variants" value="1" 
                                {{ ($product->has_variants || $product->variants->count() > 0) ? 'checked' : '' }}> 
                                This product has variants?
                            </label>
                        </div>
                    </div>
                    <div class="card-body variant-card">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div id="variant-options">
                                    @foreach ($product->variants as $index => $variant)
                                        <div class="row mb-2 variant-row" data-variant="{{ $index }}">
                                            <!-- Hidden ID field for existing variants -->
                                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                            
                                            <div class="col-md-2">
                                                <input type="text" name="variants[{{ $index }}][size]" class="form-control"
                                                    placeholder="Size (e.g. M)" value="{{ $variant->size }}">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" step="0.01" name="variants[{{ $index }}][weight]" class="form-control"
                                                    placeholder="Weight" value="{{ $variant->weight }}">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="variants[{{ $index }}][unit]" class="form-control"
                                                    placeholder="Unit (e.g. kg)" value="{{ $variant->unit }}">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" step="0.01" name="variants[{{ $index }}][price]" class="form-control"
                                                    placeholder="Price" value="{{ $variant->price }}">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-sm btn-danger remove-variant" data-variant="{{ $index }}">
                                                    <i class="bx bx-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-variant" class="btn btn-sm btn-primary mt-2">+ Add Variant</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Product Photo</h4>
                    </div>
                    <div class="card-body">
                        <!-- File Upload -->
                       <input type="file" name="image" id="actual-btn" class="form-control"/>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Product Photo</h4>
                    </div>
                    <div class="card-body">
                        <!-- File Upload -->
                       <input type="file" name="images[]" value="" class="form-control" id="actual-btn" multiple />
                    </div>
                </div>
                <div class="p-3 bg-light mb-3 rounded">
                    <div class="row justify-content-end g-2">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary w-100">Update Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    const variantSection = document.querySelector('#variant-options').closest('.variant-card');
    const singlePriceSection = document.querySelector('#product-price').closest('.col-lg-3');
    const singleFields = document.querySelector('#single-product-fields');
    const hasVariantsCheckbox = document.getElementById('has_variants');

    function toggleVariantMode() {
        if (hasVariantsCheckbox.checked) {
            variantSection.style.display = 'block';
            singlePriceSection.style.display = 'none';
            singleFields.style.display = 'none';
        } else {
            variantSection.style.display = 'none';
            singlePriceSection.style.display = 'block';
            singleFields.style.display = 'block';
        }
    }

    // Initial state
    toggleVariantMode();

    // Event listener
    hasVariantsCheckbox.addEventListener('change', toggleVariantMode);
</script>
<script>
    // Initialize variantIndex based on existing variants count
    let variantIndex = document.querySelectorAll('#variant-options .variant-row').length;
    
    // Add variant function
    document.getElementById('add-variant').addEventListener('click', function () {
        const html = `
        <div class="row mb-2 variant-row" data-variant="${variantIndex}">
            <div class="col-md-2">
                <input type="text" name="variants[${variantIndex}][size]" class="form-control" placeholder="Size (e.g. M)">
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="variants[${variantIndex}][weight]" class="form-control" placeholder="Weight">
            </div>
            <div class="col-md-2">
                <input type="text" name="variants[${variantIndex}][unit]" class="form-control" placeholder="Unit (e.g. kg)">
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control" placeholder="Price">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-sm btn-danger remove-variant" data-variant="${variantIndex}">
                    <i class="bx bx-trash"></i> Remove
                </button>
            </div>
        </div>`;
        document.getElementById('variant-options').insertAdjacentHTML('beforeend', html);
        variantIndex++;
    });
    
    // Remove variant function using event delegation
    document.getElementById('variant-options').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant') || e.target.closest('.remove-variant')) {
            const button = e.target.classList.contains('remove-variant') ? e.target : e.target.closest('.remove-variant');
            const variantRow = button.closest('.row');
            // const totalVariants = document.querySelectorAll('#variant-options .row:not([style*="display: none"])').length;
            
            // For existing variants, check if they have an ID (from database)
            const hasId = variantRow.querySelector('input[name*="[id]"]') !== null;
            
            if (hasId) {
                // This is an existing variant - mark for deletion
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = variantRow.querySelector('input').name.replace(/\[(\w+)\]$/, '[_destroy]');
                hiddenInput.value = '1';
                variantRow.appendChild(hiddenInput);
                variantRow.style.display = 'none';
            } else {
                // This is a new variant - safe to remove from DOM
                variantRow.remove();
            }
        }
    });
    
    // Initialize existing variants on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Add variant-row class to existing variants for consistency
        const existingVariants = document.querySelectorAll('#variant-options .row');
        existingVariants.forEach(function(variant) {
            if (!variant.classList.contains('variant-row')) {
                variant.classList.add('variant-row');
            }
        });
        
        // Set the initial variant index
        variantIndex = existingVariants.length;
    });
</script>
@endpush

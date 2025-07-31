@extends('layouts.master')
@section('heading', 'Create Product')
<style>
  
  
</style>
@section('content')
<div class="container-xxl">
    {{-- Display  errors message --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (count($categories) <= 0)
        <div class="row">
            <div class="col-md-4">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <h5 class="card-title text-white  mb-2">Category</h5>
                        <p class="card-text">Please create categories  first.</p>
                        <a href="{{ route('admin.category.create') }}" class="btn btn-light btn-sm">Create Category</a>
                    </div>
                </div> 
            </div>
        </div>
    @else
        <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
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
                                    <input type="text" id="product-name" name="title" class="form-control" placeholder="Items Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="product-categories" class="form-label">Product Categories</label>
                                <select class="form-control" id="product-categories" data-choices data-choices-groups data-placeholder="Select Categories" name="category_id">
                                    <option value="">Choose a categories</option>
                                    @foreach($categories as $category)
                                     <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="product-stock" class="form-label">Stock</label>
                                    <input type="number" id="product-stock" name="availability" class="form-control" placeholder="Quantity">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="description" name="description" rows="7" placeholder="Short description about the product"></textarea>
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
                            <div class="col-lg-3 mb-3">
                                <label for="product-price" class="form-label">Price</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20"><i class='bx bxs-discount'></i></span>
                                    <input type="number" id="product-price" name="price" step="0.01" class="form-control" placeholder="00.00">
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="product-discount" class="form-label">Discount</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20"><i class='bx bxs-discount'></i></span>
                                    <input type="number" id="product-discount" name="discount" step="0.01" class="form-control" placeholder="000">
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="product-stock" class="form-label">Status</label>
                                <select name="status" class="form-control" id="choices-multiple-remove-button">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label>Today Special <span class="text-danger">*</span></label>
                                <select name="today_special" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3 " id="single-product-fields">
                                <label>Weight</label>
                                <input type="number" step="0.01" name="weight" class="form-control" placeholder="Weight (e.g. 2.5)">
                            </div>
                            <div class="col-lg-3 mb-3 " id="single-product-fields">
                                <label>Unit</label>
                                <input type="text" name="unit" class="form-control" placeholder="e.g. kg">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"></h4>
                        <div class="mb-3">
                            <label>
                                <input type="checkbox" name="has_variants" id="has_variants" value="1" {{ old('has_variants') ? 'checked' : '' }}> This product has variants?
                            </label>
                        </div>
                    </div>
                    <div class="card-body variant-card">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div id="variant-options">
                                    <div class="row mb-2 variant-row" data-variant="0">
                                        <div class="col-md-2">
                                            <input type="text" name="variants[0][size]" class="form-control" placeholder="Size (e.g. S)">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" step="0.01" name="variants[0][weight]" class="form-control" placeholder="Weight">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="variants[0][unit]" class="form-control" placeholder="Unit (e.g. kg)">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" step="0.01" name="variants[0][price]" class="form-control" placeholder="Price">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-sm btn-danger remove-variant" data-variant="0">
                                                <i class="bx bx-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>
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
                        

                        {{-- <div class="upload-box" id="uploadBox">
                            <div class="fallback">
                                <input id="fileInput" name="images[]" hidden type="file" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                <h3 class="mt-4">Drop your images here, or <span class="text-primary">click to browse</span></h3>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Product Photos (multiple)</h4>
                    </div>
                    <div class="card-body">
                        <!-- File Upload -->
                       <input type="file" name="images[]" id="actual-btn" class="form-control" multiple/>
                        

                        {{-- <div class="upload-box" id="uploadBox">
                            <div class="fallback">
                                <input id="fileInput" name="images[]" hidden type="file" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                <h3 class="mt-4">Drop your images here, or <span class="text-primary">click to browse</span></h3>
                            </div>
                        </div> --}}
                    </div>
                </div>
              
                <div class="p-3 bg-light mb-3 rounded">
                    <div class="row justify-content-end g-2">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary w-100">Create Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
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
    let variantIndex = 1;
    
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
            const variantRow = button.closest('.variant-row');
            // const totalVariants = document.querySelectorAll('.variant-row').length;
             variantRow.remove();
            // Prevent removing the last variant
            // if (totalVariants > 1) {
            //     variantRow.remove();
            // } else {
            //     alert('At least one variant is required.');
            // }
        }
    });
</script>
@endpush

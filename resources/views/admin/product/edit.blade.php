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
                            <div class="col-lg-4">
                                <form>
                                    <label for="product-price" class="form-label">Price</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text fs-20"><i class='bx bx-dollar'></i></span>
                                        <input type="number" id="product-price" name="price" step="0.01" value="{{ $product->price }}" class="form-control" placeholder="00.00">
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <label for="product-discount" class="form-label">Discount</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20"><i class='bx bxs-discount'></i></span>
                                    <input type="number" id="product-discount" name="discount" step="0.01" value="{{ $product->discount }}" class="form-control" placeholder="00.00">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="product-stock" class="form-label">Status</label>
                                <select name="status" class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem">
                                    <option value="1" {{ ($product->status == 1) ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{ $product->status == 0 ? 'selected' : ''}}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Today Special <span class="text-danger">*</span></label>
                                <select name="today_special" class="form-control">
                                    <option value="0" {{ ($product->status == 1) ? 'selected' : ''}}>No</option>
                                    <option value="1" {{ $product->status == 0 ? 'selected' : ''}}>Yes</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="weight">Weight</label>
                                <input type="number" step="0.01" value="{{ $product->weight }}" id="weight" name="weight" class="form-control" required>
                            </div>
                            <div class="col-lg-4">
                                <label for="weight_unit">Unit</label>
                                <select name="weight_unit" class="form-control" required>
                                    <option value="g" {{ $product->weight_unit == 'g' ? 'selected' : ''}}>Grams</option>
                                    <option value="kg" {{ $product->weight_unit == 'kg' ? 'selected' : ''}}>Kilograms</option>
                                </select>
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
<script>
    // Select the elements
    const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('fileInput');

    // Add click event listener to the upload box
    uploadBox.addEventListener('click', () => {
        fileInput.click(); // Trigger the hidden input file dialog
    });

    // Add event listener for file selection
    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        console.log('Selected files:', files); // You can handle the selected files here
    });
</script>
@endsection

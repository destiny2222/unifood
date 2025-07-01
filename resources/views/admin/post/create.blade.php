@extends('layouts.master')
@section('heading', 'Post List')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.post.index') }}">
                        <h4 class="card-title d-flex align-items-center gap-1 ">
                            <iconify-icon icon="solar:settings-bold-duotone" class="text-white fs-20"></iconify-icon>
                        Return back
                        </h4>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.post.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Title</label>
                                    <input type="text" id="meta-name" name="title"  class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label for="product-categories" class="form-label">Categories</label>
                                <select class="form-control" id="product-categories" data-choices data-choices-groups data-placeholder="Select Categories" name="category_id">
                                    <option value="">Choose a categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label">Upload Image</label>
                                    <input type="file" name="image" id="meta-name" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <textarea name="description" id="body" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-12 mb-4">
                                <label>Show Homepage ?  <span class="text-danger">*</span></label>
                                <select name="show_homepage" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-12 mb-4">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <button type="submit"  class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Container Fluid -->
@endsection
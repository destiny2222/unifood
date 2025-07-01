@extends('layouts.master')
@section('heading', 'Post List')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                       <a href="{{ route('admin.post.index') }}">Return back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Title</label>
                                    <input type="text" id="meta-name" name="title" value="{{ $post->title }}"  class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label for="product-categories" class="form-label">Product Categories</label>
                                <select class="form-control" id="product-categories" data-choices data-choices-groups data-placeholder="Select Categories" name="category_id">
                                    <option value="">Choose a categories</option>
                                    @foreach($categories as $category)
                                     <option value="{{ $category->id }}"  {{ $post->category_id == $category->id ? 'selected' : ''}}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label">Upload Image</label>
                                    <input type="file" name="image" id="meta-name" value="{{ $post->image }}"  class="form-control" placeholder="Image">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <textarea name="description" id="body" cols="30" rows="10">{{ $post->description }}</textarea>
                            </div>
                            <div class="col-12 mb-4">
                                <label>Show Homepage ?  <span class="text-danger">*</span></label>
                                <select name="show_homepage" class="form-control" required>
                                    <option value="0" {{ $post->show_homepage == 0 ? 'selected' : ''}}>No</option>
                                    <option value="1" {{ $post->show_homepage == 1 ? 'selected' :}}>Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="0" {{ $post->status == 0 ? 'selected' }}>Inactive</option>
                                    <option value="1" {{ $post->status == 1 ? 'selected' }}>Active</option>
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
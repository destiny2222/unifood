@extends('layouts.master')
@section('heading', 'Service List')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                        <a href="{{ route('admin.service.index') }}">Return back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Title</label>
                                    <input type="text" id="meta-name" name="title" class="form-control" placeholder="Title" value="{{ old('title', $service->title) }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <div class="">
                                            <label for="meta-description" class="form-label">Icon</label>
                                            <input type="text" name="icon" id="" class="form-control" value="{{ old('icon', $service->icon) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="product-stock" class="form-label">Status</label>
                                        <select name="status" class="form-control" id="choices-multiple-remove-button">
                                            <option value="1" {{ old('status', $service->status) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status', $service->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="meta-description" name="description" cols="30" rows="4">{{ old('description', $service->description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success w-100">Save</button>
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

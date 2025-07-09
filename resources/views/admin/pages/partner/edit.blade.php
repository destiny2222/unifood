@extends('layouts.master')
@section('heading', 'Partner List')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                        <a href="{{ route('admin.partner.index') }}">Return back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <div class="">
                                            <label for="meta-description" class="form-label">Image</label>
                                            <input type="file" name="image"  id="" value="{{ $partner->image }}"   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="product-stock" class="form-label">Status</label>
                                        <select name="status" class="form-control" id="choices-multiple-remove-button">
                                            <option value="1" value="{{ $partner->status === 1 ? 'selected' : '' }}">Active</option>
                                            <option value="0" value="{{ $partner->status === 0 ? 'selected' : ''}}">Inactive</option>
                                        </select>
                                    </div>
                                </div>
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
 
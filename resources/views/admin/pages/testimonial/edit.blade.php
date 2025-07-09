@extends('layouts.master')
@section('heading', 'Testimonial')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                        <a href="{{ route('admin.testimonial.index') }}">Return back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.testimonial.update', $testimonial->id ) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Name</label>
                                    <input type="text" id="meta-name" name="name" value="{{ $testimonial->name ?? '' }}"  class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for=""> Designation </label>
                                <input type="text" id="meta-name" name="designation" value="{{ $testimonial->designation ?? ''}}"   class="form-control" placeholder="">
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="product-stock" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="choices-multiple-remove-button">
                                        <option value="1" {{ $testimonial->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{ $testimonial->status == 0 ? 'selected' : ''}}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <div class="">
                                            <label for="meta-description" class="form-label">Image</label>
                                            <input type="file" name="existing_image"  id="" value="{{ $testimonial->existing_image ?? '' }}"   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <img src="{{ $testimonial && $testimonial->existing_image ? asset('upload/testimonial/'.$testimonial->existing_image) : asset('default-image-path.jpg') }}" class="img-fluid" alt="" style="width: 50%; height: auto; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <label for="meta-description" class="form-label">Product Image</label>
                                        <input type="file" name="product_image"  id="" value="{{ $testimonial->product_image ?? '' }}"   class="form-control">
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <img src="{{ $testimonial && $testimonial->product_image ? asset('upload/testimonial/product/'.$testimonial->product_image) : asset('default-image-path.jpg') }}" class="img-fluid" alt="" style="width: 50%; height: auto; object-fit: cover;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="meta-description" name="description"  name="description"  cols="30" rows="4">{{ $testimonial->description ?? ''}}</textarea>
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
 
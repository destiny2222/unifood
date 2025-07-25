@extends('layouts.master')
@section('heading', 'Slide List')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                        <a href="{{ route('admin.slider.index') }}">Return back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-name-title-one" class="form-label"> Title</label>
                                    <input type="text" id="meta-name-title-one" name="title_one" class="form-control" placeholder="Title" value="{{ old('title_one', $slider->title_one) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-name-title-two" class="form-label">Subtitle</label>
                                    <input type="text" id="meta-name-title-two" name="title_two" class="form-control" placeholder="Title" value="{{ old('title_two', $slider->title_two) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-name-offer-text" class="form-label"> Offer text </label>
                                    <input type="text" id="meta-name-offer-text" name="offer_text" class="form-control" placeholder="Title" value="{{ old('offer_text', $slider->offer_text) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-name-link" class="form-label">Button link</label>
                                    <input type="text" id="meta-name-link" name="link" class="form-control" placeholder="Title" value="{{ old('link', $slider->link) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-name-serial" class="form-label">Serial</label>
                                    <input type="text" id="meta-name-serial" name="serial" class="form-control" placeholder="Title" value="{{ old('serial', $slider->serial) }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="product-stock" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="choices-multiple-remove-button">
                                        <option value="1" {{ old('status', $slider->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $slider->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="meta-description-image" class="form-label">Image</label>
                                            <input type="file" name="image" id="meta-description-image" class="form-control">
                                            @if($slider->image)
                                                <img src="{{ $slider->image }}" alt="Current Image" class="mt-2" style="max-width: 150px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="meta-description" name="description" cols="30" rows="4">{{ old('description', $slider->description) }}</textarea>
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
 
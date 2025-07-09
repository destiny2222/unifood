@extends('layouts.master')
@section('heading', 'About Us')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">About Us</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="short_title" class="form-label">Short Title</label>
                                    <input type="text" id="short_title" name="short_title" value="{{ $about->short_title ?? '' }}" class="form-control" placeholder="Short Title">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="long_title" class="form-label">Long Title</label>
                                    <input type="text" id="long_title" name="long_title" value="{{ $about->long_title ?? '' }}" class="form-control" placeholder="Long Title">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="meta-description" name="description" cols="30" rows="4">{{ $about->description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    @if(!empty($about->image))
                                        <img src="{{ asset('upload/about-us/'.$about->image) }}" class="img-fluid mt-2" style="width: 50%; height: auto; object-fit: cover;" alt="">
                                    @endif
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Why Choose Us</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.why-choose-us.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="short_title" class="form-label">Short Title</label>
                                    <input type="text" id="short_title" name="short_title" value="{{ $whyChoose->short_title ?? '' }}" class="form-control" placeholder="Short Title">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="long_title" class="form-label">Long Title</label>
                                    <input type="text" id="long_title" name="long_title" value="{{ $whyChoose->long_title ?? '' }}" class="form-control" placeholder="Long Title">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="description" name="description" cols="30" rows="4">{{ $whyChoose->description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ (isset($whyChoose) && $whyChoose->status == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (isset($whyChoose) && $whyChoose->status == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="title_one" class="form-label">Title One</label>
                                    <input type="text" id="title_one" name="title_one" value="{{ $whyChoose->title_one ?? '' }}" class="form-control" placeholder="Title One">
                                </div>
                                <div class="mb-3">
                                    <label for="icon_one" class="form-label">Icon One</label>
                                    <input type="text" id="icon_one" name="icon_one" value="{{ $whyChoose->icon_one ?? '' }}" class="form-control" placeholder="Icon One">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="title_two" class="form-label">Title Two</label>
                                    <input type="text" id="title_two" name="title_two" value="{{ $whyChoose->title_two ?? '' }}" class="form-control" placeholder="Title Two">
                                </div>
                                <div class="mb-3">
                                    <label for="icon_two" class="form-label">Icon Two</label>
                                    <input type="text" id="icon_two" name="icon_two" value="{{ $whyChoose->icon_two ?? '' }}" class="form-control" placeholder="Icon Two">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="title_three" class="form-label">Title Three</label>
                                    <input type="text" id="title_three" name="title_three" value="{{ $whyChoose->title_three ?? '' }}" class="form-control" placeholder="Title Three">
                                </div>
                                <div class="mb-3">
                                    <label for="icon_three" class="form-label">Icon Three</label>
                                    <input type="text" id="icon_three" name="icon_three" value="{{ $whyChoose->icon_three ?? '' }}" class="form-control" placeholder="Icon Three">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="title_four" class="form-label">Title Four</label>
                                    <input type="text" id="title_four" name="title_four" value="{{ $whyChoose->title_four ?? '' }}" class="form-control" placeholder="Title Four">
                                </div>
                                <div class="mb-3">
                                    <label for="icon_four" class="form-label">Icon Four</label>
                                    <input type="text" id="icon_four" name="icon_four" value="{{ $whyChoose->icon_four ?? '' }}" class="form-control" placeholder="Icon Four">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="background_image" class="form-label">Background Image</label>
                                    <input type="file" name="background_image" id="background_image" class="form-control">
                                    @if(!empty($whyChoose->background_image))
                                        <img src="{{ asset('upload/whyChoose/background/'.$whyChoose->background_image) }}" class="img-fluid mt-2" style="width: 50%; height: auto; object-fit: cover;" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="image_one" class="form-label">Image One</label>
                                    <input type="file" name="image_one" id="image_one" class="form-control">
                                    @if(!empty($whyChoose->image_one))
                                        <img src="{{ asset('upload/whyChoose/image/'.$whyChoose->image_one) }}" class="img-fluid mt-2" style="width: 50%; height: auto; object-fit: cover;" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="image_two" class="form-label">Image Two</label>
                                    <input type="file" name="image_two" id="image_two" class="form-control">
                                    @if(!empty($whyChoose->image_two))
                                        <img src="{{ asset('upload/whyChoose/'.$whyChoose->image_two) }}" class="img-fluid mt-2" style="width: 50%; height: auto; object-fit: cover;" alt="">
                                    @endif
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
 
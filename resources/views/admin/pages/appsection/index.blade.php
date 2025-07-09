@extends('layouts.master')
@section('heading', 'App Section')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.app-section.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Title</label>
                                    <input type="text" id="meta-name" name="title" value="{{ $appsection->title ?? '' }}"  class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for=""> Play store link</label>
                                <input type="text" id="meta-name" name="play_store_link" value="{{ $appsection->play_store_link ?? ''}}"   class="form-control" placeholder="">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for=""> App store link</label>
                                <input type="text" id="meta-name" name="app_store_link" value="{{ $appsection->app_store_link ?? '' }}"   class="form-control" placeholder="">
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <div class="">
                                            <label for="meta-description" class="form-label">Background Image</label>
                                            <input type="file" name="background_image"  id="" value="{{ $appsection->background_image ?? '' }}"   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <img src="{{ $appsection && $appsection->background_image ? asset('upload/appsection/'.$appsection->background_image) : asset('default-image-path.jpg') }}" class="img-fluid" alt="" style="width: 50%; height: auto; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <label for="meta-description" class="form-label">Image</label>
                                        <input type="file" name="app_image"  id="" value="{{ $appsection->app_image ?? '' }}"   class="form-control">
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <img src="{{ $appsection && $appsection->app_image ? asset('upload/appsection/image/'.$appsection->app_image) : asset('default-image-path.jpg') }}" class="img-fluid" alt="" style="width: 50%; height: auto; object-fit: cover;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" id="meta-description" name="description"  name="description"  cols="30" rows="4">{{ $appsection->description ?? ''}}</textarea>
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
 
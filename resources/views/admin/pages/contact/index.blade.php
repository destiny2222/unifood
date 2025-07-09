@extends('layouts.master')
@section('heading', 'Contact Us')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.contact.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Email Address </label>
                                    <textarea name="email" class="form-control text-area-3" id="" cols="20" rows="2">{{ $contact->email ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for=""> Phone Number</label>
                                <textarea name="phone" class="form-control text-area-3" id="" cols="20" rows="2">{{ $contact->phone ?? ''}}</textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for=""> Address </label>
                                <textarea name="address" class="form-control text-area-3" id="" cols="20" rows="2">{{ $contact->address ?? '' }}</textarea>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12 mb-3">
                                        <div class="">
                                            <label for="meta-description" class="form-label">Background Image</label>
                                            <input type="file" name="existing_image"  id="" value="{{ $contact->existing_image ?? '' }}"   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <img src="{{ $contact && $contact->existing_image ? asset('upload/contact/'.$contact->existing_image) : asset('default-image-path.jpg') }}" class="img-fluid" alt="" style="width: 50%; height: auto; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="meta-description" class="form-label">Map</label>
                                    <textarea class="form-control bg-light-subtle" id="meta-description" name="map"   cols="30" rows="4">{{ $contact->map ?? ''}}</textarea>
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
 
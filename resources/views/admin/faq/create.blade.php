@extends('layouts.master')
@section('heading', 'Faq List')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                       <a href="{{ route('admin.faq.index') }}">Return back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.faq.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Question </label>
                                    <input type="text" id="meta-name" name="question"  class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <textarea name="answer" id="meta-description" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="product-stock" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="choices-multiple-remove-button">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
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
 
@extends('layouts.master')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon> Setting
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update.profile' , $admins->id ) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-name" class="form-label"> Name</label>
                                    <input type="text" id="meta-name" name="name" value="{{ $admins->name ?? ''  }}" class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-tag" class="form-label">Email</label>
                                    <input type="text" id="meta-tag" name="email" value="{{ $admins->email ?? ''  }}" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="">Phone</label>
                                    <input type="text" value="{{ $admins->phone ?? ''  }}" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="meta-description" class="form-label">Profile picture</label>
                                            <input type="file" name="image" id="" value="{{ $admins->image ?? ''  }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success w-100">Save Change</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex align-items-center gap-1">
                        <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon> Change Password
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.change.password.update') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label">New Password</label>
                                <input class="form-control" type="password" name="new_password" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label">Repeat New Password</label>
                                <input class="form-control" type="password" name="confirm_password" placeholder="" />
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="submit" class="btn btn-success me-2 w-100" value="Save Change">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
@endsection

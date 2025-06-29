@extends('layouts.master')
@section('heading', 'Create Delivery Area')
@section('content')
<div class="container-xxl">

    <div class="row">
         <div class="col-xl-12 col-lg-12 ">
              <form action="{{ route('admin.delivery.area.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                         <div class="card-header">
                              <a href="{{ route('admin.delivery.area.index') }}" class="btn btn-primary"><i class="ri-arrow-left-line"></i> Delivery Area</a>
                         </div>
                         <div class="card-body">
                            <div class="row">
                                <div class="mb-4 col-12">
                                    <label>Area Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="area_name">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label>Minimum delivery time (Minutes) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="minimum_delivery_time">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label>Maximum delivery time (Minutes) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="maximum_delivery_time" >
                                </div>



                                <div class="mb-4 col-md-6">
                                    <label>Delivery Fee <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="delivery_fee">
                                </div>


                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option selected="" value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>
                         </div>
                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                         <div class="row justify-content-center g-2">
                              <div class="col-lg-12 text-center">
                                   <button type="submit"  class="btn btn-primary w-50">Create Delivery Area</button>
                              </div>
                         </div>
                    </div>
              </form>
         </div>
    </div>
</div>
@endsection
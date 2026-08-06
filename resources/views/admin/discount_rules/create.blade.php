@extends('layouts.master')
@section('heading', 'Create Discount Rule')
@section('content')
<div class="container-xxl">

    <div class="row">
         <div class="col-xl-12 col-lg-12">
              <form action="{{ route('admin.discount-rules.store') }}" method="post">
                    @csrf
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Checkout Discount Rule Details</h4>
                         </div>
                         <div class="card-body">
                              <div class="row">
                                   <div class="col-lg-6">
                                        <div class="mb-3">
                                             <label for="min_amount" class="form-label">Minimum Purchase Amount (£)</label>
                                             <input type="number" step="0.01" id="min_amount" name="min_amount" class="form-control" placeholder="e.g. 100.00" required>
                                        </div>
                                   </div>
                                   <div class="col-lg-6">
                                        <div class="mb-3">
                                             <label for="discount_percentage" class="form-label">Discount Percentage (%)</label>
                                             <input type="number" step="0.01" id="discount_percentage" name="discount_percentage" class="form-control" placeholder="e.g. 10.00" required>
                                        </div>
                                   </div>
                                   <div class="col-lg-6">
                                        <div class="mb-3">
                                             <label for="max_discount_amount" class="form-label">Maximum Discount Cap (£)</label>
                                             <input type="number" step="0.01" id="max_discount_amount" name="max_discount_amount" class="form-control" placeholder="e.g. 50.00" required>
                                        </div>
                                   </div>
                                   <div class="col-lg-6">
                                        <div class="mb-3">
                                             <label for="is_active" class="form-label">Status</label>
                                             <select id="is_active" name="is_active" class="form-control" required>
                                                 <option value="1">Active</option>
                                                 <option value="0">Inactive</option>
                                             </select>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                         <div class="row justify-content-center g-2">
                              <div class="col-lg-12 text-center">
                                   <button type="submit" class="btn btn-primary w-50">Create Discount Rule</button>
                              </div>
                         </div>
                    </div>
              </form>
         </div>
    </div>
</div>
@endsection

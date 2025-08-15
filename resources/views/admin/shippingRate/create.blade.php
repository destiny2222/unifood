@extends('layouts.master')
@section('heading', 'Create Shipping Rate')
@section('content')

<div class="container-xxl">

     <div class="row">
          <div class="col-xl-12">
               <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Create Shipping Rate</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.shipping.rate.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="min_weight" class="form-label">Minimum Weight</label>
                                <input type="text" class="form-control" id="min_weight" name="min_weight" value="{{ old('min_weight') }}">
                            </div>
                            <div class="mb-3">
                                <label for="max_weight" class="form-label">Maximum Weight</label>
                                <input type="text" class="form-control" id="max_weight" name="max_weight" value="{{ old('max_weight') }}">
                            </div>
                            <div class="mb-3">
                                <label for="delivery_type" class="form-label">Delivery Type</label>
                                <input type="text" class="form-control" id="delivery_type" name="delivery_type" value="{{ old('delivery_type') }}">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
               </div>
          </div>
     </div>

</div>

@endsection

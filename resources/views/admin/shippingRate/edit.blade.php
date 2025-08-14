@extends('layouts.master')
@section('heading', 'Edit Shipping Rate')
@section('content')

<div class="container-xxl">

     <div class="row">
          <div class="col-xl-12">
               <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Edit Shipping Rate</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.shipping.rate.update', $rate->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="min_weight" class="form-label">Minimum Weight</label>
                                <input type="text" class="form-control" id="min_weight" name="min_weight" value="{{ $rate->min_weight }}">
                            </div>
                            <div class="mb-3">
                                <label for="max_weight" class="form-label">Maximum Weight</label>
                                <input type="text" class="form-control" id="max_weight" name="max_weight" value="{{ $rate->max_weight }}">
                            </div>
                            <div class="mb-3">
                                <label for="delivery_type" class="form-label">Delivery Type</label>
                                <select class="form-select" id="delivery_type" name="delivery_type">
                                    <option value="next_day" {{ $rate->delivery_type == 'next_day' ? 'selected' : '' }}>Next Day</option>
                                    <option value="next_morning" {{ $rate->delivery_type == 'next_morning' ? 'selected' : '' }}>Next Morning</option>
                                    <option value="two_days" {{ $rate->delivery_type == 'two_days' ? 'selected' : '' }}>Two Days</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ $rate->price }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
               </div>
          </div>
     </div>

</div>

@endsection

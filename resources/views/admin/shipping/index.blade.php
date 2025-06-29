@extends('layouts.master')
@section('heading', 'Shipping List')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class=" d-flex justify-content-between">
                        <h4 class="card-title d-flex align-items-center gap-1">
                            <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                            Shipping
                        </h4>
                        <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">Add  Shipping</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between g-3">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                 <thead class="bg-light-subtle">
                                      <tr>
                                           <th>
                                               S/N
                                           </th>
                                           <th>Title</th>
                                           <th>Price</th>
                                           <th>Status</th>
                                           <th>Action</th>
                                      </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($shippings as $shipping)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ $shipping->title }}
                                        </td>
                                        <td>{{ number_format($shipping->price, 2) }}</td>
                                        <td>
                                            @if ($shipping->status == '1')
                                             <span class="badge bg-primary rounded-pill me-1">Active</span>
                                            @else
                                             <span class="badge bg-warning rounded-pill me-1">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.shipping.edit', $shipping->id)  }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <a href="{{ route('admin.shipping.delete',$shipping->id) }}" class="btn btn-soft-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-{{ $shipping->id }}').submit() "><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <form action="{{ route('admin.shipping.delete',$shipping->id) }}" class="d-none" id="delete-{{ $shipping->id }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                            </table>
                       </div>
                       <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Container Fluid -->
@endsection

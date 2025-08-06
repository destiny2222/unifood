@extends('layouts.master')
@section('heading', 'Delivery Area')
@section('content')

<div class="container-xxl">

     <div class="row">
          <div class="col-xl-12">
               <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                         {{-- <h4 class="card-title flex-grow-1">All Categories List</h4> --}}

                         <a href="{{ route('admin.delivery.area.create') }}" class="btn btn-sm btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i>  Add Delivery Area
                         </a>
                    </div>
                    <div>
                         <div class="table-responsive">
                              <table class="table align-middle mb-0 table-hover table-centered">
                                   <thead class="bg-light-subtle">
                                        <tr>
                                             <th> S/N </th>
                                             <th>Minimum Delivery</th>
                                             <th>Delivery Fee</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @foreach ($deliveries as $deliveryArea)
                                        <tr>
                                             <td>
                                                 {{ $loop->index + 1 }}
                                             </td>
                                             <td>{{ $deliveryArea->minimum_delivery }}</td>
                                             <td>
                                                €{{ $deliveryArea->delivery_fee  }}
                                             </td>
                                             <td>
                                                @if ($deliveryArea->status == 1)
                                                    <span class="badge bg-success-subtle text-success py-1 px-2">Active</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger py-1 px-2">Inactive</span>
                                                @endif
                                             </td>
                                             <td>
                                                  <div class="d-flex gap-2">
                                                       {{-- <a href="#!" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a> --}}
                                                       <a href="{{ route('admin.delivery.area.edit', $deliveryArea->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <a href="{{ route('admin.delivery.area.delete', $deliveryArea->id) }}" onclick="event.preventDefault(); document.getElementById('delete-{{ $deliveryArea->id }}').submit(); return confirm('Are you sure to delete?')" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <form action="{{ route('admin.delivery.area.delete', $deliveryArea->id) }}" id="delete-{{ $deliveryArea->id }}" class="d-none" method="post">
                                                            @csrf
                                                            @method('DELETE')
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
                    <div class="card-footer border-top">
                         <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-end mb-0">
                                   <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                   <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                   <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                   <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                   <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                              </ul>
                         </nav>
                    </div>
               </div>
          </div>
     </div>

</div>

@endsection
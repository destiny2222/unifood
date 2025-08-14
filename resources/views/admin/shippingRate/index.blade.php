@extends('layouts.master')
@section('heading', 'Delivery Area')
@section('content')

<div class="container-xxl">

     <div class="row">
          <div class="col-xl-12">
               <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                         {{-- <h4 class="card-title flex-grow-1">All Categories List</h4> --}}

                         <a href="{{ route('admin.shipping.rate.create') }}" class="btn btn-sm btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i>  Add Shipping Rate
                         </a>
                    </div>
                    <div>
                        
                         <div class="table-responsive">
                              <table class="table align-middle mb-0 table-hover table-centered">
                                   <thead class="bg-light-subtle">
                                        <tr>
                                             <th> S/N </th>
                                             <th>Minimum Weight</th>
                                             <th>Maximum Weight</th>
                                             <th>Delivery Type</th>
                                             <th>Price</th>
                                             <th>Action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @foreach ($shippingRates as $rate)
                                        <tr>
                                             <td>
                                                 {{ $loop->index + 1 }}
                                             </td>
                                             <td>{{ $rate->min_weight }}</td>
                                             <td>
                                                {{ $rate->max_weight  }}
                                             </td>
                                             <td>
                                                {{ $rate->delivery_type  }}
                                             </td>
                                             <td>
                                                €{{ $rate->price  }}
                                             </td>
                                             <td>
                                                  <div class="d-flex gap-2">
                                                       {{-- <a href="#!" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a> --}}
                                                       <a href="{{ route('admin.shipping.rate.edit', $rate->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <a href="{{ route('admin.shipping.rate.delete', $rate->id) }}" onclick="event.preventDefault(); document.getElementById('delete-{{ $rate->id }}').submit(); return confirm('Are you sure to delete?')" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <form action="{{ route('admin.shipping.rate.delete', $rate->id) }}" id="delete-{{ $rate->id }}" class="d-none" method="post">
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
                         {{ $shippingRates->links() }}
                    </div>
               </div>
          </div>
     </div>

</div>

@endsection

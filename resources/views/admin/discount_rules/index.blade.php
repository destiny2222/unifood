@extends('layouts.master')
@section('heading', 'Discount Rules')
@section('content')
<div class="container-xxl">

     <div class="row">
          <div class="col-xl-12">
               <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                         <h4 class="card-title flex-grow-1">All Checkout Discount Rules (B2B Only)</h4>

                         <a href="{{ route('admin.discount-rules.create') }}" class="btn btn-sm btn-primary">
                              Add Discount Rule
                         </a>
                    </div>
                    <div>
                         <div class="table-responsive">
                              <table class="table align-middle mb-0 table-hover table-centered">
                                   <thead class="bg-light-subtle">
                                        <tr>
                                             <th>S/N</th>
                                             <th>Min Purchase Amount</th>
                                             <th>Discount Percentage</th>
                                             <th>Max Discount Cap</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @foreach ($discountRules as $rule)
                                        <tr>
                                             <td>{{ $loop->index + 1 }}</td>
                                             <td>£{{ number_format($rule->min_amount, 2) }}</td>
                                             <td>{{ $rule->discount_percentage }}%</td>
                                             <td>£{{ number_format($rule->max_discount_amount, 2) }}</td>
                                             <td>
                                                 @if($rule->is_active)
                                                     <span class="badge bg-success-subtle text-success px-2 py-1">Active</span>
                                                 @else
                                                     <span class="badge bg-danger-subtle text-danger px-2 py-1">Inactive</span>
                                                 @endif
                                             </td>
                                             <td>
                                                  <div class="d-flex gap-2">
                                                       <a href="{{ route('admin.discount-rules.edit', $rule->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <a href="{{ route('admin.discount-rules.delete', $rule->id) }}" onclick="event.preventDefault(); document.getElementById('delete-{{ $rule->id }}').submit(); return confirm('Are you sure to delete this discount rule?')" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <form action="{{ route('admin.discount-rules.delete', $rule->id) }}" id="delete-{{ $rule->id }}" class="d-none" method="post">
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
                     </div>
                     <div class="card-footer border-top">
                          {{ $discountRules->links() }}
                     </div>
                </div>
           </div>
     </div>

</div>
@endsection

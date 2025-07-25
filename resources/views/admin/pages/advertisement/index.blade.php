@extends('layouts.master')
@section('heading', 'Home Advertisement List')
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
                            Advertisement List
                        </h4>
                        <a href="{{ route('admin.advertisement.create') }}" class="btn btn-primary">Add  Advertisement</a>
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
                                           <th>Image</th>
                                           <th>Title</th>
                                           <th>Subtitle</th>
                                           <th>Description</th>
                                           <th>Action</th>
                                      </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($advertisements as $advertisement)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            <img src="{{ $advertisement->image }}" width="50px" height="50px" alt="">
                                        </td>
                                        <td>
                                            {{ $advertisement->title }}
                                        </td>
                                        <td>
                                            @if ($advertisement->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            {!! $advertisement->description !!}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.advertisement.edit', $advertisement->id)  }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <a href="{{ route('admin.advertisement.delete',$advertisement->id) }}" class="btn btn-soft-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-{{ $advertisement->id }}').submit() "><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <form action="{{ route('admin.advertisement.delete',$advertisement->id) }}" class="d-none" id="delete-{{ $advertisement->id }}" method="post">
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

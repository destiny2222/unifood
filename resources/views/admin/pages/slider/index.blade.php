@extends('layouts.master')
@section('heading', 'Home Slide List')
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
                            slider List
                        </h4>
                        <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">Add  Slide</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between g-3">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Image</th>
                                        <th>Title One</th>
                                        <th>Title Two</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Offer Text</th>
                                        <th>Link</th>
                                        <th>Serial</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slide)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <img src="{{ asset('upload/slider/'.$slide->image) }}" width="50px" height="50px" alt="">
                                        </td>
                                        <td>{{ $slide->title_one }}</td>
                                        <td>{{ $slide->title_two }}</td>
                                        <td>{!! $slide->description !!}</td>
                                        <td>
                                            @if($slide->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $slide->offer_text }}</td>
                                        <td>
                                            <a href="{{ $slide->link }}" target="_blank">{{ $slide->link }}</a>
                                        </td>
                                        <td>{{ $slide->serial }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.slider.edit', $slide->id)  }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <a href="{{ route('admin.slider.delete',$slide->id) }}" class="btn btn-soft-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-{{ $slide->id }}').submit() "><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <form action="{{ route('admin.slider.delete',$slide->id) }}" class="d-none" id="delete-{{ $slide->id }}" method="post">
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

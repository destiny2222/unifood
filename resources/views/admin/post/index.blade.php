@extends('layouts.master')
@section('heading', 'post List')
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
                            Post
                        </h4>
                        <a href="{{ route('admin.post.create') }}" class="btn btn-primary">Add  post</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between g-3">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                 <thead class="bg-light-subtle">
                                      <tr>
                                           <th>  S/N </th>
                                           <th>Image</th>
                                           <th>Title</th>
                                           <th>Category </th>
                                           <th>Show Homepage</th>
                                           <th>Status</th>
                                           <th>Description</th>
                                           <th>Action</th>
                                      </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($posts as $post)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td><img src="{{ asset('storage/upload/post/'.$post->image) }}" width="50" height="50" alt=""></td>
                                        <td>
                                            {{ $post->title }}
                                        </td>
                                        <td>
                                            {{ $post->category->title }}
                                        </td>
                                        <td>
                                            @if ($post->show_homepage == 1)
                                                <span class='badge bg-success '>Yes</span>
                                            @else
                                                 <span class='badge bg-danger '>No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($post->status == 1)
                                                <span class='badge bg-success '>Active</span>
                                            @else
                                                 <span class='badge bg-danger '>Inactive</span>
                                            @endif
                                        </td>
                                        <td>{!! \Str::limit($post->description, 200) !!}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.post.edit', $post->id)  }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <a href="{{ route('admin.post.delete',$post->id) }}" class="btn btn-soft-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-{{ $post->id }}').submit() "><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                <form action="{{ route('admin.post.delete',$post->id) }}" class="d-none" id="delete-{{ $post->id }}" method="post">
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

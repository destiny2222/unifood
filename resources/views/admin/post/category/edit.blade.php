@extends('layouts.master')
@section('heading', 'Edit Category')
@section('content')
<div class="container-xxl">

    <div class="row">
         <div class="col-xl-12 col-lg-12 ">
              <form action="{{ route('admin.post.category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Edit Category</h4>
                         </div>
                         <div class="card-body">
                              <div class="row">
                                   <div class="col-lg-12">
                                        <div class="mb-3">
                                             <label for="product-name" class="form-label">Category Name</label>
                                             <input type="text" id="product-name" name="title" value="{{ $category->title }}" class="form-control" placeholder="Items Name">
                                        </div>
                                   </div>
                                   {{-- <div class="col-lg-12">
                                        <div class="mb-3">
                                             <label for="product-name" class="form-label">Category Image</label>
                                             <input type="file" id="product-name" name="image" value="{{ $category->image }}" class="form-control">
                                        </div>
                                   </div> --}}
                              </div>
                         </div>
                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                         <div class="row justify-content-center g-2">
                              <div class="col-lg-12 text-center">
                                   <button type="submit"  class="btn btn-primary w-50">Update Category</button>
                              </div>
                         </div>
                    </div>
              </form>
         </div>
    </div>
</div>
@endsection
@extends('layouts.master')
@section('heading', 'Category List')
@section('content')
<div class="container-xxl">

     <div class="row">
          <div class="col-xl-12">
               <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                         <h4 class="card-title flex-grow-1">All Categories List</h4>

                         <a href="{{ route('admin.post.category.create') }}" class="btn btn-sm btn-primary">
                              Add Category
                         </a>
                    </div>
                    <div>
                         <div class="table-responsive">
                              <table class="table align-middle mb-0 table-hover table-centered">
                                   <thead class="bg-light-subtle">
                                        <tr>
                                             <th>
                                                  S/N
                                             </th>
                                             {{-- <th>Image</th> --}}
                                             <th>Category name</th>
                                             <th>Slug</th>
                                             <th>Action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @foreach ($categories as $category)
                                        <tr>
                                             <td>
                                                 {{ $loop->index + 1 }}
                                             </td>
                                             <td>
                                                  <p class="text-dark fw-medium fs-15 mb-0">{{ $category->title }}</p>
                                             </td>
                                             <td>
                                                {{ $category->slug }}
                                             </td>
                                             <td>
                                                  <div class="d-flex gap-2">
                                                       {{-- <a href="#!" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a> --}}
                                                       <a href="{{ route('admin.post.category.edit', $category->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <a href="{{ route('admin.post.category.delete', $category->id) }}" onclick="event.preventDefault(); document.getElementById('delete-{{ $category->id }}').submit(); return confirm('Are you sure to delete this category?')" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                       <form action="{{ route('admin.post.category.delete', $category->id) }}" id="delete-{{ $category->id }}" class="d-none" method="post">
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
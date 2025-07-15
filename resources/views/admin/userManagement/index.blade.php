@extends('layouts.master')
@section('heading', 'Customer List')
@section('content')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

@endpush
<!-- Start Container Fluid -->
<div class="container-xxl">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class=" d-flex justify-content-between">
                        <h4 class="card-title d-flex align-items-center gap-1">
                            <iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>
                            Customer List
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between g-3">
                        <div class="table-responsive">
                            <table id="customerTable" class="table align-middle mb-0 table-hover table-centered">
                                 <thead class="bg-light-subtle">
                                      <tr>
                                           <th>
                                               S/N
                                           </th>
                                           <th>Image</th>
                                           <th>Name</th>
                                           <th>Email </th>
                                           <th>Phone</th>
                                      </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('images/profile/'.$user->profile_picture) }}" width="50px" height="50px" alt="">
                                        </td>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            {{ $user->phone }}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                 </tbody>
                            </table>
                       </div>
                       <!-- end table-responsive -->
                    </div>
                </div>
                {{-- <div class="card-footer border-top">
                    @if ($users->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mb-0">
                            <!-- Previous Page Link -->
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif
                
                            <!-- Pagination Elements -->
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                @if ($page == $users->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                
                            <!-- Next Page Link -->
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
                   </div> --}}
            </div>
        </div>
    </div>
</div>
<!-- End Container Fluid -->
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        text: 'Download CSV',
                        exportOptions: {
                            columns: [0, 2, 3, 4] // exclude the image column (1)
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Download PDF',
                        exportOptions: {
                            columns: [0, 2, 3, 4]
                        },
                        orientation: 'portrait',
                        pageSize: 'A4'
                    }
                ]
            });
        });
    </script>

@endpush

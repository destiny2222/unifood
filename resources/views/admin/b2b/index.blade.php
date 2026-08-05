@extends('layouts.master')
@section('heading', 'B2B Trade Applications')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class=" d-flex justify-content-between">
                        <h4 class="card-title d-flex align-items-center gap-1">
                            <iconify-icon icon="solar:shield-keyhole-bold-duotone" class="text-primary fs-20"></iconify-icon>
                            B2B Trade Applications List
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between g-3">
                        <div class="table-responsive">
                            <table id="b2bTable" class="table align-middle mb-0 table-hover table-centered">
                                 <thead class="bg-light-subtle">
                                      <tr>
                                           <th>S/N</th>
                                           <th>Applicant</th>
                                           <th>Email</th>
                                           <th>Company Name</th>
                                           <th>Business Type</th>
                                           <th>Status</th>
                                           <th>Tier</th>
                                           <th>Actions</th>
                                      </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($applications as $app)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $app->user->name ?? 'N/A' }}</td>
                                        <td>{{ $app->user->email ?? 'N/A' }}</td>
                                        <td>{{ $app->company_name }}</td>
                                        <td><span class="text-capitalize">{{ $app->business_type }}</span></td>
                                        <td>
                                            @if($app->status === 'approved')
                                                <span class="badge bg-success-subtle text-success px-2 py-1">Approved</span>
                                            @elseif($app->status === 'rejected')
                                                <span class="badge bg-danger-subtle text-danger px-2 py-1">Rejected</span>
                                            @elseif($app->status === 'info_requested')
                                                <span class="badge bg-warning-subtle text-warning px-2 py-1">Info Requested</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1 text-uppercase">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $app->pricing_tier }}</td>
                                        <td>
                                            <a href="{{ route('admin.b2b.applications.show', $app->id) }}" class="btn btn-sm btn-outline-primary">
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                            </table>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

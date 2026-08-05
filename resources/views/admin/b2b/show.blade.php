@extends('layouts.master')
@section('heading', 'Review B2B Trade Application')
@section('content')
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
        <!-- Application Details -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">Application Details</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 40%">Applicant Name</th>
                                <td>{{ $application->user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Applicant Email</th>
                                <td>{{ $application->user->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Company Name</th>
                                <td>{{ $application->company_name }}</td>
                            </tr>
                            <tr>
                                <th>Company Reg/VAT Number</th>
                                <td><code>{{ $application->company_registration_number }}</code></td>
                            </tr>
                            <tr>
                                <th>Business Type</th>
                                <td><span class="badge bg-secondary-subtle text-dark text-capitalize">{{ $application->business_type }}</span></td>
                            </tr>
                            <tr>
                                <th>Trade Address</th>
                                <td>{{ $application->trade_address }}</td>
                            </tr>
                            <tr>
                                <th>Billing Contact</th>
                                <td>{{ $application->billing_contact }}</td>
                            </tr>
                            <tr>
                                <th>Estimated Monthly Volume</th>
                                <td>{{ $application->estimated_monthly_order_volume }}</td>
                            </tr>
                            <tr>
                                <th>Current Status</th>
                                <td>
                                    @if($application->status === 'approved')
                                        <span class="badge bg-success text-white">Approved</span>
                                    @elseif($application->status === 'rejected')
                                        <span class="badge bg-danger text-white">Rejected</span>
                                    @elseif($application->status === 'info_requested')
                                        <span class="badge bg-warning text-dark">Info Requested</span>
                                    @else
                                        <span class="badge bg-secondary text-white text-uppercase">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Pricing Tier</th>
                                <td><span class="fw-bold">{{ $application->pricing_tier }}</span></td>
                            </tr>
                            @if($application->status_notes)
                            <tr>
                                <th>Status Notes</th>
                                <td class="text-danger bg-light p-2 rounded">{{ $application->status_notes }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <a href="{{ route('admin.b2b.applications.index') }}" class="btn btn-outline-secondary">
                            Back to Applications
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Controls -->
        <div class="col-lg-6">
            <!-- Approve Form -->
            <div class="card mb-4 border-success-subtle border">
                <div class="card-header bg-success-subtle">
                    <h5 class="card-title text-success mb-0">Approve Application</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.b2b.applications.action', $application->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="approve">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Assign Pricing Tier</label>
                            <select name="pricing_tier" class="form-control" required>
                                <option value="Wholesale Tier 1" {{ $application->pricing_tier === 'Wholesale Tier 1' ? 'selected' : '' }}>Wholesale Tier 1 (0% default discount)</option>
                                <option value="Bronze" {{ $application->pricing_tier === 'Bronze' ? 'selected' : '' }}>Bronze (10% discount)</option>
                                <option value="Silver" {{ $application->pricing_tier === 'Silver' ? 'selected' : '' }}>Silver (20% discount)</option>
                                <option value="Gold" {{ $application->pricing_tier === 'Gold' ? 'selected' : '' }}>Gold (30% discount)</option>
                            </select>
                            <small class="text-muted d-block mt-1">
                                Tiers apply a percentage discount on standard retail product prices.
                            </small>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            Approve Trade Account
                        </button>
                    </form>
                </div>
            </div>

            <!-- More Info / Reject Form -->
            <div class="card border-warning-subtle border">
                <div class="card-header bg-warning-subtle">
                    <h5 class="card-title text-warning-emphasis mb-0">Request Information / Reject</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.b2b.applications.action', $application->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Notes / Explanation</label>
                            <textarea name="status_notes" class="form-control" rows="4" placeholder="Describe the reason for rejection or details requested..." required></textarea>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="submit" name="action" value="request_info" class="btn btn-warning w-100 text-dark">
                                    Request More Info
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" name="action" value="reject" class="btn btn-danger w-100">
                                    Reject Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

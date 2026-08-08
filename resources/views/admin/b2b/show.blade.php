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
        <!-- Application Details (6 Sections) -->
        <div class="col-lg-8">

            <!-- Card: Verification Overview -->
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Business Verification Form</h4>
                    <div>
                        @if($application->status === 'approved')
                            <span class="badge bg-success fs-6 text-white">Approved</span>
                        @elseif($application->status === 'rejected')
                            <span class="badge bg-danger fs-6 text-white">Rejected</span>
                        @elseif($application->status === 'info_requested')
                            <span class="badge bg-warning fs-6 text-dark">Info Requested</span>
                        @else
                            <span class="badge bg-secondary fs-6 text-white text-uppercase">Pending Review</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <span class="text-muted small d-block">Applicant User</span>
                            <span class="fw-semibold">{{ $application->user->name ?? 'N/A' }}</span> ({{ $application->user->email ?? 'N/A' }})
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">Pricing Tier</span>
                            <span class="badge bg-primary text-white fs-6">{{ $application->pricing_tier }}</span>
                        </div>
                        @if($application->status_notes)
                        <div class="col-12">
                            <div class="alert alert-danger mb-0">
                                <strong>Status Notes / Feedback:</strong> {{ $application->status_notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section 1 – Business Information -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-primary">Section 1 – Business Information</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Registered Business Name</th>
                                    <td class="fw-semibold">{{ $application->company_name }}</td>
                                </tr>
                                <tr>
                                    <th>Trading Name</th>
                                    <td>{{ $application->trading_name ?: 'N/A (Same as registered)' }}</td>
                                </tr>
                                <tr>
                                    <th>Business Type</th>
                                    <td><span class="badge bg-info-subtle text-dark text-capitalize fs-6">{{ str_replace('_', ' ', $application->business_type) }}</span></td>
                                </tr>
                                <tr>
                                    <th>Company Registration Number</th>
                                    <td><code>{{ $application->company_registration_number ?: 'N/A' }}</code></td>
                                </tr>
                                <tr>
                                    <th>VAT Registration Number</th>
                                    <td><code>{{ $application->vat_registration_number ?: 'N/A' }}</code></td>
                                </tr>
                                <tr>
                                    <th>Date Business Established</th>
                                    <td>{{ $application->date_business_established ? \Carbon\Carbon::parse($application->date_business_established)->format('d M Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Nature of Business / Industry</th>
                                    <td>{{ $application->nature_of_business ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Business Website</th>
                                    <td>
                                        @if($application->business_website)
                                            <a href="{{ Str::startsWith($application->business_website, ['http://', 'https://']) ? $application->business_website : 'https://' . $application->business_website }}" target="_blank">
                                                {{ $application->business_website }} <i class="bx bx-link-external"></i>
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section 2 – Registered Business Address -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-primary">Section 2 – Registered Business Address</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Full Trade Address</th>
                                    <td>{{ $application->trade_address }}</td>
                                </tr>
                                <tr>
                                    <th>Address Line 1</th>
                                    <td>{{ $application->address_line_1 ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address Line 2</th>
                                    <td>{{ $application->address_line_2 ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>City / Postcode</th>
                                    <td>{{ array_filter([$application->city, $application->postcode]) ? implode(', ', array_filter([$application->city, $application->postcode])) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $application->country ?: 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section 3 – Primary Contact Details -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-primary">Section 3 – Primary Contact Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Full Name</th>
                                    <td>{{ $application->primary_contact_name ?: ($application->billing_contact ?: 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>Position / Job Title</th>
                                    <td>{{ $application->primary_contact_position ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Business Email</th>
                                    <td>
                                        @if($application->primary_contact_email)
                                            <a href="mailto:{{ $application->primary_contact_email }}">{{ $application->primary_contact_email }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Telephone Number</th>
                                    <td>{{ $application->primary_contact_phone ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Preferred Contact Method</th>
                                    <td><span class="badge bg-secondary text-white text-uppercase">{{ $application->preferred_contact_method ?: 'email' }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section 4 – Business Ownership / Responsible Person -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-primary">Section 4 – Business Ownership / Responsible Person</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Owner / Director Name</th>
                                    <td>{{ $application->owner_full_name ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Position</th>
                                    <td>{{ $application->owner_position ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Nationality</th>
                                    <td>{{ $application->owner_nationality ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ $application->owner_dob ? \Carbon\Carbon::parse($application->owner_dob)->format('d M Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Residential Address</th>
                                    <td>{{ $application->owner_residential_address ?: 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section 5 – Business Verification Documents -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-primary">Section 5 – Business Verification Documents</h5>
                </div>
                <div class="card-body">
                    @php
                        $docList = [
                            'Certificate of Incorporation' => $application->certificate_of_incorporation,
                            'Proof of Business Address' => $application->proof_of_business_address,
                            'VAT Registration Certificate' => $application->vat_registration_certificate,
                            'Business Bank Statement' => $application->business_bank_statement,
                            'Government-issued ID for Director / Owner' => $application->government_id,
                            'Proof of Residential Address' => $application->proof_of_residential_address,
                            'Partnership Agreement' => $application->partnership_agreement,
                            'Sole Trader Registration / HMRC Evidence' => $application->sole_trader_evidence,
                        ];
                    @endphp
                    <div class="list-group list-group-flush">
                        @foreach($docList as $label => $path)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <i class="bx bx-file-blank text-muted me-2"></i>
                                    <span class="fw-medium">{{ $label }}</span>
                                </div>
                                <div>
                                    @if($path)
                                        @php
                                            $url = Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/' . $path);
                                        @endphp
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-download me-1"></i> View / Download
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted">Not Provided</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if(!empty($application->other_documents) && is_array($application->other_documents))
                            @foreach($application->other_documents as $idx => $otherPath)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="bx bx-paperclip text-muted me-2"></i>
                                        <span class="fw-medium">Additional Document #{{ $idx + 1 }}</span>
                                    </div>
                                    <div>
                                        @php
                                            $url = Str::startsWith($otherPath, ['http://', 'https://']) ? $otherPath : asset('storage/' . $otherPath);
                                        @endphp
                                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-download me-1"></i> View / Download
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section 6 – Business Purchasing Information -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-primary">Section 6 – Business Purchasing Information</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Primary Products of Interest</th>
                                    <td>{{ $application->primary_products_of_interest ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Estimated Monthly Purchase Value</th>
                                    <td><span class="fw-bold text-success">{{ $application->estimated_monthly_order_volume }}</span></td>
                                </tr>
                                <tr>
                                    <th>Expected Order Frequency</th>
                                    <td><span class="badge bg-secondary-subtle text-dark text-capitalize">{{ str_replace('_', ' ', $application->expected_order_frequency ?: 'Ad hoc') }}</span></td>
                                </tr>
                                <tr>
                                    <th>Purpose of Purchase</th>
                                    <td><span class="badge bg-info-subtle text-dark text-capitalize">{{ str_replace('_', ' ', $application->purpose_of_purchase ?: 'N/A') }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <a href="{{ route('admin.b2b.applications.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to Applications
                </a>
            </div>

        </div>

        <!-- Action Controls (Right Column) -->
        <div class="col-lg-4">
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

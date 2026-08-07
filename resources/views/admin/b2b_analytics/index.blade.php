@extends('layouts.master')
@section('heading', 'B2B Analytics Dashboard')
@section('content')
<div class="container-xxl">

    <!-- Overview Stats Cards -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-medium text-uppercase fs-12">B2B Sales Revenue</span>
                            <h3 class="text-dark mb-0 mt-2">£{{ number_format($totalB2BRevenue, 2) }}</h3>
                        </div>
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-success-subtle text-success rounded fs-22">
                                <i class="bx bx-pound fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-medium text-uppercase fs-12">Total Purchase Orders</span>
                            <h3 class="text-dark mb-0 mt-2">{{ number_format($totalB2BOrders) }}</h3>
                        </div>
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded fs-22">
                                <i class="bx bx-shopping-bag fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-medium text-uppercase fs-12">Approved Merchants</span>
                            <h3 class="text-dark mb-0 mt-2">{{ number_format($merchantStats['approved']) }}</h3>
                            <small class="text-muted">{{ number_format($merchantStats['pending']) }} pending applications</small>
                        </div>
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded fs-22">
                                <i class="bx bx-group fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-medium text-uppercase fs-12">Active B2B Products</span>
                            <h3 class="text-dark mb-0 mt-2">{{ number_format($totalB2BProducts) }}</h3>
                        </div>
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded fs-22">
                                <i class="bx bx-package fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- July Analytics Chart Section -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">July 2026 Activity: Daily Orders & Registered Users</h4>
                    <span class="badge bg-primary-subtle text-primary fs-12">July 2026</span>
                </div>
                <div class="card-body">
                    <div style="height: 340px; position: relative;">
                        <canvas id="julyAnalyticsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Status Breakdown -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">B2B Order Status Overview</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3 border-end">
                            <div class="p-2">
                                <h4 class="text-warning mb-1">{{ number_format($statusCounts['pending']) }}</h4>
                                <span class="text-muted fs-13">Pending</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 border-end">
                            <div class="p-2">
                                <h4 class="text-info mb-1">{{ number_format($statusCounts['approved']) }}</h4>
                                <span class="text-muted fs-13">Processing</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 border-end">
                            <div class="p-2">
                                <h4 class="text-success mb-1">{{ number_format($statusCounts['completed']) }}</h4>
                                <span class="text-muted fs-13">Completed</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-2">
                                <h4 class="text-danger mb-1">{{ number_format($statusCounts['cancelled']) }}</h4>
                                <span class="text-muted fs-13">Cancelled</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Merchant Application Overview -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Merchant Applications</h4>
                    <a href="{{ route('admin.b2b.applications.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <div class="p-2">
                                <h4 class="text-success mb-1">{{ number_format($merchantStats['approved']) }}</h4>
                                <span class="text-muted fs-13">Approved</span>
                            </div>
                        </div>
                        <div class="col-4 border-end">
                            <div class="p-2">
                                <h4 class="text-warning mb-1">{{ number_format($merchantStats['pending']) }}</h4>
                                <span class="text-muted fs-13">Pending</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2">
                                <h4 class="text-danger mb-1">{{ number_format($merchantStats['rejected']) }}</h4>
                                <span class="text-muted fs-13">Rejected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Purchase Orders Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="card-title">Recent B2B Purchase Orders</h4>
                    <a href="{{ route('admin.b2b-orders.index') }}" class="btn btn-sm btn-primary">View Orders</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th>PO Number</th>
                                    <th>Ref ID</th>
                                    <th>Date</th>
                                    <th>Merchant Company</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $order)
                                <tr>
                                    <td><span class="fw-medium">{{ $order->po_number ?? 'N/A' }}</span></td>
                                    <td><a href="{{ route('admin.b2b-orders.show', $order->id) }}">{{ $order->internal_reference }}</a></td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $order->user->name ?? 'Guest' }}</span>
                                        @if($order->user && $order->user->kyc)
                                            <small class="text-muted d-block">{{ $order->user->kyc->company_name }} (Tier: {{ $order->user->kyc->pricing_tier ?? 'Standard' }})</small>
                                        @endif
                                    </td>
                                    <td>£{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @if(in_array(strtolower($order->status), ['completed', 'delivered']))
                                            <span class="badge bg-success-subtle text-success px-2 py-1">{{ ucwords($order->status) }}</span>
                                        @elseif(in_array(strtolower($order->status), ['approved', 'processing', 'invoiced']))
                                            <span class="badge bg-info-subtle text-info px-2 py-1">{{ ucwords($order->status) }}</span>
                                        @elseif(in_array(strtolower($order->status), ['pending', 'submitted']))
                                            <span class="badge bg-warning-subtle text-warning px-2 py-1">{{ ucwords($order->status) }}</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1">{{ ucwords($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.b2b-orders.show', $order->id) }}" class="btn btn-sm btn-light">View Details</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No recent B2B orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('julyAnalyticsChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($julyDays) !!},
                datasets: [
                    {
                        label: 'Daily B2B Orders',
                        data: {!! json_encode($julyOrdersData) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.15)',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Registered Users / Merchants',
                        data: {!! json_encode($julyUsersData) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.15)',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        });
    }
});
</script>
@endpush

@extends('layouts.master')
@section('heading', 'System Management')
@section('content')
<!-- Start Container Fluid -->
<div class="container-xxl">
    <div class="row">

        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 anchor" id="outline">
                       Cache Management
                    </h5>
                    <div class="mb-3">
                        <div class="button-list">
                            <form action="{{ route('admin.system.clear-all-cache') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Clear all caches?')">
                                    Clear All Caches
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.system.clear-app-cache') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-info">Clear App Cache</button>
                            </form>
                            
                            <form action="{{ route('admin.system.clear-config-cache') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-info">Clear Config Cache</button>
                            </form>
                            
                            <form action="{{ route('admin.system.clear-route-cache') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-info">Clear Route Cache</button>
                            </form>
                            
                            <form action="{{ route('admin.system.clear-view-cache') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-info">Clear View Cache</button>
                            </form>
                        </div>
                    </div>
                </div> <!-- end card body -->
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 anchor" id="outline">
                        System Optimization 
                    </h5>
                    <div class="mb-3">
                        <div class="button-list">
                            <form action="{{ route('admin.system.optimize') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Optimize application?')">
                                    Optimize Application
                                </button>
                            </form>
                        </div>
                    </div>
                    <p><small>This will cache config, routes, and views for better performance.</small></p>
                </div> <!-- end card body -->
            </div>
        </div>
       
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 anchor" id="outline">
                        Log Management
                    </h5>
                    <div class="mb-3">
                        <div class="button-list">
                            <form action="{{ route('admin.system.clear-logs') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to clear all logs?')">
                                    Clear All Logs
                                </button>
                            </form>
                            <p><small>This will delete all log files from storage/logs directory.</small></p>
                        </div>
                    </div>
                </div> <!-- end card body -->
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 anchor" id="outline">
                        System Information
                    </h5>
                    <div class="mb-3 ">
                        <a href="{{ route('admin.system.index') }}" class="btn btn-primary">Refresh System Info</a>
                        <div class="table-responsive mt-5">
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>PHP Version:</strong></td>
                                    <td>{{ $systemInfo['php_version'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Laravel Version:</strong></td>
                                    <td>{{ $systemInfo['laravel_version'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Memory Usage:</strong></td>
                                    <td>{{ number_format($systemInfo['memory_usage'] / 1024 / 1024, 2) }} MB</td>
                                </tr>
                                <tr>
                                    <td><strong>Memory Peak:</strong></td>
                                    <td>{{ number_format($systemInfo['memory_peak'] / 1024 / 1024, 2) }} MB</td>
                                </tr>
                                <tr>
                                    <td><strong>Cache Driver:</strong></td>
                                    <td>{{ $systemInfo['cache_driver'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Session Driver:</strong></td>
                                    <td>{{ $systemInfo['session_driver'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Queue Driver:</strong></td>
                                    <td>{{ $systemInfo['queue_driver'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div> <!-- end card body -->
            </div>
        </div>
    </div>
</div>
@endsection

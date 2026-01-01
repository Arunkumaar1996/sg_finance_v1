@extends('layouts.app_new')

@section('title', 'Dashboard - HR Management System')

@section('page-title', 'Dashboard Overview')
@section('page-description', 'Welcome back! Here\'s what\'s happening today.')

@section('breadcrumb-current', 'Dashboard')

@section('page-actions')
    <button class="btn btn-outline-primary">
        <i class="bi bi-download me-2"></i> Export
    </button>
    <button class="btn btn-primary">
        <i class="bi bi-plus me-2"></i> Add New
    </button>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card fade-in">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="rounded-circle bg-primary-light p-3">
                            <i class="bi bi-people text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-label">Total Employees</div>
                        <div class="stat-value">1,254</div>
                        <div class="text-success fw-medium" style="font-size: 13px;">
                            <i class="bi bi-arrow-up"></i> 12% from last month
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add more stats cards as needed -->
    </div>
    
    <!-- Main Content -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Attendance Overview</h5>
                        <select class="form-select form-select-sm w-auto">
                            <option>This Week</option>
                            <option>This Month</option>
                            <option>This Year</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Your chart content here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Dashboard specific scripts
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
    });
</script>
@endsection
@extends('layouts.app_new')

@section('title', 'Dashboard - HR Management System')

@section('page-title', 'Dashboard')
@section('page-description', 'Overview and key metrics')

@section('breadcrumb-current', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <style>
            .stat-card {
                border-radius: 8px;
                border: 1px solid #e9ecef;
                transition: all 0.3s ease;
                overflow: hidden;
            }
            
            .stat-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            }
            
            .stat-icon {
                width: 48px;
                height: 48px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
            }
            
            .stat-value {
                font-size: 24px;
                font-weight: 700;
                line-height: 1;
            }
            
            .stat-label {
                font-size: 12px;
                color: #6c757d;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-top: 4px;
            }
            
            .stat-change {
                font-size: 11px;
                font-weight: 600;
            }
            
            .stat-change.positive {
                color: #28a745;
            }
            
            .stat-change.negative {
                color: #dc3545;
            }
            
            .chart-container {
                background: white;
                border-radius: 8px;
                border: 1px solid #e9ecef;
                padding: 15px;
            }
            
            .recent-item {
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
                transition: background 0.2s;
            }
            
            .recent-item:hover {
                background: #f8f9fa;
            }
            
            .recent-item:last-child {
                border-bottom: none;
            }
            
            .status-badge {
                padding: 4px 10px;
                border-radius: 12px;
                font-size: 11px;
                font-weight: 600;
            }
            
            .badge-pending {
                background: rgba(108, 117, 125, 0.1);
                color: #6c757d;
                border: 1px solid rgba(108, 117, 125, 0.2);
            }
            
            .badge-in_review {
                background: rgba(255, 193, 7, 0.1);
                color: #ffc107;
                border: 1px solid rgba(255, 193, 7, 0.2);
            }
            
            .badge-approved {
                background: rgba(40, 167, 69, 0.1);
                color: #28a745;
                border: 1px solid rgba(40, 167, 69, 0.2);
            }
            
            .badge-rejected {
                background: rgba(220, 53, 69, 0.1);
                color: #dc3545;
                border: 1px solid rgba(220, 53, 69, 0.2);
            }
            
            .attendance-status {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                display: inline-block;
                margin-right: 6px;
            }
            
            .status-present { background: #28a745; }
            .status-late { background: #ffc107; }
            .status-absent { background: #dc3545; }
            
            .quick-stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 12px;
                margin-bottom: 20px;
            }
            
            @media (max-width: 768px) {
                .quick-stats {
                    grid-template-columns: repeat(2, 1fr);
                }
                
                .stat-value {
                    font-size: 20px;
                }
                
                .stat-icon {
                    width: 40px;
                    height: 40px;
                    font-size: 18px;
                }
            }
        </style>

        <!-- Quick Stats Row -->
        <div class="quick-stats">
            <!-- Contact Submissions Card -->
            <div class="stat-card">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value text-primary">{{ $totalSubmissions }}</div>
                            <div class="stat-label">Total Submissions</div>
                            <div class="stat-change positive mt-1">
                                <i class="bi bi-arrow-up me-1"></i> {{ $todaySubmissions }} today
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1); color: #007bff;">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pending Submissions Card -->
            <div class="stat-card">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value text-warning">{{ $pendingSubmissions }}</div>
                            <div class="stat-label">Pending Reviews</div>
                            <div class="stat-change mt-1">
                                Needs attention
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Approved Submissions Card -->
            <div class="stat-card">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value text-success">{{ $approvedSubmissions }}</div>
                            <div class="stat-label">Approved</div>
                            <div class="stat-change positive mt-1">
                                <i class="bi bi-check-circle me-1"></i> Processed
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Employees Card -->
            <div class="stat-card">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value text-info">{{ $totalEmployees }}</div>
                            <div class="stat-label">Total Employees</div>
                            <div class="stat-change mt-1">
                                <i class="bi bi-people me-1"></i> Active
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Today's Present Card -->
            <div class="stat-card">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value text-success">{{ $todayPresent }}</div>
                            <div class="stat-label">Present Today</div>
                            <div class="stat-change mt-1">
                                {{ $totalEmployees > 0 ? round(($todayPresent / $totalEmployees) * 100, 1) : 0 }}% attendance
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Today's Absent Card -->
            <div class="stat-card">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value text-danger">{{ $todayAbsent }}</div>
                            <div class="stat-label">Absent Today</div>
                            <div class="stat-change negative mt-1">
                                Needs follow-up
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <!-- Left Column: Charts -->
            <div class="col-lg-8">
                <div class="row g-3">
                    <!-- Submissions Chart -->
                    <div class="col-md-6">
                        <div class="chart-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold">Submissions Trend (7 days)</h6>
                                <span class="badge bg-light text-dark">Daily</span>
                            </div>
                            <div style="height: 200px;">
                                <canvas id="submissionsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Loan Type Distribution -->
                    <div class="col-md-6">
                        <div class="chart-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold">Loan Type Distribution</h6>
                                <span class="badge bg-light text-dark">Top 5</span>
                            </div>
                            <div style="height: 200px;">
                                <canvas id="loanTypeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Attendance Distribution -->
                    <div class="col-12">
                        <div class="chart-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold">Monthly Attendance Overview</h6>
                                <span class="badge bg-light text-dark">{{ date('F Y') }}</span>
                            </div>
                            <div style="height: 200px;">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Recent Activity -->
            <div class="col-lg-4">
                <div class="row g-3">
                    <!-- Recent Submissions -->
                    <div class="col-12">
                        <div class="chart-container h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold">Recent Submissions</h6>
                                <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-sm btn-link">View All</a>
                            </div>
                            <div style="max-height: 250px; overflow-y: auto;">
                                @if($recentSubmissions->count() > 0)
                                    @foreach($recentSubmissions as $submission)
                                        <div class="recent-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="fw-semibold mb-1">{{ $submission->name }}</div>
                                                    <div class="small text-muted">
                                                        {{ $submission->loan_type }} • ₹{{ number_format($submission->loan_amount) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    @php
                                                        $badgeClass = 'badge-' . $submission->status;
                                                    @endphp
                                                    <span class="status-badge {{ $badgeClass }}">
                                                        {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="small text-muted mt-1">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $submission->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-inbox text-muted fs-1 mb-2"></i>
                                        <p class="text-muted mb-0">No recent submissions</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Today's Attendance -->
                    <div class="col-12">
                        <div class="chart-container h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold">Today's Attendance</h6>
                                <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-link">Mark All</a>
                            </div>
                            <div style="max-height: 250px; overflow-y: auto;">
                                @if($todaysAttendance->count() > 0)
                                    @foreach($todaysAttendance as $attendance)
                                        <div class="recent-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="fw-semibold mb-1">{{ $attendance->user->name ?? 'N/A' }}</div>
                                                    <div class="small text-muted">
                                                        @if($attendance->check_in)
                                                            Check-in: {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                                                        @else
                                                            No check-in time
                                                        @endif
                                                    </div>
                                                </div>
                                                <div>
                                                    @if($attendance->status == 'present')
                                                        <span class="status-badge badge-approved">
                                                            <span class="attendance-status status-present"></span>
                                                            Present
                                                        </span>
                                                    @elseif($attendance->status == 'late')
                                                        <span class="status-badge badge-in_review">
                                                            <span class="attendance-status status-late"></span>
                                                            Late
                                                        </span>
                                                    @elseif($attendance->status == 'absent')
                                                        <span class="status-badge badge-rejected">
                                                            <span class="attendance-status status-absent"></span>
                                                            Absent
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-calendar-x text-muted fs-1 mb-2"></i>
                                        <p class="text-muted mb-0">No attendance marked today</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Stats Row -->
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center p-3">
                        <div class="text-primary mb-1">
                            <i class="bi bi-envelope fs-4"></i>
                        </div>
                        <div class="fw-bold fs-5">{{ $totalSubmissions }}</div>
                        <div class="text-muted small">Total Submissions</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center p-3">
                        <div class="text-success mb-1">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                        <div class="fw-bold fs-5">{{ $approvedSubmissions }}</div>
                        <div class="text-muted small">Approved</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center p-3">
                        <div class="text-warning mb-1">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                        <div class="fw-bold fs-5">{{ $pendingSubmissions }}</div>
                        <div class="text-muted small">Pending Review</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center p-3">
                        <div class="text-info mb-1">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div class="fw-bold fs-5">{{ $totalEmployees }}</div>
                        <div class="text-muted small">Total Employees</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Initialize all charts
    
    // 1. Submissions Trend Chart (Line Chart)
    const submissionsCtx = document.getElementById('submissionsChart').getContext('2d');
    const submissionsChart = new Chart(submissionsCtx, {
        type: 'line',
        data: {
            labels: @json(array_column($submissionChartData, 'date')),
            datasets: [{
                label: 'Submissions',
                data: @json(array_column($submissionChartData, 'count')),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // 2. Loan Type Distribution Chart (Doughnut)
    const loanTypeCtx = document.getElementById('loanTypeChart').getContext('2d');
    const loanTypeChart = new Chart(loanTypeCtx, {
        type: 'doughnut',
        data: {
            labels: @json($loanTypeDistribution->pluck('loan_type')),
            datasets: [{
                data: @json($loanTypeDistribution->pluck('count')),
                backgroundColor: [
                    '#007bff',
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#6c757d'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                }
            },
            cutout: '70%'
        }
    });
    
    // 3. Attendance Distribution Chart (Bar Chart)
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(attendanceCtx, {
        type: 'bar',
        data: {
            labels: ['Present', 'Late', 'Absent'],
            datasets: [{
                label: 'Count',
                data: [
                    {{ $monthlyAttendance['present'] ?? 0 }},
                    {{ $monthlyAttendance['late'] ?? 0 }},
                    {{ $monthlyAttendance['absent'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(220, 53, 69, 0.7)'
                ],
                borderColor: [
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Auto-refresh dashboard every 5 minutes
    setInterval(function() {
        $.ajax({
            url: '{{ route("dashboard.refresh") }}',
            method: 'GET',
            success: function(response) {
                // Update stats cards
                $('.stat-value').eq(0).text(response.totalSubmissions);
                $('.stat-value').eq(1).text(response.pendingSubmissions);
                $('.stat-value').eq(2).text(response.approvedSubmissions);
                $('.stat-value').eq(4).text(response.todayPresent);
                $('.stat-value').eq(5).text(response.todayAbsent);
                
                // Show refresh notification
                showToast('success', 'Dashboard data refreshed');
            },
            error: function() {
                console.log('Failed to refresh dashboard');
            }
        });
    }, 300000); // 5 minutes
    
    // Toast notification function
    function showToast(type, message) {
        const toastId = 'toast-' + Date.now();
        const $toast = $(`
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-info-circle me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);
        
        $('body').append($toast);
        const bsToast = new bootstrap.Toast($toast[0], { delay: 3000 });
        bsToast.show();
        
        $toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
    
    // Add click effects to stat cards
    $('.stat-card').on('click', function() {
        $(this).addClass('clicked');
        setTimeout(() => {
            $(this).removeClass('clicked');
        }, 300);
    });
});
</script>
@endsection
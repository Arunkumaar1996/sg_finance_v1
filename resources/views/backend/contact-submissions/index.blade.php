@extends('layouts.app_new')

@section('title', 'Contact Submissions - Management System')

@section('page-title', 'Contact Submissions')
@section('page-description', 'Manage loan inquiry submissions from customers')

@section('breadcrumb-current', 'Contact Submissions')

@section('page-actions')
    {{-- <button class="btn btn-outline-primary" onclick="exportSubmissions()">
        <i class="bi bi-download me-2"></i> Export
    </button> --}}
    <button class="btn btn-primary" onclick="refreshData()">
        <i class="bi bi-arrow-clockwise me-2"></i> Refresh
    </button>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Custom Styles -->
        <style>
            .submission-card {
                border-left: 4px solid #022142ff;
                transition: all 0.3s ease;
            }

            .submission-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .badge.bg-pending {
                background-color: #6c757d !important;
                color: white !important;
            }

            .badge.bg-in_review {
                background-color: #ffc107 !important;
                color: #000 !important;
            }

            .badge.bg-approved {
                background-color: #28a745 !important;
                color: white !important;
            }

            .badge.bg-rejected {
                background-color: #dc3545 !important;
                color: white !important;
            }

            .table tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
            }

            .card-header {
                background: linear-gradient(135deg, #007bff 0%, #022142ff 100%) !important;
                color: white !important;
            }

            .status-pill {
                cursor: pointer;
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.3s ease;
                border: 2px solid;
                display: inline-flex;
                align-items: center;
                text-decoration: none;
            }

            .status-pill.active {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                transform: translateY(-2px);
            }

            .status-pill:hover:not(.active) {
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            /* Active states for each status */
            .status-pill.active.btn-primary {
                background: linear-gradient(135deg, #022142ff 0%, #007bff 100%) !important;
                border-color: #022142ff !important;
                color: white !important;
            }

            .status-pill.active.btn-secondary {
                background: linear-gradient(135deg, #495057 0%, #6c757d 100%) !important;
                border-color: #495057 !important;
                color: white !important;
            }

            .status-pill.active.btn-warning {
                background: linear-gradient(135deg, #e0a800 0%, #ffc107 100%) !important;
                border-color: #e0a800 !important;
                color: #000 !important;
            }

            .status-pill.active.btn-success {
                background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%) !important;
                border-color: #1e7e34 !important;
                color: white !important;
            }

            .status-pill.active.btn-danger {
                background: linear-gradient(135deg, #bd2130 0%, #dc3545 100%) !important;
                border-color: #bd2130 !important;
                color: white !important;
            }

            .status-pill .badge {
                font-size: 11px;
                padding: 3px 6px;
                border-radius: 10px;
                font-weight: 600;
            }

            /* Status indicators */
            .status-indicator {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                display: inline-block;
            }

            /* Action buttons */
            .action-btn {
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 6px;
                margin: 0 2px;
            }

            /* Loader */
            .loader {
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid #022142ff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Mobile optimizations */
            @media (max-width: 768px) {
                .card-body {
                    padding: 0.75rem;
                }

                .btn-sm {
                    padding: 0.2rem 0.4rem;
                    font-size: 0.75rem;
                }

                .status-pill {
                    font-size: 0.75rem;
                    padding: 6px 12px;
                }
            }
        </style>

        <!-- Main Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope me-2"></i>
                        <h4 class="mb-0 fw-bold fs-5">Contact Submissions</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="text-white me-2 small">Show:</label>
                        <select class="form-select form-select-sm w-auto" id="perPageFilter"
                            onchange="updateFilters('per_page', this.value)">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-2">
                <!-- Status Tabs - Responsive -->
                <div class="status-tabs mb-4">
                    <!-- Desktop View -->
                    <div class="d-none d-md-block">
                        <div class="d-flex flex-wrap gap-2 mb-3" id="desktopStatusTabs">
                            <button
                                class="status-pill btn {{ !request('status') ? 'active btn-primary' : 'btn-outline-primary' }}"
                                onclick="window.location.href='{{ url()->current() }}?{{ http_build_query(array_merge(request()->except(['status', 'page']), ['page' => 1])) }}'">
                                All <span class="badge bg-white text-primary ms-1">{{ $totalCount }}</span>
                            </button>
                            <button
                                class="status-pill btn {{ request('status') == 'pending' ? 'active btn-secondary' : 'btn-outline-secondary' }}"
                                onclick="window.location.href='{{ url()->current() }}?{{ http_build_query(array_merge(request()->except(['status', 'page']), ['status' => 'pending', 'page' => 1])) }}'">
                                Pending <span
                                    class="badge bg-white text-secondary ms-1">{{ $statusCounts['pending'] ?? 0 }}</span>
                            </button>
                            <button
                                class="status-pill btn {{ request('status') == 'in_review' ? 'active btn-warning' : 'btn-outline-warning' }}"
                                onclick="window.location.href='{{ url()->current() }}?{{ http_build_query(array_merge(request()->except(['status', 'page']), ['status' => 'in_review', 'page' => 1])) }}'">
                                In Review <span
                                    class="badge bg-white text-warning ms-1">{{ $statusCounts['in_review'] ?? 0 }}</span>
                            </button>
                            <button
                                class="status-pill btn {{ request('status') == 'approved' ? 'active btn-success' : 'btn-outline-success' }}"
                                onclick="window.location.href='{{ url()->current() }}?{{ http_build_query(array_merge(request()->except(['status', 'page']), ['status' => 'approved', 'page' => 1])) }}'">
                                Approved <span
                                    class="badge bg-white text-success ms-1">{{ $statusCounts['approved'] ?? 0 }}</span>
                            </button>
                            <button
                                class="status-pill btn {{ request('status') == 'rejected' ? 'active btn-danger' : 'btn-outline-danger' }}"
                                onclick="window.location.href='{{ url()->current() }}?{{ http_build_query(array_merge(request()->except(['status', 'page']), ['status' => 'rejected', 'page' => 1])) }}'">
                                Rejected <span
                                    class="badge bg-white text-danger ms-1">{{ $statusCounts['rejected'] ?? 0 }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="d-block d-md-none mb-3">
                        <div class="dropdown">
                            <button
                                class="btn btn-outline-primary w-100 dropdown-toggle d-flex justify-content-between align-items-center"
                                type="button" id="mobileStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    <i class="bi bi-filter me-2"></i>
                                    @if (request('status'))
                                        {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                                    @else
                                        All Submissions
                                    @endif
                                </span>
                                <span class="badge bg-primary rounded-pill" id="mobileStatusBadge">
                                    @if (request('status'))
                                        {{ $statusCounts[request('status')] ?? 0 }}
                                    @else
                                        {{ $totalCount }}
                                    @endif
                                </span>
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="mobileStatusDropdown">
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ !request('status') ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => 1]) }}">
                                        <span>
                                            <span class="status-indicator bg-secondary me-2"></span>
                                            All Submissions
                                        </span>
                                        <span class="badge bg-secondary rounded-pill">{{ $totalCount }}</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('status') == 'pending' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['status' => 'pending', 'page' => 1]) }}">
                                        <span>
                                            <span class="status-indicator bg-pending me-2"></span>
                                            Pending
                                        </span>
                                        <span
                                            class="badge bg-pending rounded-pill">{{ $statusCounts['pending'] ?? 0 }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('status') == 'in_review' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['status' => 'in_review', 'page' => 1]) }}">
                                        <span>
                                            <span class="status-indicator bg-in_review me-2"></span>
                                            In Review
                                        </span>
                                        <span
                                            class="badge bg-in_review rounded-pill">{{ $statusCounts['in_review'] ?? 0 }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('status') == 'approved' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['status' => 'approved', 'page' => 1]) }}">
                                        <span>
                                            <span class="status-indicator bg-approved me-2"></span>
                                            Approved
                                        </span>
                                        <span
                                            class="badge bg-approved rounded-pill">{{ $statusCounts['approved'] ?? 0 }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ request('status') == 'rejected' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['status' => 'rejected', 'page' => 1]) }}">
                                        <span>
                                            <span class="status-indicator bg-rejected me-2"></span>
                                            Rejected
                                        </span>
                                        <span
                                            class="badge bg-rejected rounded-pill">{{ $statusCounts['rejected'] ?? 0 }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Filters Row -->
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label small fw-bold text-muted mb-1">Loan Type</label>
                        <select class="form-select form-select-sm" id="loanTypeFilter"
                            onchange="updateFilters('loan_type', this.value)">
                            <option value="">All Loan Types</option>
                            @php
                                $loanTypes = \App\Models\ContactSubmission::select('loan_type')
                                    ->distinct()
                                    ->pluck('loan_type')
                                    ->filter();
                            @endphp
                            @foreach ($loanTypes as $type)
                                <option value="{{ $type }}" {{ request('loan_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label small fw-bold text-muted mb-1">Date Range</label>
                        <select class="form-select form-select-sm" id="dateFilter"
                            onchange="updateFilters('date_filter', this.value)">
                            <option value="">All Time</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>
                                Yesterday</option>
                            <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>This Week
                            </option>
                            <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>This Month
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-4">
                        <label class="form-label small fw-bold text-muted mb-1">Search</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search by name, email, or phone..."
                                id="searchInput" value="{{ request('search') }}"
                                onkeyup="if(event.keyCode === 13) updateFilters('search', this.value)">
                            <button class="btn btn-outline-primary" type="button"
                                onclick="updateFilters('search', document.getElementById('searchInput').value)">
                                <i class="bi bi-search"></i>
                            </button>
                            @if (request('search'))
                                <button class="btn btn-outline-danger" type="button"
                                    onclick="updateFilters('search', '')">
                                    <i class="bi bi-x"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Results -->
                @if ($submissions->count() > 0)
                    <!-- Mobile Cards View -->
                    <div class="d-block d-md-none">
                        @foreach ($submissions as $submission)
                            <div class="card mb-2 submission-card" data-id="{{ $submission->id }}">
                                <div class="card-body p-2">
                                    <!-- Header with name and status -->
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="card-title mb-0 fw-bold text-truncate me-2">{{ $submission->name }}
                                        </h6>
                                        <span class="badge bg-{{ $submission->status_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                        </span>
                                    </div>

                                    <!-- Contact info -->
                                    <div class="row g-1 mb-1">
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <i class="bi bi-envelope me-1"></i>
                                                <span class="text-truncate d-inline-block"
                                                    style="max-width: 180px;">{{ $submission->email }}</span>
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>{{ $submission->phone }}
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Loan details -->
                                    <div class="row g-1 mb-2">
                                        <div class="col-6">
                                            <small class="fw-bold d-block text-muted">Type</small>
                                            <span class="text-primary">{{ $submission->loan_type }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="fw-bold d-block text-muted">Amount</small>
                                            <span
                                                class="text-success">₹{{ number_format($submission->loan_amount) }}</span>
                                        </div>
                                    </div>

                                    <!-- Footer with date and actions -->
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $submission->created_at->format('M j, Y') }}
                                        </small>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-outline-primary me-1 action-btn view-details-btn"
                                                    data-id="{{ $submission->id }}"
                                                    title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle action-btn"
                                                    type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item status-update-btn" 
                                                           href="javascript:void(0)" 
                                                           data-id="{{ $submission->id }}" 
                                                           data-status="in_review">
                                                            <i class="bi bi-search me-2"></i>Mark In Review
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item status-update-btn" 
                                                           href="javascript:void(0)" 
                                                           data-id="{{ $submission->id }}" 
                                                           data-status="approved">
                                                            <i class="bi bi-check-circle me-2"></i>Approve
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item status-update-btn" 
                                                           href="javascript:void(0)" 
                                                           data-id="{{ $submission->id }}" 
                                                           data-status="rejected">
                                                            <i class="bi bi-x-circle me-2"></i>Reject
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-2">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Contact Info</th>
                                        <th scope="col">Loan Details</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submissions as $submission)
                                        <tr data-id="{{ $submission->id }}">
                                            <td class="ps-2 fw-bold">#{{ $submission->id }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $submission->name }}</div>
                                            </td>
                                            <td>
                                                <div class="small">
                                                    <i class="bi bi-envelope text-muted me-1"></i>
                                                    <span>{{ $submission->email }}</span>
                                                </div>
                                                <div class="small">
                                                    <i class="bi bi-telephone text-muted me-1"></i>
                                                    {{ $submission->phone }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-primary">{{ $submission->loan_type }}</div>
                                                <div class="text-success">₹{{ number_format($submission->loan_amount) }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($submission->message)
                                                    <span class="small text-truncate d-inline-block"
                                                        style="max-width: 150px;" data-bs-toggle="tooltip"
                                                        title="{{ $submission->message }}">
                                                        {{ Str::limit($submission->message, 50) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="small">{{ $submission->created_at->format('M j, Y') }}</div>
                                                <div class="text-muted small">
                                                    {{ $submission->created_at->format('g:i A') }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $submission->status_color }}">
                                                    {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-outline-primary me-1 action-btn view-details-btn"
                                                            data-id="{{ $submission->id }}"
                                                            title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-sm btn-outline-secondary dropdown-toggle action-btn"
                                                            type="button" data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item status-update-btn" 
                                                                   href="javascript:void(0)" 
                                                                   data-id="{{ $submission->id }}" 
                                                                   data-status="in_review">
                                                                    <i class="bi bi-search me-2"></i>Mark In Review
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item status-update-btn" 
                                                                   href="javascript:void(0)" 
                                                                   data-id="{{ $submission->id }}" 
                                                                   data-status="approved">
                                                                    <i class="bi bi-check-circle me-2"></i>Approve
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item status-update-btn" 
                                                                   href="javascript:void(0)" 
                                                                   data-id="{{ $submission->id }}" 
                                                                   data-status="rejected">
                                                                    <i class="bi bi-x-circle me-2"></i>Reject
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if ($submissions->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <div class="text-muted small">
                                Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of
                                {{ $submissions->total() }} entries
                            </div>
                            <div>
                                {{ $submissions->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <!-- No Results -->
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No contact submissions found.</p>
                        @if (request()->anyFilled(['search', 'status', 'loan_type', 'date_filter']))
                            <button class="btn btn-sm btn-outline-primary mt-2" onclick="clearAllFilters()">
                                <i class="bi bi-x-circle me-1"></i>Clear Filters
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- AJAX Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-file-text me-2"></i>Submission Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3" id="modalBody">
                    <!-- Content loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>
{{-- @endsection

@section('scripts') --}}
<script>
$(document).ready(function() {
    // ========== CORE FUNCTIONS ==========
    
    // Load submission details via AJAX
    window.loadSubmissionDetails = function(submissionId) {
        console.log('loadSubmissionDetails called with ID:', submissionId);
        
        $.ajax({
            url: `/admin/contact-submissions/${submissionId}`,
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                // Show modal with loading
                $('#modalBody').html(`
                    <div class="text-center py-4">
                        <div class="loader"></div>
                        <p class="mt-2">Loading details...</p>
                    </div>
                `);
                
                // Get modal instance and show
                const modalElement = document.getElementById('detailsModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                modal.show();
            },
            success: function(html) {
                $('#modalBody').html(html);
                // Reinitialize tooltips in modal
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#modalBody').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load submission details. Please try again.
                        <button class="btn btn-sm btn-outline-danger ms-3" onclick="loadSubmissionDetails(${submissionId})">
                            <i class="bi bi-arrow-clockwise"></i> Retry
                        </button>
                    </div>
                `);
            }
        });
    };

    // Update submission status
    window.updateSubmissionStatus = function(submissionId, status, event) {
        console.log('updateSubmissionStatus called:', { submissionId, status });
        
        if (!confirm(`Are you sure you want to change status to "${status.replace('_', ' ')}"?`)) {
            return false;
        }

        let $btn;
        if (event && event.target) {
            $btn = $(event.target).closest('.change-status, .status-update-btn');
            if ($btn.length === 0) {
                $btn = $(event.target);
            }
        }
        
        if ($btn && $btn.length > 0) {
            const originalHTML = $btn.html();
            // Show loading state
            $btn.prop('disabled', true).addClass('disabled');
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Updating...');
            // Store original content
            $btn.data('original-html', originalHTML);
        }

        // Send request
        $.ajax({
            url: `/admin/contact-submissions/${submissionId}/status`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: JSON.stringify({
                status: status
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Show success toast
                    showToast('success', `Status updated to ${data.data.status_label}!`);
                    
                    // Check if we're in a modal
                    const isInModal = $('.modal.show').length > 0;
                    
                    if (isInModal) {
                        // Close the modal first
                        const modal = bootstrap.Modal.getInstance($('#detailsModal')[0]);
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Clear modal content
                        $('#modalBody').html('');
                        
                        // Refresh the page after a short delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    } else {
                        // If not in modal, reload the page
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                } else {
                    throw new Error(data.message || 'Failed to update status');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                showToast('danger', 'Failed to update status: ' + error);
                
                // Reset button state
                if ($btn && $btn.length > 0) {
                    $btn.prop('disabled', false).removeClass('disabled');
                    $btn.html($btn.data('original-html') || 'Update Status');
                }
            },
            complete: function() {
                // Always re-enable button
                if ($btn && $btn.length > 0) {
                    $btn.prop('disabled', false).removeClass('disabled');
                }
            }
        });

        return false;
    };

    // Show toast notification
    window.showToast = function(type, message) {
        // Create toast container if not exists
        let $toastContainer = $('#toastContainer');
        if ($toastContainer.length === 0) {
            $toastContainer = $(`
                <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999"></div>
            `);
            $('body').append($toastContainer);
        }

        // Set icon based on type
        let icon = 'bi-info-circle';
        if (type === 'success') icon = 'bi-check-circle';
        if (type === 'danger') icon = 'bi-exclamation-circle';
        if (type === 'warning') icon = 'bi-exclamation-triangle';
        
        // Create toast
        const toastId = 'toast-' + Date.now();
        const $toast = $(`
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi ${icon} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);
        
        $toastContainer.append($toast);
        
        // Initialize and show toast
        const bsToast = new bootstrap.Toast($toast[0], { 
            delay: 3000,
            animation: true
        });
        bsToast.show();
        
        // Remove toast after hide
        $toast.on('hidden.bs.toast', function() {
            $(this).remove();
            if ($toastContainer.children().length === 0) {
                $toastContainer.remove();
            }
        });
    };

    // ========== FILTER FUNCTIONS ==========
    
    window.updateFilters = function(type, value) {
        const currentUrl = new URL(window.location.href);
        const params = new URLSearchParams(currentUrl.search);

        if (value) {
            params.set(type, value);
        } else {
            params.delete(type);
        }

        // Reset to page 1 when changing filters (except per_page)
        if (type !== 'per_page') {
            params.delete('page');
        }

        // Build new URL
        const newUrl = `${currentUrl.pathname}?${params.toString()}`;
        window.location.href = newUrl;
    };

    window.exportSubmissions = function() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'true');
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    };

    window.refreshData = function() {
        window.location.reload();
    };

    window.clearAllFilters = function() {
        window.location.href = "{{ route('admin.contact-submissions.index') }}";
    };

    // ========== EVENT HANDLERS ==========
    
    // Initialize Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Add enter key support for search
    $('#searchInput').on('keyup', function(event) {
        if (event.key === 'Enter') {
            updateFilters('search', $(this).val());
        }
    });

    // Update mobile status dropdown
    updateMobileStatusDropdown();
    
    // Handle view details buttons - SINGLE EVENT HANDLER
    $(document).off('click', '.view-details-btn').on('click', '.view-details-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const submissionId = $(this).data('id');
        console.log('View details clicked for ID:', submissionId);
        loadSubmissionDetails(submissionId);
    });
    
    // Handle inline status update buttons - SINGLE EVENT HANDLER
    $(document).off('click', '.status-update-btn').on('click', '.status-update-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const submissionId = $(this).data('id');
        const status = $(this).data('status');
        console.log('Inline status update clicked:', { submissionId, status });
        updateSubmissionStatus(submissionId, status, e);
    });
    
    // Handle modal status change buttons
    $(document).off('click', '#modalBody .change-status').on('click', '#modalBody .change-status', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const submissionId = $(this).data('id');
        const status = $(this).data('status');
        console.log('Modal status change clicked:', { submissionId, status });
        updateSubmissionStatus(submissionId, status, e);
    });
    
    // Handle row clicks (for better UX on mobile)
    $(document).on('click', '.submission-card', function(e) {
        // Don't trigger if clicking on buttons or dropdowns
        if (!$(e.target).closest('.btn, .dropdown').length) {
            const submissionId = $(this).data('id');
            loadSubmissionDetails(submissionId);
        }
    });
    
    // Clear modal content when it's hidden to prevent duplicate event handlers
    $('#detailsModal').on('hidden.bs.modal', function() {
        $('#modalBody').html('');
        console.log('Modal closed, content cleared');
    });

    function updateMobileStatusDropdown() {
        const urlParams = new URLSearchParams(window.location.search);
        const currentStatus = urlParams.get('status') || '';
        
        const $mobileDropdown = $('#mobileStatusDropdown');
        const $mobileBadge = $('#mobileStatusBadge');
        
        if ($mobileDropdown.length && $mobileBadge.length) {
            let statusText = 'All Submissions';
            let badgeCount = {{ $totalCount }};
            
            if (currentStatus) {
                statusText = currentStatus.split('_').map(word => 
                    word.charAt(0).toUpperCase() + word.slice(1)
                ).join(' ');
                
                switch(currentStatus) {
                    case 'pending': badgeCount = {{ $statusCounts['pending'] ?? 0 }}; break;
                    case 'in_review': badgeCount = {{ $statusCounts['in_review'] ?? 0 }}; break;
                    case 'approved': badgeCount = {{ $statusCounts['approved'] ?? 0 }}; break;
                    case 'rejected': badgeCount = {{ $statusCounts['rejected'] ?? 0 }}; break;
                }
            }
            
            $mobileDropdown.find('span:first').html(`
                <i class="bi bi-filter me-2"></i>${statusText}
            `);
            $mobileBadge.text(badgeCount);
        }
    }

    // Add CSS for spinner
    if (!$('#spinner-style').length) {
        $('<style id="spinner-style">').text(`
            .loader, .spinner-border {
                border: 2px solid #f3f3f3;
                border-top: 2px solid #022142ff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            .loader {
                width: 40px;
                height: 40px;
            }
            .spinner-border {
                width: 1rem;
                height: 1rem;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `).appendTo('head');
    }

    console.log('Contact submissions scripts loaded with jQuery');
});
</script>
@endsection
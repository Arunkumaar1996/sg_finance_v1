<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Submissions') }}
        </h2>
    </x-slot>

    <style>
        .submission-card {
            border-left: 4px solid #022142ff;
        }

        .badge.bg-pending {
            background-color: #6c757d;
        }

        .badge.bg-in_review {
            background-color: #ffc107;
            color: #000;
        }

        .badge.bg-approved {
            background-color: #28a745;
        }

        .badge.bg-rejected {
            background-color: #dc3545;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #022142ff 100%) !important;
        }

        .status-tab {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-tab.active {
            background-color: #022142ff !important;
            color: white !important;
            border-color: #022142ff !important;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 0.75rem;
            }

            .text-sm {
                font-size: 0.8rem;
            }

            .table-responsive {
                font-size: 0.8rem;
            }

            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.75rem;
            }

            .status-tabs .btn {
                font-size: 0.75rem;
                padding: 0.3rem 0.5rem;
            }

            .pagination .page-link {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
        }

        /* Ensure proper spacing */
        .container-fluid {
            padding: 0;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .dark .card {
            border: 1px solid #374151;
        }
    </style>

    <div class="p-3 sm:p-4 text-gray-900 dark:text-gray-100">
        <!-- Main Card -->
        <div class="card">
            <div class="card-header bg-primary text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope me-2"></i>
                        <h4 class="mb-0 fw-bold fs-5">Contact Submissions</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="text-white me-2 small">Show:</label>
                        <select class="form-select form-select-sm w-auto" id="perPageFilter">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-2">
                <!-- Status Tabs -->
                <div class="status-tabs mb-3">
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-outline-primary status-tab active" data-status="">
                            All <span class="badge bg-secondary ms-1">{{ $totalCount }}</span>
                        </button>
                        <button type="button" class="btn btn-outline-primary status-tab" data-status="pending">
                            Pending <span class="badge bg-pending ms-1">{{ $statusCounts['pending'] ?? 0 }}</span>
                        </button>
                        <button type="button" class="btn btn-outline-primary status-tab" data-status="in_review">
                            In Review <span class="badge bg-in_review ms-1">{{ $statusCounts['in_review'] ?? 0 }}</span>
                        </button>
                        <button type="button" class="btn btn-outline-primary status-tab" data-status="approved">
                            Approved <span class="badge bg-approved ms-1">{{ $statusCounts['approved'] ?? 0 }}</span>
                        </button>
                        <button type="button" class="btn btn-outline-primary status-tab" data-status="rejected">
                            Rejected <span class="badge bg-rejected ms-1">{{ $statusCounts['rejected'] ?? 0 }}</span>
                        </button>
                    </div>
                </div>

                <!-- Filters Row -->
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label small fw-bold text-muted mb-1">Loan Type</label>
                        <select class="form-select form-select-sm" id="loanTypeFilter">
                            <option value="">All Loan Types</option>
                            <option value="Personal Loan">Personal Loan</option>
                            <option value="Home Loan">Home Loan</option>
                            <option value="Business Loan">Business Loan</option>
                            <option value="Car Loan">Car Loan</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label small fw-bold text-muted mb-1">Date Range</label>
                        <select class="form-select form-select-sm" id="dateFilter">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-4">
                        <label class="form-label small fw-bold text-muted mb-1">Search</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search by name, email, or phone..." id="searchInput">
                            <button class="btn btn-outline-primary" type="button" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Cards View -->
                <div class="d-block d-md-none">
                    @forelse($submissions as $submission)
                    <div class="card mb-2 submission-card" data-status="{{ $submission->status }}" data-loan-type="{{ $submission->loan_type }}">
                        <div class="card-body p-2">
                            <!-- Header with name and status -->
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="card-title mb-0 fw-bold text-truncate me-2 small">{{ $submission->name }}</h6>
                                <span class="badge bg-{{ $submission->status_color }} flex-shrink-0 small">
                                    {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                </span>
                            </div>

                            <!-- Contact info -->
                            <div class="row g-1 mb-1">
                                <div class="col-12">
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i>
                                        <span class="text-truncate d-inline-block" style="max-width: 180px;">{{ $submission->email }}</span>
                                    </small>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>{{ $submission->phone }}
                                    </small>
                                </div>
                            </div>

                            <!-- Loan details -->
                            <div class="row g-1 mb-1">
                                <div class="col-6">
                                    <small class="fw-bold d-block">Type</small>
                                    <span class="text-primary small">{{ $submission->loan_type }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="fw-bold d-block">Amount</small>
                                    <span class="text-success small">₹{{ number_format($submission->loan_amount) }}</span>
                                </div>
                            </div>

                            <!-- Message preview -->
                            @if($submission->message)
                            <div class="mb-1">
                                <small class="fw-bold d-block">Message</small>
                                <p class="mb-0 small text-muted text-truncate">{{ Str::limit($submission->message, 60) }}</p>
                            </div>
                            @endif

                            <!-- Footer with date and actions -->
                            <div class="d-flex justify-content-between align-items-center pt-1 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $submission->created_at->format('M j') }}
                                </small>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle py-0 px-1" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item view-details small" href="#" data-id="{{ $submission->id }}">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li>
                                            <a class="dropdown-item small" href="#" onclick="updateStatus({{ $submission->id }}, 'in_review')">
                                                <i class="fas fa-search me-1"></i>Mark In Review
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item small" href="#" onclick="updateStatus({{ $submission->id }}, 'approved')">
                                                <i class="fas fa-check me-1"></i>Approve
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger small" href="#" onclick="updateStatus({{ $submission->id }}, 'rejected')">
                                                <i class="fas fa-times me-1"></i>Reject
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0 small">No contact submissions found.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Desktop Table View -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-2">#</th>
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
                            @forelse($submissions as $submission)
                            <tr class="submission-row" data-status="{{ $submission->status }}" data-loan-type="{{ $submission->loan_type }}">
                                <td class="ps-2 fw-bold">#{{ $submission->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $submission->name }}</div>
                                </td>
                                <td>
                                    <div class="small">
                                        <i class="fas fa-envelope text-muted me-1"></i>
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;">{{ $submission->email }}</span>
                                    </div>
                                    <div class="small">
                                        <i class="fas fa-phone text-muted me-1"></i>
                                        {{ $submission->phone }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-primary">{{ $submission->loan_type }}</div>
                                    <div class="text-success">₹{{ number_format($submission->loan_amount) }}</div>
                                </td>
                                <td>
                                    @if($submission->message)
                                    <span class="small text-truncate d-inline-block" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $submission->message }}">
                                        {{ Str::limit($submission->message, 50) }}
                                    </span>
                                    @else
                                    <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">{{ $submission->created_at->format('M j, Y') }}</div>
                                    <div class="text-muted small">{{ $submission->created_at->format('g:i A') }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $submission->status_color }}">
                                        {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item view-details" href="#" data-id="{{ $submission->id }}">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="updateStatus({{ $submission->id }}, 'in_review')">
                                                    <i class="fas fa-search me-2"></i>Mark In Review
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="updateStatus({{ $submission->id }}, 'approved')">
                                                    <i class="fas fa-check me-2"></i>Approve
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="updateStatus({{ $submission->id }}, 'rejected')">
                                                    <i class="fas fa-times me-2"></i>Reject
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">No contact submissions found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($submissions->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                    <div class="text-muted small">
                        Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{ $submissions->total() }} entries
                    </div>
                    <div>
                        {{ $submissions->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-file-alt me-2"></i>Submission Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3" id="modalBody">
                    <!-- Details will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Status Constants
        const STATUS_PENDING = 'pending';
        const STATUS_IN_REVIEW = 'in_review';
        const STATUS_APPROVED = 'approved';
        const STATUS_REJECTED = 'rejected';

        document.addEventListener('DOMContentLoaded', function() {
            const statusTabs = document.querySelectorAll('.status-tab');
            const loanTypeFilter = document.getElementById('loanTypeFilter');
            const dateFilter = document.getElementById('dateFilter');
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const perPageFilter = document.getElementById('perPageFilter');

            let currentStatus = '';
            let currentLoanType = '';
            let currentDateFilter = '';
            let currentSearch = '';
            let currentPerPage = '10';

            // Initialize from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status')) {
                currentStatus = urlParams.get('status');
                document.querySelector(`.status-tab[data-status="${currentStatus}"]`)?.classList.add('active');
                document.querySelector('.status-tab[data-status=""]')?.classList.remove('active');
            }
            if (urlParams.get('per_page')) {
                currentPerPage = urlParams.get('per_page');
                perPageFilter.value = currentPerPage;
            }

            function updateFilters() {
                const params = new URLSearchParams();

                if (currentStatus) params.set('status', currentStatus);
                if (currentLoanType) params.set('loan_type', currentLoanType);
                if (currentDateFilter) params.set('date_filter', currentDateFilter);
                if (currentSearch) params.set('search', currentSearch);
                if (currentPerPage !== '10') params.set('per_page', currentPerPage);

                window.location.href = `${window.location.pathname}?${params.toString()}`;
            }

            // Status tab functionality
            statusTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    statusTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    currentStatus = this.getAttribute('data-status');
                    updateFilters();
                });
            });

            // Filter functionality
            function applyFilters() {
                const loanType = loanTypeFilter.value;
                const dateFilterValue = dateFilter.value;
                const searchTerm = searchInput.value.toLowerCase();

                document.querySelectorAll('.submission-row, .submission-card').forEach(element => {
                    const elementStatus = element.getAttribute('data-status');
                    const elementLoanType = element.getAttribute('data-loan-type');
                    const elementText = element.textContent.toLowerCase();
                    const elementDate = element.querySelector('.date-display')?.textContent || '';

                    const statusMatch = !currentStatus || elementStatus === currentStatus;
                    const loanTypeMatch = !loanType || elementLoanType === loanType;
                    const searchMatch = !searchTerm || elementText.includes(searchTerm);
                    const dateMatch = !dateFilterValue || checkDateMatch(elementDate, dateFilterValue);

                    if (statusMatch && loanTypeMatch && searchMatch && dateMatch) {
                        element.style.display = '';
                    } else {
                        element.style.display = 'none';
                    }
                });
            }

            function checkDateMatch(elementDate, filter) {
                // Simple date matching - you might want to implement more sophisticated logic
                const today = new Date();
                const elementDateObj = new Date(elementDate);

                switch (filter) {
                    case 'today':
                        return elementDateObj.toDateString() === today.toDateString();
                    case 'yesterday':
                        const yesterday = new Date(today);
                        yesterday.setDate(yesterday.getDate() - 1);
                        return elementDateObj.toDateString() === yesterday.toDateString();
                    case 'week':
                        const weekAgo = new Date(today);
                        weekAgo.setDate(weekAgo.getDate() - 7);
                        return elementDateObj >= weekAgo;
                    case 'month':
                        const monthAgo = new Date(today);
                        monthAgo.setMonth(monthAgo.getMonth() - 1);
                        return elementDateObj >= monthAgo;
                    default:
                        return true;
                }
            }

            // Event listeners
            loanTypeFilter.addEventListener('change', function() {
                currentLoanType = this.value;
                applyFilters();
            });

            dateFilter.addEventListener('change', function() {
                currentDateFilter = this.value;
                applyFilters();
            });

            searchBtn.addEventListener('click', function() {
                currentSearch = searchInput.value;
                applyFilters();
            });

            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    currentSearch = this.value;
                    applyFilters();
                }
            });

            perPageFilter.addEventListener('change', function() {
                currentPerPage = this.value;
                updateFilters();
            });

            // View details modal
            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submissionId = this.getAttribute('data-id');

                    fetch(`/admin/contact-submissions/${submissionId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            document.getElementById('modalBody').innerHTML = `
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i>Personal Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Name:</strong> ${data.name}</p>
                                            <p><strong>Email:</strong> ${data.email}</p>
                                            <p><strong>Phone:</strong> ${data.phone}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-bold"><i class="fas fa-money-bill-wave me-2"></i>Loan Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Loan Type:</strong> ${data.loan_type}</p>
                                            <p><strong>Loan Amount:</strong> ₹${Number(data.loan_amount).toLocaleString()}</p>
                                            <p><strong>Status:</strong> <span class="badge bg-${data.status_color}">${data.status}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ${data.message ? `
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-bold"><i class="fas fa-comment me-2"></i>Message</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">${data.message}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ` : ''}
                            <div class="row mt-3">
                                <div class="col-12">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Submitted on: ${new Date(data.created_at).toLocaleString()}
                                    </small>
                                </div>
                            </div>
                        `;
                            new bootstrap.Modal(document.getElementById('detailsModal')).show();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error loading submission details');
                        });
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Update status function
        function updateStatus(submissionId, status) {
            if (!confirm('Are you sure you want to update the status?')) return;

            fetch(`/admin/contact-submissions/${submissionId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating status: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating status');
                });
        }
    </script>
</x-app-layout>
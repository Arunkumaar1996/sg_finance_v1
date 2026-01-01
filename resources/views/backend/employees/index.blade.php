@extends('layouts.app_new')

@section('title', 'Employee Management - HR System')

@section('page-title', 'Employee Management')
@section('page-description', 'Manage your team members and their information')

@section('breadcrumb-current', 'Employee Management')

@section('page-actions')
    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Add Employee
    </a>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Custom Styles -->
        <style>
            .employee-card {
                border-left: 4px solid #022142ff;
                transition: all 0.3s ease;
            }
            
            .employee-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            
            .badge.bg-active {
                background-color: #198754 !important;
                color: white !important;
            }
            
            .badge.bg-inactive {
                background-color: #6c757d !important;
                color: white !important;
            }
            
            .action-btn {
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 6px;
                margin: 0 2px;
            }
            
            .employee-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e9ecef;
            }
            
            .barcode-preview {
                height: 40px;
                width: auto;
                border-radius: 4px;
                background: white;
                padding: 3px;
                border: 1px solid #e2e8f0;
            }
            
            .role-badge {
                background-color: #e0f2fe;
                color: #0369a1;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 0.75rem;
                font-weight: 600;
            }
            
            .loading-spinner {
                display: none;
                text-align: center;
                padding: 20px;
            }
        </style>

        <!-- Main Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people me-2"></i>
                        <h4 class="mb-0 fw-bold fs-5">Employee Management</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="text-white me-2 small">Show:</label>
                        <select class="form-select form-select-sm w-auto" id="perPageFilter">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-2">
                <!-- Filters Row -->
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-muted mb-1">Search</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search by name, email, or ID..." id="searchInput" value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="button" id="searchButton">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request('search'))
                            <button class="btn btn-outline-danger" type="button" id="clearSearch">
                                <i class="bi bi-x"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-muted mb-1">Role</label>
                        <select class="form-select form-select-sm" id="roleFilter">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-muted mb-1">Status</label>
                        <select class="form-select form-select-sm" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading employees...</p>
                </div>

                <!-- Results Container -->
                <div id="resultsContainer">
                    @include('backend.employees.partials.table', ['employees' => $employees])
                    
                    @if($employees->hasPages())
                        @include('backend.employees.partials.pagination', ['employees' => $employees])
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    
    // Function to load data via AJAX
    function loadEmployees() {
        // Show loading spinner
        $('#loadingSpinner').show();
        $('#resultsContainer').hide();
        
        // Get filter values
        var search = $('#searchInput').val();
        var role = $('#roleFilter').val();
        var status = $('#statusFilter').val();
        var perPage = $('#perPageFilter').val();
        
        // Make AJAX call - SIMPLE METHOD
        $.ajax({
            url: '{{ route("employees.index") }}',
            type: 'GET',
            data: {
                search: search,
                role: role,
                status: status,
                per_page: perPage,
                ajax: 1  // This tells controller it's an AJAX request
            },
            success: function(response) {
                // Hide loading spinner
                $('#loadingSpinner').hide();
                
                // Update results container with new HTML
                $('#resultsContainer').html(response);
                $('#resultsContainer').show();
                
                // Update URL in browser address bar
                updateUrl();
            },
            error: function(xhr, status, error) {
                // Hide loading spinner
                $('#loadingSpinner').hide();
                $('#resultsContainer').show();
                
                // Show error
                alert('Error loading employees: ' + error);
                console.error('AJAX Error:', error);
            }
        });
    }
    
    // Function to update URL without page reload
    function updateUrl() {
        var search = $('#searchInput').val();
        var role = $('#roleFilter').val();
        var status = $('#statusFilter').val();
        var perPage = $('#perPageFilter').val();
        
        var params = [];
        if (search) params.push('search=' + encodeURIComponent(search));
        if (role) params.push('role=' + encodeURIComponent(role));
        if (status) params.push('status=' + encodeURIComponent(status));
        if (perPage && perPage != '10') params.push('per_page=' + perPage);
        
        var queryString = params.length ? '?' + params.join('&') : '';
        var newUrl = window.location.pathname + queryString;
        
        // Update browser URL without reloading page
        window.history.pushState({path: newUrl}, '', newUrl);
    }
    
    // Event Listeners
    
    // Search button click
    $('#searchButton').click(function() {
        loadEmployees();
    });
    
    // Enter key in search input
    $('#searchInput').keypress(function(e) {
        if (e.which == 13) { // Enter key
            loadEmployees();
        }
    });
    
    // Clear search button
    $('#clearSearch').click(function() {
        $('#searchInput').val('');
        loadEmployees();
    });
    
    // Filter dropdown changes
    $('#roleFilter, #statusFilter, #perPageFilter').change(function() {
        loadEmployees();
    });
    
    // Handle pagination clicks (for dynamically loaded content)
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        
        // Get the page number from the link
        var page = $(this).attr('href').split('page=')[1];
        
        // Get current filter values
        var search = $('#searchInput').val();
        var role = $('#roleFilter').val();
        var status = $('#statusFilter').val();
        var perPage = $('#perPageFilter').val();
        
        // Show loading spinner
        $('#loadingSpinner').show();
        $('#resultsContainer').hide();
        
        // Load specific page via AJAX
        $.ajax({
            url: '{{ route("employees.index") }}',
            type: 'GET',
            data: {
                page: page,
                search: search,
                role: role,
                status: status,
                per_page: perPage,
                ajax: 1
            },
            success: function(response) {
                // Hide loading spinner
                $('#loadingSpinner').hide();
                
                // Update results
                $('#resultsContainer').html(response);
                $('#resultsContainer').show();
                
                // Scroll to top of results
                $('html, body').animate({
                    scrollTop: $('#resultsContainer').offset().top - 100
                }, 500);
                
                // Update URL
                var params = [];
                if (search) params.push('search=' + encodeURIComponent(search));
                if (role) params.push('role=' + encodeURIComponent(role));
                if (status) params.push('status=' + encodeURIComponent(status));
                if (perPage && perPage != '10') params.push('per_page=' + perPage);
                if (page && page != '1') params.push('page=' + page);
                
                var queryString = params.length ? '?' + params.join('&') : '';
                var newUrl = window.location.pathname + queryString;
                window.history.pushState({path: newUrl}, '', newUrl);
            },
            error: function() {
                $('#loadingSpinner').hide();
                $('#resultsContainer').show();
                alert('Error loading page');
            }
        });
    });
    
    // Clear all filters function
    window.clearAllFilters = function() {
        $('#searchInput').val('');
        $('#roleFilter').val('');
        $('#statusFilter').val('');
        $('#perPageFilter').val('10');
        loadEmployees();
    };
    
    // Handle browser back/forward buttons
    $(window).on('popstate', function() {
        // Parse URL parameters
        var urlParams = new URLSearchParams(window.location.search);
        
        // Update filter inputs from URL
        $('#searchInput').val(urlParams.get('search') || '');
        $('#roleFilter').val(urlParams.get('role') || '');
        $('#statusFilter').val(urlParams.get('status') || '');
        $('#perPageFilter').val(urlParams.get('per_page') || '10');
        
        // Load data
        loadEmployees();
    });
    
    // Initial console log to confirm script loaded
    console.log('Employee filter AJAX loaded successfully');
    
    // TEST: Add a test button for debugging
    $('#resultsContainer').before('<button id="testAjax" class="btn btn-sm btn-warning mb-2">Test AJAX</button>');
    $('#testAjax').click(function() {
        console.log('Testing AJAX...');
        $.ajax({
            url: '{{ route("employees.index") }}',
            type: 'GET',
            data: { ajax: 1, test: 1 },
            success: function(response) {
                console.log('AJAX Test Successful! Response length:', response.length);
                alert('AJAX is working! Response received.');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Test Failed:', error);
                alert('AJAX Error: ' + error);
            }
        });
    });
});
</script>
@endsection
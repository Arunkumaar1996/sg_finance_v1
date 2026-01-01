<!-- resources/views/layouts/partials/header.blade.php -->
<div class="container-fluid h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 15px;">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active fw-medium">@yield('breadcrumb-current', 'Dashboard')</li>
                </ol>
            </nav>
        </div>

        <div class="col-md-4">
            <!-- Search Bar (Desktop Only) -->
            <div class="search-container">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0"
                        placeholder="Search employees, reports...">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="d-flex justify-content-end align-items-center">
                <div>
                    <a href="{{ route('calculator') }}" target="_blank">
                        <i class="bi bi-calculator me-3"></i></a>
                </div>

                <!-- Notifications -->
                <div class="dropdown me-3">
                    <button class="btn btn-light position-relative" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            5
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-3" style="width: 300px;">
                        <h6 class="dropdown-header fw-bold mb-2">Notifications</h6>
                        <div class="notification-item mb-3">
                            <div class="d-flex">
                                <div class="notification-icon bg-primary-light text-primary rounded-circle p-2 me-3">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                                <div>
                                    <div class="fw-medium">New Employee</div>
                                    <small class="text-muted">John Doe joined today</small>
                                    <div class="text-muted" style="font-size: 12px;">2 hours ago</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm w-100">View All</a>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="dropdown user-dropdown">
                    <div class="user-info" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff"
                                class="w-100 h-100" alt="Admin">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-medium">{{ Auth::user()->name }}</span>
                            <small class="text-muted">Administrator</small>
                        </div>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-header"
                                style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item text-danger logout-link" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this JavaScript to your layout -->
<script>
    // Enhanced logout handler
    document.addEventListener('DOMContentLoaded', function() {
        // Handle all logout links
        document.querySelectorAll('.logout-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Find the nearest logout form
                let form = this.closest('li').querySelector('form[id^="logout-form"]');
                if (!form) {
                    // Create a form if none exists
                    form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.getAttribute('href') || '/logout';
                    form.style.display = 'none';

                    // Add CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    document.body.appendChild(form);
                }

                // Submit the form
                form.submit();
            });
        });
    });
</script>

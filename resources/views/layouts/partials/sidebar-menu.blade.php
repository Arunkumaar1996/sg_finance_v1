<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.contact-submissions.*') ? 'active' : '' }}"
            href="{{ route('admin.contact-submissions.index') }}">
            <i class="bi bi-envelope-paper"></i>
            <span>Contact Submissions</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}"
            href="{{ route('attendance.index') }}">
            <i class="bi bi-calendar-check"></i>
            <span>Attendance</span>
        </a>
    </li>
     <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('calculator') ? 'active' : '' }}"
            href="{{ route('calculator') }}" target="_blank">
            <i class="bi bi-calculator me-3"></i>
            <span>Calculator</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employees.index') ? 'active' : '' }}"
            href="{{ route('employees.index') }}">
            <i class="bi bi-people me-3"></i>
            <span>Employee Management</span>
        </a>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
            <i class="bi bi-calendar-check"></i>
            <span>Attendance</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
            <i class="bi bi-people"></i>
            <span>Employees</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
            <i class="bi bi-calendar-check"></i>
            <span>Attendance</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('payroll.*') ? 'active' : '' }}" href="{{ route('payroll.index') }}">
            <i class="bi bi-cash-stack"></i>
            <span>Payroll</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('leave.*') ? 'active' : '' }}" href="{{ route('leave.index') }}">
            <i class="bi bi-calendar-event"></i>
            <span>Leave Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('performance.*') ? 'active' : '' }}" href="{{ route('performance.index') }}">
            <i class="bi bi-graph-up"></i>
            <span>Performance</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
            <i class="bi bi-building"></i>
            <span>Departments</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}" href="{{ route('documents.index') }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Documents</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    </li> --}}
</ul>

<!-- Reports Accordion -->
{{-- <div class="accordion mt-4" id="reportsAccordion">
    <div class="accordion-item border-0">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#reportsCollapse">
                <i class="bi bi-bar-chart me-2"></i>
                <span>Reports</span>
            </button>
        </h2>
        <div id="reportsCollapse" class="accordion-collapse collapse">
            <div class="accordion-body p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reports.monthly') ? 'active' : '' }}" href="{{ route('reports.monthly') }}" style="padding-left: 40px;">
                            Monthly Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reports.yearly') ? 'active' : '' }}" href="{{ route('reports.yearly') }}" style="padding-left: 40px;">
                            Yearly Reports
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}

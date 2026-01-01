@extends('layouts.app_new')

@section('title', 'Attendance Management - Management System')

@section('page-title', 'Daily Attendance')
@section('page-description', 'Mark and manage employee daily attendance')

@section('breadcrumb-current', 'Daily Attendance')

@section('page-actions')
    {{-- <button type="button" class="btn btn-outline-primary" onclick="printAttendance()">
        <i class="bi bi-printer me-2"></i> Print
    </button> --}}
    <button type="submit" form="attendanceForm" class="btn btn-primary" id="saveBtn">
        <i class="bi bi-save me-2"></i> Save Changes
    </button>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Custom Styles -->
        <style>
            .attendance-card {
                border-left: 4px solid #022142ff;
                transition: all 0.3s ease;
                position: relative;
            }
            
            .attendance-card.changed {
                border-left: 4px solid #ffc107;
                animation: borderPulse 2s infinite;
            }
            
            @keyframes borderPulse {
                0%, 100% { border-left-color: #ffc107; }
                50% { border-left-color: #ff9800; }
            }
            
            .employee-avatar {
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, #007bff 0%, #022142ff 100%);
                color: white;
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* NEW: Better Status Button Design */
            .status-btn-group {
                display: flex;
                gap: 6px;
                border-radius: 8px;
                padding: 4px;
                background: #f8f9fa;
            }
            
            .status-btn {
                flex: 1;
                padding: 10px 16px;
                border: none;
                border-radius: 6px;
                font-weight: 600;
                font-size: 13px;
                cursor: pointer;
                transition: all 0.3s ease;
                text-align: center;
                min-width: 70px;
                position: relative;
                overflow: hidden;
            }
            
            .status-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                transition: left 0.5s;
            }
            
            .status-btn:active::before {
                left: 100%;
            }
            
            .status-btn.present {
                background: #e8f5e9;
                color: #2e7d32;
                border: 2px solid #c8e6c9;
            }
            
            .status-btn.present.active {
                background: #4caf50;
                color: white;
                border-color: #4caf50;
                box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
                transform: translateY(-2px);
            }
            
            .status-btn.late {
                background: #fff3e0;
                color: #f57c00;
                border: 2px solid #ffcc80;
            }
            
            .status-btn.late.active {
                background: #ff9800;
                color: white;
                border-color: #ff9800;
                box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
                transform: translateY(-2px);
            }
            
            .status-btn.absent {
                background: #ffebee;
                color: #c62828;
                border: 2px solid #ffcdd2;
            }
            
            .status-btn.absent.active {
                background: #f44336;
                color: white;
                border-color: #f44336;
                box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
                transform: translateY(-2px);
            }
            
            /* NEW: Selected indicator */
            .selected-indicator {
                position: absolute;
                top: -3px;
                right: -3px;
                width: 16px;
                height: 16px;
                background: #4caf50;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                color: white;
                opacity: 0;
                transform: scale(0);
                transition: all 0.3s ease;
            }
            
            .status-btn.active .selected-indicator {
                opacity: 1;
                transform: scale(1);
            }
            
            /* NEW: Checkmark animation */
            .checkmark {
                width: 12px;
                height: 12px;
                stroke-width: 2;
                stroke: white;
                stroke-miterlimit: 10;
                animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
            }
            
            .checkmark__circle {
                stroke-dasharray: 166;
                stroke-dashoffset: 166;
                stroke-width: 2;
                stroke-miterlimit: 10;
                stroke: #4caf50;
                fill: none;
                animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
            }
            
            .checkmark__check {
                transform-origin: 50% 50%;
                stroke-dasharray: 48;
                stroke-dashoffset: 48;
                animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
            }
            
            @keyframes stroke {
                100% { stroke-dashoffset: 0; }
            }
            
            /* NEW: Change indicator */
            .change-indicator {
                position: absolute;
                top: 5px;
                right: 5px;
                width: 8px;
                height: 8px;
                background: #ff9800;
                border-radius: 50%;
                animation: pulse 2s infinite;
                display: none;
            }
            
            .changed .change-indicator {
                display: block;
            }
            
            @keyframes pulse {
                0%, 100% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.2); opacity: 0.7; }
            }
            
            .time-input {
                border: 2px solid #dee2e6;
                border-radius: 6px;
                padding: 8px 12px;
                width: 100%;
                text-align: center;
                transition: all 0.3s ease;
                font-weight: 500;
            }
            
            .time-input:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                transform: translateY(-1px);
            }
            
            .time-input:disabled {
                background-color: #f8f9fa;
                opacity: 0.6;
                cursor: not-allowed;
                border-style: dashed;
            }
            
            .stats-card {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 10px;
                padding: 15px;
                margin-bottom: 15px;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            
            .stats-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: #022142ff;
            }
            
            .stats-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            
            .stats-number {
                font-size: 24px;
                font-weight: 700;
                margin-bottom: 5px;
                transition: all 0.3s ease;
            }
            
            .stats-label {
                font-size: 12px;
                color: #6c757d;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .stats-present { color: #28a745; }
            .stats-late { color: #ffc107; }
            .stats-absent { color: #dc3545; }
            
            .mobile-sticky-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                padding: 12px 16px;
                box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                border-top: 1px solid #dee2e6;
            }
            
            /* NEW: Save button animation */
            .save-pulse {
                animation: savePulse 2s infinite;
            }
            
            @keyframes savePulse {
                0%, 100% { box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7); }
                50% { box-shadow: 0 0 0 10px rgba(0, 123, 255, 0); }
            }
            
            /* Table row highlight */
            .table tbody tr {
                transition: all 0.3s ease;
                position: relative;
            }
            
            .table tbody tr.changed {
                background: rgba(255, 193, 7, 0.05) !important;
            }
            
            .table tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
                transform: translateX(4px);
            }
            
            .card-header {
                background: linear-gradient(135deg, #007bff 0%, #022142ff 100%) !important;
                color: white !important;
            }
            
            /* Toast notification */
            #toastContainer {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1050;
                min-width: 250px;
            }
            
            @media (max-width: 768px) {
                .content-wrapper {
                    padding-bottom: 80px;
                }
                
                .employee-avatar {
                    width: 35px;
                    height: 35px;
                    font-size: 14px;
                }
                
                .status-btn {
                    padding: 8px 12px;
                    font-size: 12px;
                    min-width: 60px;
                }
                
                .time-input {
                    padding: 6px 10px;
                    font-size: 14px;
                }
                
                .stats-card {
                    padding: 10px;
                }
                
                .stats-number {
                    font-size: 20px;
                }
            }
            
            @media (min-width: 769px) {
                .mobile-sticky-footer {
                    display: none;
                }
            }
        </style>

        <!-- Toast Notification Container -->
        <div id="toastContainer"></div>

        <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            
            <!-- Main Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check me-2"></i>
                            <h4 class="mb-0 fw-bold fs-5">Daily Attendance</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <label class="text-white me-2 small">Date:</label>
                            <input type="date" class="form-control form-control-sm w-auto" 
                                   value="{{ $date }}" 
                                   onchange="window.location.href='{{ route('attendance.index') }}?date=' + this.value"
                                   style="max-width: 160px;">
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-2">
                    <!-- Quick Stats Row -->
                    <div class="row g-2 mb-3 d-none d-md-flex">
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="stats-card flex-fill text-center">
                                    <div class="stats-number stats-present">{{ count($employees) }}</div>
                                    <div class="stats-label">Total Employees</div>
                                </div>
                                <div class="stats-card flex-fill text-center">
                                    <div class="stats-number stats-present" id="presentCount">0</div>
                                    <div class="stats-label">Present</div>
                                </div>
                                <div class="stats-card flex-fill text-center">
                                    <div class="stats-number stats-late" id="lateCount">0</div>
                                    <div class="stats-label">Late</div>
                                </div>
                                <div class="stats-card flex-fill text-center">
                                    <div class="stats-number stats-absent" id="absentCount">0</div>
                                    <div class="stats-label">Absent</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-3">Employee</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col">Check In Time</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $emp)
                                        @php
                                            $att = $emp->attendances->first();
                                            $status = $att ? $att->status : 'present';
                                            $check_in = $att ? $att->check_in : '09:00';
                                        @endphp
                                        <tr data-employee-id="{{ $emp->id }}" id="row_{{ $emp->id }}" 
                                            data-original-status="{{ $status }}">
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="employee-avatar rounded-circle me-3">
                                                        {{ strtoupper(substr($emp->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $emp->name }}</div>
                                                        <small class="text-muted">{{ $emp->userProfile->employee_id ?? 'EMP-' . $emp->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="status-btn-group mx-auto" style="max-width: 250px;">
                                                    <!-- Present Button -->
                                                    <button type="button" 
                                                            class="status-btn present {{ $status == 'present' ? 'active' : '' }}"
                                                            data-status="present"
                                                            data-employee-id="{{ $emp->id }}">
                                                        P
                                                        <span class="selected-indicator">
                                                            <svg class="checkmark" viewBox="0 0 52 52">
                                                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    
                                                    <!-- Late Button -->
                                                    <button type="button" 
                                                            class="status-btn late {{ $status == 'late' ? 'active' : '' }}"
                                                            data-status="late"
                                                            data-employee-id="{{ $emp->id }}">
                                                        Late
                                                        <span class="selected-indicator">
                                                            <svg class="checkmark" viewBox="0 0 52 52">
                                                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    
                                                    <!-- Absent Button -->
                                                    <button type="button" 
                                                            class="status-btn absent {{ $status == 'absent' ? 'active' : '' }}"
                                                            data-status="absent"
                                                            data-employee-id="{{ $emp->id }}">
                                                        A
                                                        <span class="selected-indicator">
                                                            <svg class="checkmark" viewBox="0 0 52 52">
                                                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    
                                                    <!-- Hidden input for form submission -->
                                                    <input type="hidden" 
                                                           name="attendance[{{ $emp->id }}][status]" 
                                                           id="input_status_{{ $emp->id }}" 
                                                           value="{{ $status }}">
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                <input type="time" 
                                                       class="form-control form-control-sm time-input" 
                                                       name="attendance[{{ $emp->id }}][check_in]" 
                                                       id="time_{{ $emp->id }}"
                                                       value="{{ $check_in }}"
                                                       {{ $status == 'absent' ? 'disabled' : '' }}
                                                       data-original-time="{{ $check_in }}">
                                            </td>
                                            <td class="text-center">
                                                <span class="change-indicator"></span>
                                                <a href="{{ route('attendance.report', $emp->id) }}" 
                                                   class="btn btn-sm btn-outline-primary action-btn" 
                                                   title="View Report">
                                                    <i class="bi bi-graph-up"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Cards View -->
                    <div class="d-block d-md-none">
                        @foreach($employees as $emp)
                            @php
                                $att = $emp->attendances->first();
                                $status = $att ? $att->status : 'present';
                                $check_in = $att ? $att->check_in : '09:00';
                            @endphp
                            
                            <div class="card mb-2 attendance-card" id="card_{{ $emp->id }}" 
                                 data-employee-id="{{ $emp->id }}" 
                                 data-original-status="{{ $status }}">
                                <span class="change-indicator"></span>
                                
                                <div class="card-body p-2">
                                    <!-- Employee Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="employee-avatar rounded-circle me-2">
                                                {{ strtoupper(substr($emp->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-truncate" style="max-width: 150px;">{{ $emp->name }}</h6>
                                                <small class="text-muted">{{ $emp->userProfile->employee_id ?? 'EMP-' . $emp->id }}</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('attendance.report', $emp->id) }}" 
                                           class="btn btn-sm btn-outline-primary action-btn">
                                            <i class="bi bi-graph-up"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Status Selection -->
                                    <div class="mb-2">
                                        <div class="status-btn-group">
                                            <!-- Present Button -->
                                            <button type="button" 
                                                    class="status-btn present {{ $status == 'present' ? 'active' : '' }}"
                                                    data-status="present"
                                                    data-employee-id="{{ $emp->id }}">
                                                Present
                                                <span class="selected-indicator">
                                                    ✓
                                                </span>
                                            </button>
                                            
                                            <!-- Late Button -->
                                            <button type="button" 
                                                    class="status-btn late {{ $status == 'late' ? 'active' : '' }}"
                                                    data-status="late"
                                                    data-employee-id="{{ $emp->id }}">
                                                Late
                                                <span class="selected-indicator">
                                                    ✓
                                                </span>
                                            </button>
                                            
                                            <!-- Absent Button -->
                                            <button type="button" 
                                                    class="status-btn absent {{ $status == 'absent' ? 'active' : '' }}"
                                                    data-status="absent"
                                                    data-employee-id="{{ $emp->id }}">
                                                Absent
                                                <span class="selected-indicator">
                                                    ✓
                                                </span>
                                            </button>
                                            
                                            <!-- Hidden input for form submission -->
                                            <input type="hidden" 
                                                   name="attendance[{{ $emp->id }}][status]" 
                                                   id="m_input_status_{{ $emp->id }}" 
                                                   value="{{ $status }}">
                                        </div>
                                    </div>
                                    
                                    <!-- Check-in Time -->
                                    <div class="d-flex align-items-center justify-content-between bg-light rounded p-1">
                                        <small class="text-muted me-2">Check-in:</small>
                                        <input type="time" 
                                               class="form-control form-control-sm border-0 bg-transparent p-0 text-end" 
                                               name="attendance[{{ $emp->id }}][check_in]" 
                                               id="m_time_{{ $emp->id }}"
                                               value="{{ $check_in }}"
                                               style="max-width: 100px;"
                                               {{ $status == 'absent' ? 'disabled' : '' }}
                                               data-original-time="{{ $check_in }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Save Status Indicator -->
                <div class="card-footer bg-white p-3 d-none d-md-block">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small" id="saveStatus">
                            <span id="changedCount">0</span> changes pending
                        </div>
                        <button type="submit" class="btn btn-primary px-5 fw-bold" id="saveBtn">
                            <i class="bi bi-save me-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Save Button -->
            <div class="mobile-sticky-footer d-md-none">
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2" id="mobileSaveBtn">
                    <i class="bi bi-save me-2"></i> Save <span id="mobileChangedCount">0</span> Changes
                </button>
            </div>
        </form>
    </div>

<script>
$(document).ready(function() {
    let changedCount = 0;
    let changes = {}; // Track changes for each employee
    
    // Initialize
    updateCounters();
    updateChangedCount();
    
    // Handle status button clicks
    $(document).on('click', '.status-btn', function() {
        const $this = $(this);
        const employeeId = $this.data('employee-id');
        const status = $this.data('status');
        const employeeName = $this.closest('tr').find('.fw-semibold').text() || 
                            $this.closest('.card-body').find('.fw-bold').text();
        
        // Get all related elements
        const $row = $('#row_' + employeeId);
        const $card = $('#card_' + employeeId);
        const $btnGroup = $this.closest('.status-btn-group');
        const $timeInput = $('#time_' + employeeId);
        const $mTimeInput = $('#m_time_' + employeeId);
        const $statusInput = $('#input_status_' + employeeId);
        const $mStatusInput = $('#m_input_status_' + employeeId);
        const originalStatus = $row.length ? $row.data('original-status') : $card.data('original-status');
        
        // Remove active class from all buttons in group
        $btnGroup.find('.status-btn').removeClass('active');
        // Add active class to clicked button
        $this.addClass('active');
        
        // Update hidden inputs
        $statusInput.val(status);
        $mStatusInput.val(status);
        
        // Enable/disable time input based on status
        if (status === 'absent') {
            $timeInput.prop('disabled', true).addClass('text-muted');
            $mTimeInput.prop('disabled', true).addClass('text-muted');
        } else {
            $timeInput.prop('disabled', false).removeClass('text-muted');
            $mTimeInput.prop('disabled', false).removeClass('text-muted');
        }
        
        // Check if status changed
        const timeChanged = $timeInput.val() !== $timeInput.data('original-time');
        const statusChanged = status !== originalStatus;
        const hasChanges = statusChanged || timeChanged;
        
        // Update changed state
        if (hasChanges && !changes[employeeId]) {
            changes[employeeId] = true;
            changedCount++;
        } else if (!hasChanges && changes[employeeId]) {
            delete changes[employeeId];
            changedCount--;
        }
        
        // Update UI for changed state
        if (hasChanges) {
            $row.addClass('changed');
            $card.addClass('changed');
        } else {
            $row.removeClass('changed');
            $card.removeClass('changed');
        }
        
        // Show toast notification
        showStatusToast(employeeName, status, statusChanged);
        
        // Update counters
        updateCounters();
        updateChangedCount();
        
        // Add visual feedback
        $this.addClass('click-feedback');
        setTimeout(() => {
            $this.removeClass('click-feedback');
        }, 300);
    });
    
    // Handle time input changes
    $(document).on('change', '.time-input', function() {
        const $this = $(this);
        const employeeId = $this.attr('id').split('_')[1];
        const $row = $('#row_' + employeeId);
        const $card = $('#card_' + employeeId);
        const originalTime = $this.data('original-time');
        
        // Validate time format
        const timeValue = $this.val();
        if (timeValue && !/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(timeValue)) {
            showToast('warning', 'Please enter valid time (HH:MM)');
            $this.val(originalTime);
            return;
        }
        
        // Check if time changed
        const timeChanged = timeValue !== originalTime;
        const originalStatus = $row.length ? $row.data('original-status') : $card.data('original-status');
        const currentStatus = $('#input_status_' + employeeId).val();
        const statusChanged = currentStatus !== originalStatus;
        const hasChanges = statusChanged || timeChanged;
        
        // Update changed state
        if (hasChanges && !changes[employeeId]) {
            changes[employeeId] = true;
            changedCount++;
        } else if (!hasChanges && changes[employeeId]) {
            delete changes[employeeId];
            changedCount--;
        }
        
        // Update UI for changed state
        if (hasChanges) {
            $row.addClass('changed');
            $card.addClass('changed');
        } else {
            $row.removeClass('changed');
            $card.removeClass('changed');
        }
        
        updateChangedCount();
        
        // Add visual feedback
        $this.addClass('click-feedback');
        setTimeout(() => {
            $this.removeClass('click-feedback');
        }, 300);
    });
    
    // Update counters function
    function updateCounters() {
        let presentCount = 0;
        let lateCount = 0;
        let absentCount = 0;
        
        $('.status-btn.active').each(function() {
            const status = $(this).data('status');
            switch(status) {
                case 'present':
                    presentCount++;
                    break;
                case 'late':
                    lateCount++;
                    break;
                case 'absent':
                    absentCount++;
                    break;
            }
        });
        
        // Animate counter changes
        animateCounter($('#presentCount'), presentCount);
        animateCounter($('#lateCount'), lateCount);
        animateCounter($('#absentCount'), absentCount);
    }
    
    // Update changed count display
    function updateChangedCount() {
        $('#changedCount').text(changedCount);
        $('#mobileChangedCount').text(changedCount);
        
        // Update save button state
        if (changedCount > 0) {
            $('#saveBtn').addClass('save-pulse');
            $('#mobileSaveBtn').addClass('save-pulse');
        } else {
            $('#saveBtn').removeClass('save-pulse');
            $('#mobileSaveBtn').removeClass('save-pulse');
        }
    }
    
    // Animate counter value changes
    function animateCounter($element, newValue) {
        const oldValue = parseInt($element.text()) || 0;
        
        if (oldValue !== newValue) {
            $element.addClass('counter-change');
            $element.text(newValue);
            
            setTimeout(() => {
                $element.removeClass('counter-change');
            }, 600);
        }
    }
    
    // Show toast notification
    function showStatusToast(employeeName, status, isChange = true) {
        let message = '';
        let icon = '';
        let color = '';
        
        switch(status) {
            case 'present':
                message = `${employeeName} marked as Present`;
                icon = 'bi-check-circle';
                color = 'success';
                break;
            case 'late':
                message = `${employeeName} marked as Late`;
                icon = 'bi-clock-history';
                color = 'warning';
                break;
            case 'absent':
                message = `${employeeName} marked as Absent`;
                icon = 'bi-x-circle';
                color = 'danger';
                break;
        }
        
        if (!isChange) {
            message = `No change for ${employeeName}`;
            color = 'info';
            icon = 'bi-info-circle';
        }
        
        showToast(color, `<i class="bi ${icon} me-2"></i>${message}`);
    }
    
    // Generic toast function
    function showToast(type, message) {
        const toastId = 'toast-' + Date.now();
        const $toast = $(`
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);
        
        $('#toastContainer').append($toast);
        const bsToast = new bootstrap.Toast($toast[0], { delay: 1500 });
        bsToast.show();
        
        $toast.on('hidden.bs.toast', function() {
            $(this).remove();
            if ($('#toastContainer').children().length === 0) {
                $('#toastContainer').remove();
            }
        });
    }
    
    // Form submission
    $('#attendanceForm').on('submit', function(e) {
        e.preventDefault();
        
        if (changedCount === 0) {
            showToast('info', '<i class="bi bi-info-circle me-2"></i>No changes to save');
            return false;
        }
        
        // Show loading state
        const $submitBtn = $('#saveBtn, #mobileSaveBtn');
        const originalText = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');
        
        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showToast('success', '<i class="bi bi-check-circle me-2"></i>Attendance saved successfully!');
                
                // Reset changed states
                $('.changed').removeClass('changed');
                $('tr[data-employee-id]').each(function() {
                    const employeeId = $(this).data('employee-id');
                    const currentStatus = $('#input_status_' + employeeId).val();
                    $(this).data('original-status', currentStatus);
                    $('#time_' + employeeId).data('original-time', $('#time_' + employeeId).val());
                });
                
                $('.attendance-card').each(function() {
                    const employeeId = $(this).data('employee-id');
                    const currentStatus = $('#m_input_status_' + employeeId).val();
                    $(this).data('original-status', currentStatus);
                    $('#m_time_' + employeeId).data('original-time', $('#m_time_' + employeeId).val());
                });
                
                changes = {};
                changedCount = 0;
                updateChangedCount();
                
                // Animate save button
                $submitBtn.removeClass('btn-primary').addClass('btn-success');
                setTimeout(function() {
                    $submitBtn.removeClass('btn-success').addClass('btn-primary');
                }, 1500);
            },
            error: function(xhr) {
                showToast('danger', '<i class="bi bi-exclamation-triangle me-2"></i>Failed to save attendance!');
                console.error('Save error:', xhr.responseText);
            },
            complete: function() {
                // Reset button state
                setTimeout(function() {
                    $submitBtn.prop('disabled', false).html(originalText);
                }, 1000);
            }
        });
    });
    
    // Print function
    window.printAttendance = function() {
        // Print implementation (same as before)
        const date = '{{ $date }}';
        // ... rest of print function
    };
    
    // Add CSS for animations
    if (!$('#animations-style').length) {
        $('<style id="animations-style">').text(`
            .spinner-border {
                width: 1rem;
                height: 1rem;
                border: 2px solid #f3f3f3;
                border-top: 2px solid #022142ff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .counter-change {
                animation: counterPulse 0.6s ease;
            }
            @keyframes counterPulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.2); }
            }
            .click-feedback {
                animation: clickEffect 0.3s ease;
            }
            @keyframes clickEffect {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(0.95); }
            }
        `).appendTo('head');
    }
});
</script>
@endsection
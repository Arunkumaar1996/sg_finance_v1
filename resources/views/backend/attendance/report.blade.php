@extends('layouts.app_new')

@section('title', 'Attendance Report - Management System')

@section('page-title', 'Attendance Report')
@section('page-description', 'View monthly attendance details for employees')

@section('breadcrumb-current', 'Attendance Report')

@section('page-actions')
    <button type="button" class="btn btn-sm btn-outline-primary" onclick="printReport()">
        <i class="bi bi-printer me-1"></i> Print
    </button>
    <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Custom Styles -->
        <style>
            .compact-calendar {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 3px;
                margin-bottom: 10px;
            }
            
            .calendar-day {
                aspect-ratio: 1;
                border: 1px solid #e9ecef;
                border-radius: 4px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                position: relative;
                min-height: 40px;
                transition: all 0.2s;
            }
            
            .calendar-day:hover {
                transform: scale(1.05);
                z-index: 1;
            }
            
            .day-header {
                font-size: 11px;
                font-weight: 600;
                text-align: center;
                color: #6c757d;
                padding-bottom: 3px;
                text-transform: uppercase;
            }
            
            .day-number {
                font-weight: 600;
                line-height: 1;
            }
            
            .day-status {
                font-size: 9px;
                margin-top: 2px;
                font-weight: 500;
            }
            
            /* Status Colors */
            .day-present {
                background-color: rgba(40, 167, 69, 0.1);
                color: #28a745;
                border-color: rgba(40, 167, 69, 0.3);
            }
            
            .day-late {
                background-color: rgba(255, 193, 7, 0.1);
                color: #ffc107;
                border-color: rgba(255, 193, 7, 0.3);
            }
            
            .day-absent {
                background-color: rgba(220, 53, 69, 0.1);
                color: #dc3545;
                border-color: rgba(220, 53, 69, 0.3);
            }
            
            .day-empty {
                background-color: #f8f9fa;
                border-color: #f1f3f4;
            }
            
            /* Status Badges */
            .status-badge {
                padding: 4px 8px;
                border-radius: 12px;
                font-size: 11px;
                font-weight: 600;
            }
            
            .badge-present {
                background: rgba(40, 167, 69, 0.1);
                color: #28a745;
                border: 1px solid rgba(40, 167, 69, 0.3);
            }
            
            .badge-late {
                background: rgba(255, 193, 7, 0.1);
                color: #ffc107;
                border: 1px solid rgba(255, 193, 7, 0.3);
            }
            
            .badge-absent {
                background: rgba(220, 53, 69, 0.1);
                color: #dc3545;
                border: 1px solid rgba(220, 53, 69, 0.3);
            }
            
            /* Stats Cards */
            .stats-card {
                border-radius: 6px;
                padding: 10px;
                text-align: center;
                border-top: 3px solid;
            }
            
            .stats-count {
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 2px;
            }
            
            .stats-label {
                font-size: 10px;
                color: #6c757d;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            /* Employee Info */
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
            
            /* Table Styles */
            .compact-table {
                font-size: 12px;
            }
            
            .compact-table th {
                padding: 8px 6px;
                background: #f8f9fa;
                font-weight: 600;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .compact-table td {
                padding: 6px;
                vertical-align: middle;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .compact-table tr:hover td {
                background: rgba(0, 123, 255, 0.02);
            }
            
            /* View Toggle */
            .view-toggle {
                display: flex;
                gap: 2px;
                border-radius: 4px;
                padding: 2px;
                background: #f8f9fa;
            }
            
            .view-btn {
                padding: 6px 12px;
                border: none;
                border-radius: 3px;
                font-size: 11px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                display: inline-block;
                color: #495057;
                background: transparent;
            }
            
            .view-btn:hover {
                background: #e9ecef;
            }
            
            .view-btn.active {
                background: #007bff;
                color: white;
                box-shadow: 0 1px 3px rgba(0, 123, 255, 0.3);
            }
            
            .view-btn.active:hover {
                background: #007bff;
            }
            
            /* Mobile Optimizations */
            @media (max-width: 768px) {
                .employee-avatar {
                    width: 32px;
                    height: 32px;
                    font-size: 13px;
                }
                
                .calendar-day {
                    min-height: 30px;
                    font-size: 10px;
                }
                
                .day-header {
                    font-size: 10px;
                }
                
                .day-status {
                    font-size: 8px;
                }
                
                .stats-card {
                    padding: 8px 5px;
                }
                
                .stats-count {
                    font-size: 16px;
                }
                
                .compact-table {
                    font-size: 11px;
                }
                
                .compact-table th,
                .compact-table td {
                    padding: 4px;
                }
            }
            
            /* Legend */
            .legend-item {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 11px;
            }
            
            .legend-color {
                width: 12px;
                height: 12px;
                border-radius: 2px;
            }
            
            .legend-present {
                background: rgba(40, 167, 69, 0.1);
                border: 1px solid rgba(40, 167, 69, 0.3);
            }
            
            .legend-late {
                background: rgba(255, 193, 7, 0.1);
                border: 1px solid rgba(255, 193, 7, 0.3);
            }
            
            .legend-absent {
                background: rgba(220, 53, 69, 0.1);
                border: 1px solid rgba(220, 53, 69, 0.3);
            }
        </style>

        <!-- Main Card -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-primary text-white py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-badge me-2"></i>
                        <h4 class="mb-0 fw-bold fs-5">Attendance Report</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-white-50 me-2" style="font-size: 12px;">{{ $dateObj->format('F Y') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-2">
                <!-- Employee Info -->
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="employee-avatar rounded-circle me-2">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->userProfile->employee_id ?? 'EMP-' . $user->id }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <!-- Combined Form for Month/Year and View Type -->
                        <form id="filterForm" action="{{ route('attendance.report', $user->id) }}" method="GET" class="d-flex gap-2">
                            <input type="hidden" name="view_type" id="viewTypeInput" value="{{ $viewType }}">
                            
                            <select name="month" class="form-select form-select-sm" style="min-width: 80px;" onchange="this.form.submit()">
                                @for($m=1; $m<=12; $m++)
                                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ date('M', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endfor
                            </select>
                            <select name="year" class="form-select form-select-sm" style="min-width: 70px;" onchange="this.form.submit()">
                                @for($y=date('Y'); $y>=2023; $y--)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="stats-card" style="border-color: #28a745;">
                            <div class="stats-count text-success">{{ $present }}</div>
                            <div class="stats-label">Present</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stats-card" style="border-color: #dc3545;">
                            <div class="stats-count text-danger">{{ $absent }}</div>
                            <div class="stats-label">Absent</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stats-card" style="border-color: #ffc107;">
                            <div class="stats-count text-warning">{{ $late }}</div>
                            <div class="stats-label">Late</div>
                        </div>
                    </div>
                </div>

                <!-- View Toggle -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="view-toggle">
                        <!-- Use links instead of buttons with onclick -->
                        <a href="{{ request()->fullUrlWithQuery(['view_type' => 'calendar']) }}" 
                           class="view-btn {{ $viewType == 'calendar' ? 'active' : '' }}">
                            <i class="bi bi-calendar2-week me-1"></i> Calendar
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['view_type' => 'table']) }}" 
                           class="view-btn {{ $viewType == 'table' ? 'active' : '' }}">
                            <i class="bi bi-list-ul me-1"></i> List
                        </a>
                    </div>
                    
                    <!-- Legend -->
                    <div class="d-flex gap-3 d-none d-md-flex">
                        <div class="legend-item">
                            <div class="legend-color legend-present"></div>
                            <span>Present</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-late"></div>
                            <span>Late</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-absent"></div>
                            <span>Absent</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar View -->
                @if($viewType == 'calendar')
                    <div class="mb-2">
                        <div class="compact-calendar">
                            <div class="day-header text-danger">Sun</div>
                            <div class="day-header">Mon</div>
                            <div class="day-header">Tue</div>
                            <div class="day-header">Wed</div>
                            <div class="day-header">Thu</div>
                            <div class="day-header">Fri</div>
                            <div class="day-header">Sat</div>
                        </div>
                    </div>
                    
                    <div class="compact-calendar">
                        @for ($i = 0; $i < $dateObj->copy()->startOfMonth()->dayOfWeek; $i++)
                            <div class="calendar-day day-empty"></div>
                        @endfor

                        @for ($day = 1; $day <= $dateObj->daysInMonth; $day++)
                            @php
                                $currentDate = $dateObj->copy()->day($day)->format('Y-m-d');
                                $record = $attendances[$currentDate] ?? null;
                                $statusClass = 'day-empty';
                                $statusText = '';
                                $timeText = '';
                                
                                if($record) {
                                    if($record->status == 'present') {
                                        $statusClass = 'day-present';
                                        $statusText = 'Present';
                                    } elseif($record->status == 'absent') {
                                        $statusClass = 'day-absent';
                                        $statusText = 'Absent';
                                    } elseif($record->status == 'late') {
                                        $statusClass = 'day-late';
                                        $statusText = 'Late';
                                    }
                                    $timeText = $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i') : '';
                                }
                            @endphp

                            <div class="calendar-day {{ $statusClass }}">
                                <div class="day-number">{{ $day }}</div>
                                @if($record)
                                    <div class="day-status">{{ $statusText }}</div>
                                    @if($timeText)
                                        <div class="day-status" style="font-size: 8px;">{{ $timeText }}</div>
                                    @endif
                                @endif
                            </div>
                        @endfor
                    </div>

                <!-- Table View -->
                @else
                    <div class="table-responsive">
                        <table class="table compact-table">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Date</th>
                                    <th class="text-center" style="width: 25%">Day</th>
                                    <th class="text-center" style="width: 25%">Status</th>
                                    <th class="text-center" style="width: 30%">Check-in</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($day = 1; $day <= $dateObj->daysInMonth; $day++)
                                    @php
                                        $dateIter = $dateObj->copy()->day($day);
                                        $dateStr = $dateIter->format('Y-m-d');
                                        $record = $attendances[$dateStr] ?? null;
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $dateIter->format('d M') }}</td>
                                        
                                        <td class="text-center text-muted">
                                            {{ $dateIter->format('D') }}
                                        </td>
                                        
                                        <td class="text-center">
                                            @if($record)
                                                @if($record->status == 'present')
                                                    <span class="status-badge badge-present">Present</span>
                                                @elseif($record->status == 'late')
                                                    <span class="status-badge badge-late">Late</span>
                                                @elseif($record->status == 'absent')
                                                    <span class="status-badge badge-absent">Absent</span>
                                                @else
                                                    <span class="text-muted opacity-50">-</span>
                                                @endif
                                            @else
                                                <span class="text-muted opacity-50">Not Marked</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if($record && $record->check_in)
                                                {{ \Carbon\Carbon::parse($record->check_in)->format('H:i') }}
                                            @else
                                                <span class="text-muted">--</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                @endif
                
                <!-- Legend for Mobile -->
                <div class="d-flex gap-3 justify-content-center mt-3 d-md-none">
                    <div class="legend-item">
                        <div class="legend-color legend-present"></div>
                        <span>Present</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-late"></div>
                        <span>Late</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-absent"></div>
                        <span>Absent</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Print report function (converted to jQuery)
    window.printReport = function() {
        const employeeName = '{{ $user->name }}';
        const monthYear = '{{ $dateObj->format("F Y") }}';
        const totalDays = '{{ $dateObj->daysInMonth }}';
        
        let printContent = `
            <html>
            <head>
                <title>Attendance Report - ${employeeName}</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .header h2 { color: #022142ff; margin-bottom: 5px; }
                    .employee-info { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #022142ff; }
                    .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
                    .stat-box { text-align: center; padding: 10px; border-radius: 5px; }
                    .stat-present { color: #28a745; }
                    .stat-absent { color: #dc3545; }
                    .stat-late { color: #ffc107; }
                    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                    th { background: #022142ff; color: white; padding: 8px; text-align: left; }
                    td { padding: 6px; border-bottom: 1px solid #ddd; }
                    .present { background: #d4edda; }
                    .absent { background: #f8d7da; }
                    .late { background: #fff3cd; }
                    .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #666; }
                    @media print {
                        body { margin: 0; }
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>Attendance Report</h2>
                    <h3>${employeeName} - ${monthYear}</h3>
                </div>
                
                <div class="stats">
                    <div class="stat-box stat-present">
                        <div style="font-size: 24px; font-weight: bold;">{{ $present }}</div>
                        <div>Present</div>
                    </div>
                    <div class="stat-box stat-absent">
                        <div style="font-size: 24px; font-weight: bold;">{{ $absent }}</div>
                        <div>Absent</div>
                    </div>
                    <div class="stat-box stat-late">
                        <div style="font-size: 24px; font-weight: bold;">{{ $late }}</div>
                        <div>Late</div>
                    </div>
                </div>
                
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Status</th>
                        <th>Check-in</th>
                    </tr>
        `;
        
        // Add table rows
        @for ($day = 1; $day <= $dateObj->daysInMonth; $day++)
            @php
                $dateIter = $dateObj->copy()->day($day);
                $dateStr = $dateIter->format('Y-m-d');
                $record = $attendances[$dateStr] ?? null;
            @endphp
            printContent += `
                <tr>
                    <td>${ '{{ $dateIter->format("d M") }}' }</td>
                    <td>${ '{{ $dateIter->format("D") }}' }</td>
                    <td class="${ '{{ $record ? $record->status : "" }}' }">
                        ${ '{{ $record ? ucfirst($record->status) : "Not Marked" }}' }
                    </td>
                    <td>${ '{{ $record && $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format("H:i") : "--" }}' }</td>
                </tr>
            `;
        @endfor
        
        printContent += `
                </table>
                
                <div class="footer">
                    <p>Printed on: ${new Date().toLocaleString()}</p>
                    <p>Total Working Days: ${totalDays}</p>
                    <p>HR Management System © ${new Date().getFullYear()}</p>
                </div>
            </body>
            </html>
        `;
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.focus();
        
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    };

    // Alternative: jQuery version of view toggle (optional)
    $('.view-btn').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        window.location.href = url;
    });
});
</script>
@endsection
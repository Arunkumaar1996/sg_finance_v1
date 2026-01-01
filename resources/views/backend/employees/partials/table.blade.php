@if($employees->count() > 0)
    <!-- Desktop Table View -->
    <div class="table-responsive">
        <table class="table table-hover table-sm mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="ps-2">Employee</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">QR Code</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Role</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                @php
                    $profile = $employee->profile;
                    // Generate QR code data (you can customize this)
                    $qrData = $profile ? json_encode([
                        'employee_id' => $profile->employee_id,
                        'name' => $employee->name,
                        'email' => $employee->email,
                        'contact' => $profile->contact_number ?? '',
                        'role' => $profile->role ?? '',
                        'uid' => $profile->uid ?? ''
                    ]) : '';
                @endphp
                <tr>
                    <td class="ps-2">
                        <div class="d-flex align-items-center">
                            @if($profile && $profile->profile_image)
                                <img src="{{ asset('img/profile/'.$profile->profile_image) }}" class="employee-avatar me-3" alt="{{ $employee->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=random'">
                            @else
                                <div class="employee-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-person text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold">{{ $employee->name }}</div>
                                <div class="small text-muted">{{ $employee->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $profile->employee_id ?? 'N/A' }}</div>
                    </td>
                    <td>
                       
                                           <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('profile.public', $profile->uid) }}" alt="QR" width="50">
                    </td>
                    <td>
                        @if( $profile->barcode_image)
                                            <img src="{{ asset('img/barcodes/'.$profile->barcode_image) }}" class="barcode-preview mt-1" alt="barcode">
                                        @endif
                    </td>
                    <td>
                        <span class="role-badge">{{ $profile->role ?? 'Not Set' }}</span>
                    </td>
                    <td>
                        <div>{{ $profile->contact_number ?? '-' }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $employee->status ?? 'active' }}">
                            {{ ucfirst($employee->status ?? 'active') }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-primary me-1 action-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($profile && $profile->uid)
                            <a href="{{ route('profile.public', $profile->uid) }}" class="btn btn-sm btn-outline-info me-1 action-btn" title="View Profile" target="_blank">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif
                            {{-- <button type="button" class="btn btn-sm btn-outline-secondary me-1 action-btn" 
                                    title="Download Codes"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="bi bi-download"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadQRCode('{{ $employee->id }}', '{{ $employee->name }}')">
                                        <i class="bi bi-qr-code me-2"></i>Download QR Code
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadBarcode('{{ $employee->id }}', '{{ $employee->name }}')">
                                        <i class="bi bi-upc-scan me-2"></i>Download Barcode
                                    </a>
                                </li>
                            </ul> --}}
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- QR Code Modals -->
    @foreach($employees as $employee)
    @php
        $profile = $employee->profile;
        if($profile && $profile->employee_id) {
            $qrData = json_encode([
                'employee_id' => $profile->employee_id,
                'name' => $employee->name,
                'email' => $employee->email,
                'contact' => $profile->contact_number ?? '',
                'role' => $profile->role ?? '',
                'uid' => $profile->uid ?? ''
            ]);
        }
    @endphp
    @if($profile && $profile->employee_id)
    <div class="modal fade" id="qrModal{{ $employee->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR Code - {{ $employee->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    @if( $profile->barcode_image)
                                            <img src="{{ asset('img/barcodes/'.$profile->barcode_image) }}" class="barcode-preview mt-1" alt="barcode">
                                        @endif
                                           <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('profile.public', $profile->uid) }}" alt="QR" width="50">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="downloadQRCode('{{ $employee->id }}', '{{ $employee->name }}')">
                        <i class="bi bi-download me-1"></i>Download
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Modal -->
    <div class="modal fade" id="barcodeModal{{ $employee->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Barcode - {{ $employee->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img 
                        src="https://barcode.tec-it.com/barcode.ashx?data={{ $profile->employee_id }}&code=Code128&dpi=150&dataseparator="
                        alt="Barcode for {{ $profile->employee_id }}"
                        class="img-fluid mb-3"
                        style="max-height: 150px;"
                    >
                    <p class="fw-bold mb-1">{{ $profile->employee_id }}</p>
                    <p class="text-muted small mb-0">{{ $employee->name }}</p>
                    <p class="text-muted small">{{ $employee->email }}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="downloadBarcode('{{ $employee->id }}', '{{ $employee->name }}')">
                        <i class="bi bi-download me-1"></i>Download
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
@else
    <!-- No Results -->
    <div class="text-center py-5">
        <i class="bi bi-people display-4 text-muted mb-3"></i>
        <p class="text-muted mb-0">No employees found.</p>
    </div>
@endif

@push('styles')
<style>
    .qr-code-img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        transition: transform 0.2s;
    }
    
    .qr-code-img:hover {
        transform: scale(1.1);
    }
    
    .barcode-img {
        height: 40px;
        width: 100px;
        object-fit: contain;
        transition: transform 0.2s;
    }
    
    .barcode-img:hover {
        transform: scale(1.05);
    }
    
    .employee-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .role-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50rem;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: #e3f2fd;
        color: #1565c0;
        white-space: nowrap;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
</style>
@endpush

@push('scripts')
<script>
    function downloadQRCode(employeeId, employeeName) {
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${encodeURIComponent(JSON.stringify({
            employee_id: employeeId,
            name: employeeName,
            timestamp: new Date().toISOString()
        }))}&color=2c5282&bgcolor=f7fafc`;
        
        // Create a temporary link to download the image
        const link = document.createElement('a');
        link.href = qrUrl;
        link.download = `qr-code-${employeeName.replace(/\s+/g, '-').toLowerCase()}.png`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    
    function downloadBarcode(employeeId, employeeName) {
        const barcodeUrl = `https://barcode.tec-it.com/barcode.ashx?data=${employeeId}&code=Code128&dpi=300&dataseparator=`;
        
        // Create a temporary link to download the image
        const link = document.createElement('a');
        link.href = barcodeUrl;
        link.download = `barcode-${employeeName.replace(/\s+/g, '-').toLowerCase()}.png`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
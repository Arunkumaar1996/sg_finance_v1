@extends('layouts.app_new')

@section('title', 'Edit Employee - HR System')

@section('page-icon', 'bi-pencil')
@section('page-title', 'Edit Employee')
@section('page-description', 'Update employee profile information')
@section('breadcrumb-current', 'Edit Employee')

@section('page-actions')
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to Employees
    </a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('employees.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="employeeForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Left Column - Account & Profile -->
                            <div class="col-lg-8">
                                <!-- Account Details Section -->
                                <div class="card border mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="bi bi-person-badge me-2"></i>
                                            Account Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                       value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                                       value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Details Section -->
                                <div class="card border mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="bi bi-file-person me-2"></i>
                                            Profile Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            @php
                                                $profile = $user->profile;
                                            @endphp
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Employee ID <span class="text-danger">*</span></label>
                                                <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" 
                                                       value="{{ old('employee_id', $profile->employee_id ?? '') }}" required>
                                                <small class="text-muted">Changing ID will regenerate barcode</small>
                                                @error('employee_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                                    <option value="">Select Role</option>
                                                    <option value="Collection Staff" {{ (old('role', $profile->role ?? '') == 'Collection Staff') ? 'selected' : '' }}>Collection Staff</option>
                                                    <option value="Employee" {{ (old('role', $profile->role ?? '') == 'Employee') ? 'selected' : '' }}>Employee</option>
                                                    <option value="Manager" {{ (old('role', $profile->role ?? '') == 'Manager') ? 'selected' : '' }}>Manager</option>
                                                    <option value="Branch Manager" {{ (old('role', $profile->role ?? '') == 'Branch Manager') ? 'selected' : '' }}>Branch Manager</option>
                                                    <option value="Accounts Manager" {{ (old('role', $profile->role ?? '') == 'Accounts Manager') ? 'selected' : '' }}>Accounts Manager</option>
                                                    <option value="HR Manager" {{ (old('role', $profile->role ?? '') == 'HR Manager') ? 'selected' : '' }}>HR Manager</option>
                                                    <option value="Admin" {{ (old('role', $profile->role ?? '') == 'Admin') ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                                <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" 
                                                       value="{{ old('contact_number', $profile->contact_number ?? '') }}" required>
                                                @error('contact_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Emergency Contact</label>
                                                <input type="text" name="emergency_contact_number" class="form-control" 
                                                       value="{{ old('emergency_contact_number', $profile->emergency_contact_number ?? '') }}">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Blood Group</label>
                                                <select name="blood_group" class="form-select">
                                                    <option value="">Select Blood Group</option>
                                                    <option value="A+" {{ (old('blood_group', $profile->blood_group ?? '') == 'A+') ? 'selected' : '' }}>A+</option>
                                                    <option value="A-" {{ (old('blood_group', $profile->blood_group ?? '') == 'A-') ? 'selected' : '' }}>A-</option>
                                                    <option value="B+" {{ (old('blood_group', $profile->blood_group ?? '') == 'B+') ? 'selected' : '' }}>B+</option>
                                                    <option value="B-" {{ (old('blood_group', $profile->blood_group ?? '') == 'B-') ? 'selected' : '' }}>B-</option>
                                                    <option value="O+" {{ (old('blood_group', $profile->blood_group ?? '') == 'O+') ? 'selected' : '' }}>O+</option>
                                                    <option value="O-" {{ (old('blood_group', $profile->blood_group ?? '') == 'O-') ? 'selected' : '' }}>O-</option>
                                                    <option value="AB+" {{ (old('blood_group', $profile->blood_group ?? '') == 'AB+') ? 'selected' : '' }}>AB+</option>
                                                    <option value="AB-" {{ (old('blood_group', $profile->blood_group ?? '') == 'AB-') ? 'selected' : '' }}>AB-</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Date of Birth</label>
                                                <input type="date" name="dob" class="form-control" 
                                                       value="{{ old('dob', $profile->dob ? \Carbon\Carbon::parse($profile->dob)->format('Y-m-d') : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Profile Image & Preview -->
                            <div class="col-lg-4">
                                <!-- Profile Image Upload -->
                                <div class="card border mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="bi bi-camera me-2"></i>
                                            Profile Photo
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <!-- Current Image -->
                                        <div class="mb-3">
                                            <div class="profile-image-preview mx-auto mb-3">
                                                @if($profile && $profile->profile_image)
                                                    <img id="profileImagePreview" src="{{ asset('img/profile/'.$profile->profile_image) }}" 
                                                         alt="Profile Preview" class="img-fluid rounded-circle border" style="width: 200px; height: 200px; object-fit: cover;">
                                                @else
                                                    <img id="profileImagePreview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=200" 
                                                         alt="Profile Preview" class="img-fluid rounded-circle border" style="width: 200px; height: 200px; object-fit: cover;">
                                                @endif
                                            </div>
                                            <div class="form-text">
                                                Current photo (Upload new to replace)
                                            </div>
                                        </div>
                                        
                                        <!-- File Input -->
                                        <div class="mb-3">
                                            <input type="file" name="profile_image" id="profileImageInput" 
                                                   class="form-control @error('profile_image') is-invalid @enderror" 
                                                   accept="image/jpeg,image/png,image/jpg">
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Upload Button -->
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('profileImageInput').click()">
                                                <i class="bi bi-upload me-2"></i> Upload New Photo
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Barcode -->
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="bi bi-upc-scan me-2"></i>
                                            Current Barcode
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        @if($profile && $profile->barcode_image)
                                            <div class="barcode-preview mb-3">
                                                <img src="{{ asset('img/barcodes/'.$profile->barcode_image) }}" alt="Barcode" class="img-fluid mb-2">
                                                <div class="fw-bold">{{ $profile->employee_id }}</div>
                                            </div>
                                            <div class="alert alert-info small mb-0">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Barcode will update if Employee ID changes
                                            </div>
                                        @else
                                            <div class="text-muted">
                                                <i class="bi bi-upc-scan display-4"></i>
                                                <p class="mt-2">No barcode generated yet</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center border-top pt-4">
                                    <div>
                                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-x-circle me-2"></i> Cancel
                                        </a>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="reset" class="btn btn-outline-danger">
                                            <i class="bi bi-arrow-clockwise me-2"></i> Reset Changes
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-2"></i> Update Employee
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Same styles as create.blade.php -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Profile image preview
    $('#profileImageInput').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profileImagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Form validation
    $('#employeeForm').submit(function(e) {
        let valid = true;
        
        // Check required fields
        $('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
            showToast('danger', 'Please fill all required fields correctly');
        }
    });
    
    // Clear validation on input
    $('input, select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Toast notification function
    function showToast(type, message) {
        const toast = `
            <div class="toast align-items-center text-bg-${type} border-0 position-fixed bottom-0 end-0 m-3" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        $('.toast-container').remove();
        $('body').append('<div class="toast-container"></div>');
        $('.toast-container').html(toast);
        
        const bsToast = new bootstrap.Toast($('.toast')[0]);
        bsToast.show();
    }
});
</script>
@endsection
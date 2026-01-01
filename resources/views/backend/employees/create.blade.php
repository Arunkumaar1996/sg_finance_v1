@extends('layouts.app_new')

@section('title', 'Add New Employee - HR System')

@section('page-icon', 'bi-person-plus')
@section('page-title', 'Add New Employee')
@section('page-description', 'Create a new employee profile with ID card and barcode')
@section('breadcrumb-current', 'Add Employee')

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
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" id="employeeForm">
                        @csrf
                        
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
                                                       value="{{ old('name') }}" required placeholder="Enter full name">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                                       value="{{ old('email') }}" required placeholder="employee@company.com">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="password" 
                                                           class="form-control @error('password') is-invalid @enderror" 
                                                           required placeholder="Minimum 6 characters">
                                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                                       class="form-control" required placeholder="Confirm password">
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
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Employee ID <span class="text-danger">*</span></label>
                                                <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" 
                                                       value="{{ old('employee_id') }}" required placeholder="EMP001">
                                                <small class="text-muted">Barcode will be generated from this ID</small>
                                                @error('employee_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                                    <option value="">Select Role</option>
                                                    <option value="Collection Staff" {{ old('role') == 'Collection Staff' ? 'selected' : '' }}>Collection Staff</option>
                                                    <option value="Employee" {{ old('role') == 'Employee' ? 'selected' : '' }}>Employee</option>
                                                    <option value="Manager" {{ old('role') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                                    <option value="Branch Manager" {{ old('role') == 'Branch Manager' ? 'selected' : '' }}>Branch Manager</option>
                                                    <option value="Accounts Manager" {{ old('role') == 'Accounts Manager' ? 'selected' : '' }}>Accounts Manager</option>
                                                    <option value="HR Manager" {{ old('role') == 'HR Manager' ? 'selected' : '' }}>HR Manager</option>
                                                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                                <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" 
                                                       value="{{ old('contact_number') }}" required placeholder="+91 9876543210">
                                                @error('contact_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Emergency Contact</label>
                                                <input type="text" name="emergency_contact_number" class="form-control" 
                                                       value="{{ old('emergency_contact_number') }}" placeholder="+91 9876543210">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Blood Group</label>
                                                <select name="blood_group" class="form-select">
                                                    <option value="">Select Blood Group</option>
                                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Date of Birth</label>
                                                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
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
                                        <!-- Image Preview -->
                                        <div class="mb-3">
                                            <div class="profile-image-preview mx-auto mb-3">
                                                <img id="profileImagePreview" src="https://ui-avatars.com/api/?name=New+Employee&background=random&size=200" 
                                                     alt="Profile Preview" class="img-fluid rounded-circle border" style="width: 200px; height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="form-text">
                                                Recommended: Square image, JPG/PNG, Max 2MB
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
                                                <i class="bi bi-upload me-2"></i> Upload Photo
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Barcode Preview -->
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="bi bi-upc-scan me-2"></i>
                                            Barcode Preview
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="barcode-preview mb-3">
                                            <div class="bg-light p-4 rounded text-center">
                                                <div class="text-muted small mb-2">Employee ID Barcode</div>
                                                <div class="barcode-placeholder">
                                                    <i class="bi bi-upc-scan display-4 text-muted"></i>
                                                    <p class="text-muted mt-2 small">Barcode will be generated after saving</p>
                                                </div>
                                                <div id="employeeIdDisplay" class="mt-3 fw-bold"></div>
                                            </div>
                                        </div>
                                        <div class="alert alert-info small mb-0">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Barcode will be automatically generated from Employee ID
                                        </div>
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
                                            <i class="bi bi-arrow-clockwise me-2"></i> Reset Form
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-2"></i> Create Employee
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
<style>
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #022142ff;
        box-shadow: 0 0 0 0.25rem rgba(2, 33, 66, 0.25);
    }
    
    .card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .card-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.25rem;
        border-radius: 10px 10px 0 0 !important;
    }
    
    .profile-image-preview {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }
    
    .profile-image-preview img {
        border: 3px solid #e9ecef;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .barcode-placeholder {
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #dee2e6;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #022142ff 100%);
        border: none;
        padding: 0.5rem 2rem;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #022142ff 0%, #007bff 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(2, 33, 66, 0.2);
    }
    
    .btn-outline-primary {
        border-color: #022142ff;
        color: #022142ff;
    }
    
    .btn-outline-primary:hover {
        background-color: #022142ff;
        border-color: #022142ff;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-image-preview {
            width: 150px;
            height: 150px;
        }
        
        .profile-image-preview img {
            width: 150px;
            height: 150px;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .d-flex {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Password toggle
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
    });
    
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
    
    // Employee ID preview
    $('input[name="employee_id"]').on('input', function() {
        const employeeId = $(this).val();
        if (employeeId) {
            $('#employeeIdDisplay').text(employeeId);
        } else {
            $('#employeeIdDisplay').text('');
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
        
        // Check password match
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        
        if (password !== confirmPassword) {
            $('#password_confirmation').addClass('is-invalid');
            $('#password_confirmation').next('.invalid-feedback').remove();
            $('#password_confirmation').after('<div class="invalid-feedback">Passwords do not match</div>');
            valid = false;
        } else {
            $('#password_confirmation').removeClass('is-invalid');
        }
        
        if (!valid) {
            e.preventDefault();
            // Scroll to first error
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
            
            // Show toast notification
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
    
    // Initialize employee ID preview
    const initialEmployeeId = $('input[name="employee_id"]').val();
    if (initialEmployeeId) {
        $('#employeeIdDisplay').text(initialEmployeeId);
    }
});
</script>
@endsection
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-person-circle me-2"></i>Customer Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted mb-1">Full Name</label>
                        <div class="fw-semibold">{{ $contactSubmission->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted mb-1">Email Address</label>
                        <div class="fw-semibold">
                            <i class="bi bi-envelope me-1 text-primary"></i>
                            <a href="mailto:{{ $contactSubmission->email }}">{{ $contactSubmission->email }}</a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted mb-1">Phone Number</label>
                        <div class="fw-semibold">
                            <i class="bi bi-telephone me-1 text-primary"></i>
                            <a href="tel:{{ $contactSubmission->phone }}">{{ $contactSubmission->phone }}</a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted mb-1">Submission Date</label>
                        <div class="fw-semibold">
                            <i class="bi bi-calendar me-1 text-primary"></i>
                            {{ $contactSubmission->formatted_created_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-cash-stack me-2"></i>Loan Details
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted mb-1">Loan Type</label>
                        <div>
                            <span class="badge bg-primary">{{ $contactSubmission->loan_type }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted mb-1">Requested Amount</label>
                        <div class="fw-bold fs-5 text-success">{{ $contactSubmission->formatted_loan_amount }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($contactSubmission->message)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-chat-text me-2"></i>Additional Message
                </h6>
            </div>
            <div class="card-body">
                <div class="bg-light p-3 rounded">
                    <p class="mb-0">{{ $contactSubmission->message }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-gear me-2"></i>Status & Actions
                </h6>
            </div>
            <div class="card-body">
                <!-- Current Status -->
                <div class="mb-4">
                    <label class="form-label small text-muted mb-2">Current Status</label>
                    <div class="d-flex align-items-center">
                        <span class="badge {{ 'bg-' . $contactSubmission->status_color }} fs-6 px-3 py-2">
                            {{ ucfirst(str_replace('_', ' ', $contactSubmission->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="mb-4">
                    <label class="form-label small text-muted mb-2">Update Status</label>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-warning text-start change-status" 
                                data-id="{{ $contactSubmission->id }}" 
                                data-status="in_review">
                            <i class="bi bi-search me-2"></i>Mark as In Review
                        </button>
                        <button type="button" class="btn btn-outline-success text-start change-status" 
                                data-id="{{ $contactSubmission->id }}" 
                                data-status="approved">
                            <i class="bi bi-check-circle me-2"></i>Approve Submission
                        </button>
                        <button type="button" class="btn btn-outline-danger text-start change-status" 
                                data-id="{{ $contactSubmission->id }}" 
                                data-status="rejected">
                            <i class="bi bi-x-circle me-2"></i>Reject Submission
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-top pt-3">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contactSubmission->email }}?subject=Loan Application #{{ $contactSubmission->id }}" 
                           class="btn btn-primary" target="_blank">
                            <i class="bi bi-envelope me-2"></i>Send Email
                        </a>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Reattach event listeners for modal buttons
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for status change buttons in the modal
    document.querySelectorAll('.change-status').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const submissionId = this.getAttribute('data-id');
            const status = this.getAttribute('data-status');
            
            // Call the global update function
            if (typeof window.updateSubmissionStatus === 'function') {
                window.updateSubmissionStatus(submissionId, status);
            } else {
                console.error('updateSubmissionStatus function not found');
                alert('Error: Function not loaded. Please refresh the page.');
            }
        });
    });
});
</script>
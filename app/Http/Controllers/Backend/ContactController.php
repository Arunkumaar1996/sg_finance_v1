<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactStatusUpdateMail;

class ContactController extends Controller
{
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    
    public function index(Request $request)
    {
        $query = ContactSubmission::latest();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('loan_type', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Loan type filter
        if ($request->has('loan_type') && $request->loan_type) {
            $query->where('loan_type', $request->loan_type);
        }

        // Date filter
        if ($request->has('date_filter') && $request->date_filter) {
            $dateFilter = $request->date_filter;
            $now = now();
            
            switch($dateFilter) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'week':
                    $query->where('created_at', '>=', $now->startOfWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', $now->startOfMonth());
                    break;
            }
        }

        $perPage = $request->get('per_page', 10);
        $submissions = $query->paginate($perPage);

        // Add status colors for UI
        $submissions->getCollection()->transform(function ($submission) {
            $submission->status_color = $this->getStatusColor($submission->status);
            return $submission;
        });

        // Get counts for status tabs
        $statusCounts = [
            'pending' => ContactSubmission::where('status', self::STATUS_PENDING)->count(),
            'in_review' => ContactSubmission::where('status', self::STATUS_IN_REVIEW)->count(),
            'approved' => ContactSubmission::where('status', self::STATUS_APPROVED)->count(),
            'rejected' => ContactSubmission::where('status', self::STATUS_REJECTED)->count(),
        ];

        $totalCount = ContactSubmission::count();

        return view('backend.contact-submissions.index', compact('submissions', 'statusCounts', 'totalCount'));
    }

    public function show($id)
    {
        $contactSubmission = ContactSubmission::findOrFail($id);
        
        $contactSubmission->status_color = $this->getStatusColor($contactSubmission->status);
        $contactSubmission->formatted_created_at = $contactSubmission->created_at->format('F j, Y \a\t g:i A');
        $contactSubmission->formatted_loan_amount = '₹' . number_format($contactSubmission->loan_amount);

        // Check if it's an AJAX request
        if (request()->ajax()) {
            return view('backend.contact-submissions.show', compact('contactSubmission'))->render();
        }

        return view('backend.contact-submissions.show', compact('contactSubmission'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_review,approved,rejected'
        ]);

        try {
            $contactSubmission = ContactSubmission::findOrFail($id);
            $oldStatus = $contactSubmission->status;
            $newStatus = $request->status;
            
            // Update the status
            $contactSubmission->update([
                'status' => $newStatus,
                'status_updated_at' => now(),
                'status_updated_by' => '' ?? auth()->id() // If you have authentication
            ]);
            
            Log::info("Status updated for submission #{$contactSubmission->id}: {$oldStatus} -> {$newStatus}");
            
            // Send email notification to customer
            try {
                $this->sendStatusUpdateEmail($contactSubmission, $oldStatus, $newStatus);
                Log::info("Status update email sent to: {$contactSubmission->email}");
            } catch (\Exception $emailException) {
                Log::error("Failed to send status update email: " . $emailException->getMessage());
                // Don't fail the entire request if email fails
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => [
                    'id' => $contactSubmission->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'status_label' => $this->getStatusLabel($newStatus),
                    'status_color' => $this->getStatusColor($newStatus),
                    'status_color_class' => $this->getStatusColorClass($newStatus),
                    'email_sent' => true
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Status update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send email notification for status update
     */
    private function sendStatusUpdateEmail(ContactSubmission $submission, $oldStatus, $newStatus)
    {
        // Get status labels
        $oldStatusLabel = $this->getStatusLabel($oldStatus);
        $newStatusLabel = $this->getStatusLabel($newStatus);
        
        // Prepare email data
        $mailData = [
            'customer_name' => $submission->name,
            'customer_email' => $submission->email,
            'loan_type' => $submission->loan_type,
            'loan_amount' => '₹' . number_format($submission->loan_amount),
            'old_status' => $oldStatusLabel,
            'new_status' => $newStatusLabel,
            'status_update_date' => now()->format('F j, Y \a\t g:i A'),
            'submission_id' => $submission->id,
            'submission_date' => $submission->created_at->format('F j, Y'),
            // Add additional data based on status
            'status_specific_message' => $this->getStatusSpecificMessage($newStatus),
            'next_steps' => $this->getNextSteps($newStatus),
            'contact_person' => config('app.contact_person', 'Customer Support'),
            'contact_email' => config('app.contact_email', 'support@example.com'),
            'contact_phone' => config('app.contact_phone', '+91 XXXX XXXXXX'),
            'company_name' => config('app.name', 'HR Management System'),
        ];
        
        // Send email
        Mail::to($submission->email)
            ->send(new ContactStatusUpdateMail($mailData));
    }

    /**
     * Get human-readable status label
     */
    private function getStatusLabel($status)
    {
        return match($status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_REVIEW => 'In Review',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            default => ucfirst($status)
        };
    }

    /**
     * Get status-specific message for email
     */
    private function getStatusSpecificMessage($status)
    {
        return match($status) {
            self::STATUS_IN_REVIEW => 'Our team is currently reviewing your loan application. We will contact you within 2-3 business days with an update.',
            self::STATUS_APPROVED => 'Congratulations! Your loan application has been approved. Our representative will contact you shortly to proceed with the next steps.',
            self::STATUS_REJECTED => 'After careful review, we are unable to approve your loan application at this time. Please contact us for more details or to discuss alternative options.',
            default => 'Your application status has been updated.'
        };
    }

    /**
     * Get next steps based on status
     */
    private function getNextSteps($status)
    {
        return match($status) {
            self::STATUS_IN_REVIEW => [
                'Wait for our team to complete the review',
                'Keep your documents ready for verification',
                'We may contact you for additional information'
            ],
            self::STATUS_APPROVED => [
                'Our representative will contact you within 24 hours',
                'Please keep your KYC documents ready',
                'Complete the final documentation process'
            ],
            self::STATUS_REJECTED => [
                'Contact our customer support for detailed feedback',
                'Review the eligibility criteria for future applications',
                'Consider applying after 3-6 months'
            ],
            default => []
        };
    }

    private function getStatusColor($status)
    {
        return match($status) {
            self::STATUS_PENDING => 'pending',
            self::STATUS_IN_REVIEW => 'in_review',
            self::STATUS_APPROVED => 'approved',
            self::STATUS_REJECTED => 'rejected',
            default => 'secondary'
        };
    }

    private function getStatusColorClass($status)
    {
        return match($status) {
            self::STATUS_PENDING => 'bg-pending',
            self::STATUS_IN_REVIEW => 'bg-in_review',
            self::STATUS_APPROVED => 'bg-approved',
            self::STATUS_REJECTED => 'bg-rejected',
            default => 'bg-secondary'
        };
    }
}
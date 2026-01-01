<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
      use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'loan_amount',
        'loan_type',
        'message',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'loan_amount' => 'decimal:2',
    ];

    // Status constants for easy reference
    const STATUS_PENDING = 'pending';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Scope for filtering by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for pending applications
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // Check if application is approved
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    // Check if application is pending
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }
}

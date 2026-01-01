<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->getSubject();
        
        return $this->subject($subject)
                    ->view('emails.contact-status-update')
                    ->with($this->mailData);
    }

    /**
     * Get email subject based on status
     */
    private function getSubject()
    {
        $companyName = $this->mailData['company_name'] ?? config('app.name', 'Our Company');
        $loanType = $this->mailData['loan_type'] ?? 'Loan';
        
        return match($this->mailData['new_status']) {
            'In Review' => "Update: Your {$loanType} Application is Under Review - {$companyName}",
            'Approved' => "🎉 Congratulations! Your {$loanType} Application is Approved - {$companyName}",
            'Rejected' => "Update Regarding Your {$loanType} Application - {$companyName}",
            default => "Status Update: Your {$loanType} Application - {$companyName}"
        };
    }
}
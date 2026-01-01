<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailData['subject'] ?? 'Status Update' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #007bff 0%, #022142ff 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .status-box {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .status-change {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .old-status {
            color: #6c757d;
            text-decoration: line-through;
        }
        .new-status {
            color: #28a745;
            font-weight: bold;
        }
        .next-steps {
            background-color: #e8f5e8;
            border-left: 4px solid #28a745;
            padding: 20px;
            border-radius: 4px;
            margin: 25px 0;
        }
        .next-steps h3 {
            color: #1e7e34;
            margin-top: 0;
        }
        .next-steps ul {
            margin-bottom: 0;
        }
        .contact-info {
            background-color: #e7f1ff;
            padding: 20px;
            border-radius: 6px;
            margin: 25px 0;
            text-align: center;
        }
        .footer {
            background-color: #022142ff;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #80bdff;
            text-decoration: none;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #007bff 0%, #022142ff 100%);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            margin: 20px 0;
        }
        .highlight {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
        }
        @media (max-width: 600px) {
            .content {
                padding: 15px;
            }
            .status-change {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $company_name }}</h1>
            <p>Loan Application Status Update</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $customer_name }}</strong>,</p>
            
            <p>We're writing to inform you about the status update of your loan application.</p>
            
            <!-- Status Change Box -->
            <div class="status-change">
                <div>
                    <span class="old-status">{{ $old_status }}</span>
                    <span style="margin: 0 10px;">→</span>
                    <span class="new-status">{{ $new_status }}</span>
                </div>
                <div style="font-size: 12px; color: #6c757d;">
                    Updated: {{ $status_update_date }}
                </div>
            </div>

            <!-- Status Specific Message -->
            <div class="status-box">
                <h3 style="margin-top: 0; color: #022142ff;">Application Details:</h3>
                <p><strong>Application ID:</strong> #{{ $submission_id }}</p>
                <p><strong>Loan Type:</strong> {{ $loan_type }}</p>
                <p><strong>Loan Amount:</strong> {{ $loan_amount }}</p>
                <p><strong>Application Date:</strong> {{ $submission_date }}</p>
            </div>

            <!-- Status Specific Message -->
            <div class="highlight">
                <p><strong>{{ $new_status }} Status:</strong> {{ $status_specific_message }}</p>
            </div>

            <!-- Next Steps -->
            @if(!empty($next_steps))
                <div class="next-steps">
                    <h3>📋 Next Steps:</h3>
                    <ul>
                        @foreach($next_steps as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Contact Information -->
            <div class="contact-info">
                <h3 style="margin-top: 0; color: #022142ff;">Need Assistance?</h3>
                <p>Our team is here to help you with any questions or concerns.</p>
                <p><strong>Contact Person:</strong> {{ $contact_person }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $contact_email }}">{{ $contact_email }}</a></p>
                <p><strong>Phone:</strong> {{ $contact_phone }}</p>
                
                <a href="mailto:{{ $contact_email }}" class="btn">Contact Support</a>
            </div>

            <p style="color: #6c757d; font-size: 14px;">
                <em>This is an automated message. Please do not reply to this email.</em>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 {{ $company_name }}. All rights reserved.</p>
            <p>
                <a href="{{ config('app.url', '#') }}">Visit our website</a> 
                {{-- | 
                <a href="{{ config('app.url', '#') }}/privacy">Privacy Policy</a> | 
                <a href="{{ config('app.url', '#') }}/terms">Terms of Service</a> --}}
            </p>
            <p style="font-size: 12px; opacity: 0.8;">
                This email was sent to {{ $customer_email }} because you submitted a loan inquiry.
            </p>
        </div>
    </div>
</body>
</html>
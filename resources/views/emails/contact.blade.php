<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Loan Application - {{ $loan_type }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a3a5f, #2c5530);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            color: #1a3a5f;
            border-bottom: 2px solid #f8b500;
            padding-bottom: 8px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: bold;
            color: #1a3a5f;
            min-width: 150px;
        }
        .detail-value {
            flex: 1;
            color: #555;
        }
        .highlight-box {
            background: #f8f9fa;
            border-left: 4px solid #f8b500;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .footer {
            background: #1a3a5f;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #f8b500;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Selvaganapathy Finance Group</h1>
            <p>New Loan Application Received</p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2 class="section-title">Applicant Information</h2>
                <div class="detail-row">
                    <div class="detail-label">Full Name:</div>
                    <div class="detail-value">{{ $name }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email Address:</div>
                    <div class="detail-value">{{ $email }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Phone Number:</div>
                    <div class="detail-value">{{ $phone }}</div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Loan Details</h2>
                <div class="detail-row">
                    <div class="detail-label">Loan Type:</div>
                    <div class="detail-value">{{ $loan_type }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Loan Amount:</div>
                    <div class="detail-value">₹{{ number_format($loan_amount, 2) }}</div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Additional Information</h2>
                <div class="highlight-box">
                    <p><strong>Customer Message:</strong></p>
                    <p>{{ $customer_message }}</p>
                </div>
            </div>

            <div class="section">
                <div style="background: #e8f4fd; padding: 15px; border-radius: 8px; text-align: center;">
                    <p style="margin: 0; color: #1a3a5f; font-weight: bold;">
                        <i class="fas fa-clock"></i> This application requires immediate attention
                    </p>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was generated automatically from the website contact form.</p>
            <p>© {{ date('Y') }} Selvaganapathy Finance Group. All Rights Reserved.</p>
            <p>
                <a href="mailto:sgfinancetech@gmail.com">sgfinancetech@gmail.com</a> | 
                <a href="tel:917358596377">+91 7358596377</a> |
            </p>
        </div>
    </div>
</body>
</html>
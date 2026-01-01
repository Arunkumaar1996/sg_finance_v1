<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compact Loan Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .calculator {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 1.6rem;
            margin-bottom: 5px;
            font-weight: 700;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 0.85rem;
        }
        
        /* Body - All in one view */
        .body {
            padding: 20px;
        }
        
        /* Input Section */
        .input-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .input-group {
            margin-bottom: 0;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .input-with-prefix {
            display: flex;
            align-items: center;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
            height: 45px;
        }
        
        .input-with-prefix:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }
        
        .input-prefix {
            padding: 0 10px;
            background: #f8fafc;
            height: 100%;
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #4b5563;
            border-right: 2px solid #e0e0e0;
            font-size: 0.9rem;
            min-width: 50px;
        }
        
        .input-with-prefix input {
            flex: 1;
            border: none;
            padding: 0 10px;
            font-size: 1rem;
            font-weight: 600;
            color: #1e3a8a;
            outline: none;
            background: transparent;
        }
        
        /* Quick Amounts */
        .quick-amounts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 10px;
        }
        
        .quick-btn {
            padding: 8px;
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            font-weight: 600;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            font-size: 0.8rem;
        }
        
        .quick-btn:hover {
            background: #e5e7eb;
        }
        
        .quick-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        /* Frequency Selector */
        .frequency-section {
            margin-bottom: 20px;
        }
        
        .frequency-section label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .frequency-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        
        .freq-btn {
            padding: 10px;
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-weight: 600;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .freq-btn:hover {
            background: #e5e7eb;
        }
        
        .freq-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        /* Calculate Button */
        .calculate-btn {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .calculate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }
        
        /* Results Grid - All visible */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 15px;
        }
        
        .result-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e5e7eb;
            text-align: center;
            min-height: 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .result-label {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .result-value {
            font-size: 1.2rem;
            font-weight: 800;
            color: #1e3a8a;
        }
        
        .result-value.highlight {
            color: #059669;
        }
        
        .result-value.warning {
            color: #dc2626;
        }
        
        /* Timeline Card */
        .timeline-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 2px solid #f59e0b;
            text-align: center;
        }
        
        .timeline-title {
            font-size: 0.9rem;
            color: #92400e;
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .timeline-value {
            font-size: 1.8rem;
            font-weight: 900;
            color: #92400e;
            line-height: 1.2;
            margin-bottom: 5px;
        }
        
        .timeline-details {
            font-size: 0.9rem;
            color: #92400e;
        }
        
        /* Payment Summary */
        .payment-card {
            background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%);
            border-radius: 8px;
            padding: 15px;
            border: 2px solid #3b82f6;
            text-align: center;
        }
        
        .payment-title {
            font-size: 0.9rem;
            color: #1e40af;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .payment-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .payment-item {
            text-align: center;
        }
        
        .payment-label {
            font-size: 0.75rem;
            color: #1e40af;
            margin-bottom: 3px;
        }
        
        .payment-amount {
            font-size: 1rem;
            font-weight: 800;
            color: #1e3a8a;
        }
        
        /* Note */
        .note {
            font-size: 0.7rem;
            color: #6b7280;
            text-align: center;
            margin-top: 15px;
            line-height: 1.4;
        }
        
        /* Zero State */
        .zero-state {
            color: #9ca3af;
            font-style: italic;
        }
        
        @media (max-width: 400px) {
            .input-section {
                grid-template-columns: 1fr;
            }
            
            .results-grid {
                grid-template-columns: 1fr;
            }
            
            .payment-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="calculator">
        <div class="header">
            <h1>Loan Repayment Calculator</h1>
            <p>Enter your values - See repayment plan</p>
        </div>
        
        <div class="body">
            <!-- Input Section -->
            <div class="input-section">
                <div class="input-group">
                    <label>Loan Amount (₹)</label>
                    <div class="input-with-prefix">
                        <div class="input-prefix">₹</div>
                        <input type="number" id="loanAmount" value="0" min="0" max="500000" step="1000">
                    </div>
                    <div class="quick-amounts">
                        <button class="quick-btn" onclick="setAmount(10000)">₹10K</button>
                        <button class="quick-btn" onclick="setAmount(50000)">₹50K</button>
                        <button class="quick-btn" onclick="setAmount(100000)">₹1L</button>
                    </div>
                </div>
                
                <div class="input-group">
                    <label>Interest Rate (%)</label>
                    <div class="input-with-prefix">
                        <div class="input-prefix">%</div>
                        <input type="number" id="interestRate" value="0" min="0" max="100" step="0.1">
                    </div>
                    <div class="quick-amounts">
                        <button class="quick-btn" onclick="setRate(5)">5%</button>
                        <button class="quick-btn" onclick="setRate(12)">12%</button>
                        <button class="quick-btn" onclick="setRate(18)">18%</button>
                    </div>
                </div>
                
                <div class="input-group">
                    <label>Your Payment (₹)</label>
                    <div class="input-with-prefix">
                        <div class="input-prefix">₹</div>
                        <input type="number" id="paymentAmount" value="0" min="0" max="50000" step="100">
                    </div>
                    <div class="quick-amounts">
                        <button class="quick-btn" onclick="setPayment(1000)">₹1K</button>
                        <button class="quick-btn" onclick="setPayment(5000)">₹5K</button>
                        <button class="quick-btn" onclick="setPayment(10000)">₹10K</button>
                    </div>
                </div>
                
                <div class="input-group">
                    <label>Max Period (Months)</label>
                    <div class="input-with-prefix">
                        <div class="input-prefix">Mon</div>
                        <input type="number" id="maxMonths" value="0" min="0" max="120" step="1">
                    </div>
                    <div class="quick-amounts">
                        <button class="quick-btn" onclick="setMonths(6)">6M</button>
                        <button class="quick-btn" onclick="setMonths(12)">12M</button>
                        <button class="quick-btn" onclick="setMonths(24)">24M</button>
                    </div>
                </div>
            </div>
            
            <!-- Frequency Selector -->
            <div class="frequency-section">
                <label>Payment Frequency</label>
                <div class="frequency-buttons">
                    <button class="freq-btn active" onclick="selectFrequency('daily')">Daily</button>
                    <button class="freq-btn" onclick="selectFrequency('weekly')">Weekly</button>
                    <button class="freq-btn" onclick="selectFrequency('monthly')">Monthly</button>
                </div>
            </div>
            
            <!-- Calculate Button -->
            <button class="calculate-btn" onclick="calculate()">Calculate Repayment</button>
            
            <!-- Results Grid -->
            <div class="results-grid">
                <div class="result-card">
                    <div class="result-label">Total Loan</div>
                    <div class="result-value" id="totalLoan">₹0</div>
                </div>
                
                <div class="result-card">
                    <div class="result-label">Total Interest</div>
                    <div class="result-value" id="totalInterest">₹0</div>
                </div>
                
                <div class="result-card">
                    <div class="result-label">Total Payable</div>
                    <div class="result-value highlight" id="totalPayable">₹0</div>
                </div>
                
                <div class="result-card">
                    <div class="result-label">Your Payment</div>
                    <div class="result-value" id="yourPayment">₹0</div>
                </div>
            </div>
            
            <!-- Timeline -->
            <div class="timeline-card">
                <div class="timeline-title">REPAYMENT TIME</div>
                <div class="timeline-value" id="timelineValue">Enter Values</div>
                <div class="timeline-details" id="timelineDetails">Enter loan details above</div>
            </div>
            
            <!-- Payment Summary -->
            <div class="payment-card">
                <div class="payment-title">PAYMENT SUMMARY</div>
                <div class="payment-details">
                    <div class="payment-item">
                        <div class="payment-label">Frequency</div>
                        <div class="payment-amount" id="paymentFreq">Daily</div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-label">Total Payments</div>
                        <div class="payment-amount" id="totalPayments">0</div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-label">Payment Amount</div>
                        <div class="payment-amount" id="paymentAmt">₹0</div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-label">Last Payment</div>
                        <div class="payment-amount" id="lastPayment">₹0</div>
                    </div>
                </div>
            </div>
            
            <div class="note">
                All values in Indian Rupees. Enter values in the fields above to calculate.
            </div>
        </div>
    </div>

    <script>
        let selectedFrequency = 'daily';
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set all inputs to 0
            document.getElementById('loanAmount').value = 0;
            document.getElementById('interestRate').value = 0;
            document.getElementById('paymentAmount').value = 0;
            document.getElementById('maxMonths').value = 0;
            
            // Auto-calculate on input change
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', calculate);
            });
        });
        
        // Quick set functions
        function setAmount(amount) {
            document.getElementById('loanAmount').value = amount;
            calculate();
        }
        
        function setRate(rate) {
            document.getElementById('interestRate').value = rate;
            calculate();
        }
        
        function setPayment(payment) {
            document.getElementById('paymentAmount').value = payment;
            calculate();
        }
        
        function setMonths(months) {
            document.getElementById('maxMonths').value = months;
            calculate();
        }
        
        // Select frequency
        function selectFrequency(freq) {
            selectedFrequency = freq;
            document.querySelectorAll('.freq-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            calculate();
        }
        
        // Main calculation
        function calculate() {
            // Get values
            const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const interestRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0;
            const maxMonths = parseFloat(document.getElementById('maxMonths').value) || 0;
            
            // Calculate interest
            const interest = Math.round((loanAmount * interestRate) / 100);
            const totalPayable = loanAmount + interest;
            
            // Display basic info
            document.getElementById('totalLoan').textContent = formatCurrencyFull(loanAmount);
            document.getElementById('totalInterest').textContent = formatCurrencyFull(interest);
            document.getElementById('totalPayable').textContent = formatCurrencyFull(totalPayable);
            document.getElementById('yourPayment').textContent = formatCurrencyFull(paymentAmount);
            
            // Check if we have enough data to calculate
            if (loanAmount === 0 || paymentAmount === 0) {
                // Show zero/enter state
                document.getElementById('timelineValue').textContent = "Enter Values";
                document.getElementById('timelineDetails').textContent = "Enter loan and payment amount";
                document.getElementById('totalPayments').textContent = "0";
                document.getElementById('paymentAmt').textContent = "₹0";
                document.getElementById('lastPayment').textContent = "₹0";
                document.getElementById('paymentFreq').textContent = selectedFrequency.charAt(0).toUpperCase() + selectedFrequency.slice(1);
                return;
            }
            
            // Get payments per month
            let paymentsPerMonth = 0;
            let freqLabel = '';
            switch(selectedFrequency) {
                case 'daily':
                    paymentsPerMonth = 30;
                    freqLabel = 'Daily';
                    break;
                case 'weekly':
                    paymentsPerMonth = 4;
                    freqLabel = 'Weekly';
                    break;
                case 'monthly':
                    paymentsPerMonth = 1;
                    freqLabel = 'Monthly';
                    break;
            }
            
            // Calculate repayment time
            const monthlyPayment = paymentAmount * paymentsPerMonth;
            let monthsNeeded = totalPayable / monthlyPayment;
            
            // Check against max months
            let warning = false;
            if (maxMonths > 0 && monthsNeeded > maxMonths) {
                monthsNeeded = maxMonths;
                warning = true;
            }
            
            // Calculate details
            const totalPayments = Math.ceil(monthsNeeded * paymentsPerMonth);
            const daysNeeded = Math.ceil(monthsNeeded * 30);
            const weeksNeeded = Math.ceil(monthsNeeded * 4);
            
            // Calculate last payment
            const totalPaid = paymentAmount * (totalPayments - 1);
            let lastPayment = totalPayable - totalPaid;
            if (lastPayment < 0) lastPayment = 0;
            
            // Format timeline
            let timelineText = '';
            if (monthsNeeded < 1) {
                timelineText = Math.ceil(daysNeeded) + ' Days';
            } else if (monthsNeeded < 12) {
                timelineText = Math.round(monthsNeeded * 10) / 10 + ' Months';
            } else {
                const years = Math.floor(monthsNeeded / 12);
                const months = Math.round(monthsNeeded % 12);
                timelineText = years + ' Year' + (years > 1 ? 's' : '');
                if (months > 0) {
                    timelineText += ' ' + months + ' Month' + (months > 1 ? 's' : '');
                }
            }
            
            // Add warning if max months reached
            if (warning) {
                timelineText += ' (Max)';
                document.getElementById('timelineValue').classList.add('warning');
            } else {
                document.getElementById('timelineValue').classList.remove('warning');
            }
            
            // Update display
            document.getElementById('timelineValue').textContent = timelineText;
            document.getElementById('timelineDetails').textContent = 
                `${daysNeeded} Days / ${weeksNeeded} Weeks`;
            
            document.getElementById('paymentFreq').textContent = freqLabel;
            document.getElementById('totalPayments').textContent = totalPayments;
            document.getElementById('paymentAmt').textContent = formatCurrencyFull(paymentAmount);
            document.getElementById('lastPayment').textContent = formatCurrencyFull(lastPayment);
        }
        
        // Format currency with FULL display (₹10,000 not ₹10K)
        function formatCurrencyFull(amount) {
            amount = Math.round(amount);
            
            if (amount >= 10000000) {
                return '₹' + (amount / 10000000).toFixed(2) + ' Crore';
            } else if (amount >= 100000) {
                return '₹' + (amount / 100000).toFixed(2) + ' Lakh';
            } else {
                // Show full number with commas
                return '₹' + amount.toLocaleString('en-IN');
            }
        }
        
        // Show example with full values
        function showExample() {
            document.getElementById('loanAmount').value = 100000;
            document.getElementById('interestRate').value = 12;
            document.getElementById('paymentAmount').value = 5000;
            document.getElementById('maxMonths').value = 24;
            calculate();
        }
    </script>
</body>
</html>
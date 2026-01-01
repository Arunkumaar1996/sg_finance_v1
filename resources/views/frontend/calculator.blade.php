<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calculator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Loan Calculator - Selvacanpathy Leasing & Finance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        :root {
            --primary: #1a3a5f;
            --secondary: #f8b500;
            --light: #f8f9fa;
            --dark: #343a40;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            padding: 10px;
            color: #333;
        }
        
        .calculator-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .calculator-header {
            background: linear-gradient(to right, var(--primary), #2c4d76);
            color: white;
            padding: 15px 20px;
        }
        
        .calculator-header h1 {
            font-size: 1.5rem;
            margin: 0;
        }
        
        .calculator-header p {
            font-size: 0.85rem;
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        
        .calculator-body {
            padding: 20px;
        }
        
        .input-section {
            padding: 15px;
            border-radius: 8px;
            background: var(--light);
            margin-bottom: 15px;
        }
        
        .input-section h4 {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        
        .input-group {
            margin-bottom: 15px;
        }
        
        .input-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .range-value {
            color: var(--primary);
            font-weight: 600;
        }
        
        .form-range {
            height: 6px;
            margin: 5px 0;
        }
        
        .form-range::-webkit-slider-thumb {
            background: var(--primary);
            width: 18px;
            height: 18px;
        }
        
        .form-range::-moz-range-thumb {
            background: var(--primary);
            width: 18px;
            height: 18px;
            border: none;
        }
        
        .range-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 2px;
        }
        
        .range-labels span {
            font-size: 0.75rem;
            color: #666;
        }
        
        .results-section {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }
        
        .results-section h4 {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        
        .result-card {
            text-align: center;
            padding: 12px 8px;
            border-radius: 6px;
            transition: transform 0.3s;
            height: 100%;
            margin-bottom: 10px;
        }
        
        .result-card:hover {
            transform: translateY(-2px);
        }
        
        .result-card.primary {
            background: linear-gradient(135deg, var(--primary), #2c4d76);
            color: white;
        }
        
        .result-card.secondary {
            background: #f8f9fa;
            border: 1px solid #eaeaea;
        }
        
        .result-card.info {
            background: linear-gradient(135deg, var(--info), #2a9cc8);
            color: white;
        }
        
        .result-card.warning {
            background: linear-gradient(135deg, var(--warning), #ffcd39);
            color: var(--dark);
        }
        
        .result-value {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 5px 0;
        }
        
        .result-label {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        .breakdown-section {
            margin-top: 15px;
        }
        
        .breakdown-card {
            background: white;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
            margin-bottom: 15px;
        }
        
        .breakdown-card h5 {
            font-size: 1rem;
            margin-bottom: 12px;
        }
        
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
        }
        
        .breakdown-item:last-child {
            border-bottom: none;
            font-weight: 600;
            color: var(--primary);
            font-size: 0.95rem;
        }
        
        .interest-type-selector {
            margin-bottom: 15px;
        }
        
        .interest-type-selector h5 {
            font-size: 1rem;
            margin-bottom: 10px;
        }
        
        .interest-type-card {
            border: 2px solid #eaeaea;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .interest-type-card:hover {
            border-color: var(--primary);
            background-color: rgba(26, 58, 95, 0.05);
        }
        
        .interest-type-card.selected {
            border-color: var(--primary);
            background-color: rgba(26, 58, 95, 0.1);
        }
        
        .interest-type-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 3px;
            font-size: 0.9rem;
        }
        
        .interest-type-desc {
            font-size: 0.8rem;
            color: #666;
        }
        
        .chart-container {
            margin-top: 15px;
            height: 160px;
            position: relative;
        }
        
        .chart {
            display: flex;
            align-items: flex-end;
            height: 120px;
            gap: 6px;
            margin-top: 10px;
        }
        
        .chart-bar {
            flex: 1;
            background: var(--primary);
            border-radius: 4px 4px 0 0;
            position: relative;
            transition: height 0.5s ease;
        }
        
        .chart-bar.interest {
            background: var(--secondary);
        }
        
        .chart-label {
            text-align: center;
            margin-top: 5px;
            font-size: 0.7rem;
            color: #666;
        }
        
        .validation-error {
            color: #dc3545;
            font-size: 0.75rem;
            margin-top: 3px;
            display: none;
        }
        
        .btn-calculate {
            background: var(--secondary);
            color: var(--dark);
            border: none;
            padding: 8px 20px;
            font-weight: 600;
            border-radius: 50px;
            width: 100%;
            margin-top: 8px;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .btn-calculate:hover {
            background: #e6a500;
            transform: translateY(-2px);
        }
        
        .savings-alert {
            background: #d4edda;
            color: #155724;
            padding: 8px 10px;
            border-radius: 6px;
            margin-top: 12px;
            display: none;
            font-size: 0.8rem;
        }
        
        .amortization-table {
            font-size: 0.8rem;
        }
        
        .amortization-table th {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.85rem;
            padding: 8px 10px;
        }
        
        .amortization-table td {
            padding: 6px 10px;
        }
        
        .yearly-breakdown {
            margin-top: 15px;
        }
        
        .year-card {
            background: white;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 3px solid var(--primary);
        }
        
        .year-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary);
            font-size: 0.9rem;
        }
        
        .year-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        
        .year-detail {
            text-align: center;
            padding: 6px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .year-detail-value {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.85rem;
        }
        
        .year-detail-label {
            font-size: 0.7rem;
            color: #666;
        }
        
        .payment-distribution-chart {
            height: 250px;
            margin-top: 15px;
        }
        
        @media (max-width: 768px) {
            .calculator-body {
                padding: 15px;
            }
            
            .result-value {
                font-size: 1.1rem;
            }
            
            .calculator-header {
                padding: 12px 15px;
            }
            
            .input-section, .results-section {
                padding: 12px;
            }
            
            .year-details {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 8px;
            }
            
            .calculator-container {
                border-radius: 10px;
            }
            
            .calculator-header h1 {
                font-size: 1.3rem;
            }
            
            .calculator-header p {
                font-size: 0.8rem;
            }
        }
        
        .pulse {
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .compact-input {
            margin-bottom: 12px;
        }
        
        .compact-input .input-label {
            font-size: 0.85rem;
        }
        
        .compact-input .range-value {
            font-size: 0.85rem;
        }
        
        .tab-container {
            margin-top: 15px;
        }
        
        .nav-tabs .nav-link {
            color: var(--primary);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 12px;
        }
        
        .nav-tabs .nav-link.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .tab-pane {
            padding: 15px 0;
        }
        
        .interest-info {
            font-size: 0.75rem;
            color: #666;
            margin-top: 3px;
        }
        
        .table-primary {
            background-color: rgba(26, 58, 95, 0.1) !important;
        }
    </style>
</head>
<body>
    <div class="calculator-container">
        <div class="calculator-header">
            <h1><i class="fas fa-calculator me-2"></i>Advanced Loan Calculator</h1>
            <p class="mb-0">Calculate your monthly EMI, total payment, and view detailed amortization schedule</p>
        </div>
        
        <div class="calculator-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-section">
                        <h4>Loan Details</h4>
                        
                        <div class="input-group compact-input">
                            <div class="input-label">
                                <span>Loan Amount</span>
                                <span class="range-value" id="loanAmountValue">₹2,50,000.00</span>
                            </div>
                            <input type="range" class="form-range" min="0" max="500000" step="10000" value="0" id="loanAmount">
                            <div class="range-labels">
                                <span>₹0.00</span>
                                <span>₹5,00,000.00</span>
                            </div>
                            <div class="validation-error" id="loanAmountError">Please enter a valid loan amount</div>
                        </div>
                        
                        <div class="input-group compact-input">
                            <div class="input-label">
                                <span>Interest Rate (% per year)</span>
                                <span class="range-value" id="interestRateValue">7.50%</span>
                            </div>
                            <input type="range" class="form-range" min="0" max="15" step="0.1" value="0" id="interestRate">
                            <div class="range-labels">
                                <span>0.00%</span>
                                <span>15.00%</span>
                            </div>
                            <div class="validation-error" id="interestRateError">Please enter a valid interest rate</div>
                        </div>
                        
                        <div class="input-group compact-input">
                            <div class="input-label">
                                <span>Loan Tenure (years)</span>
                                <span class="range-value" id="loanTenureValue">3 years</span>
                            </div>
                            <input type="range" class="form-range" min="1" max="5" value="0" id="loanTenure">
                            <div class="range-labels">
                                <span>1 year</span>
                                <span>5 years</span>
                            </div>
                            <div class="validation-error" id="loanTenureError">Please enter a valid loan tenure</div>
                        </div>
                        
                        <div class="interest-type-selector">
                            <h5>Interest Type</h5>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="interest-type-card selected" data-type="simple">
                                        <div class="interest-type-title">Simple Interest</div>
                                        <div class="interest-type-desc">Interest calculated only on principal amount</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="interest-type-card" data-type="compound">
                                        <div class="interest-type-title">Compound Interest</div>
                                        <div class="interest-type-desc">Interest calculated on principal + accumulated interest</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="interest-type-card" data-type="complex">
                                        <div class="interest-type-title">Complex Interest</div>
                                        <div class="interest-type-desc">Interest with additional fees and charges</div>
                                    </div>
                                </div>
                            </div>
                            <div class="interest-info" id="interestTypeInfo">
                                Simple interest is calculated only on the principal amount throughout the loan tenure.
                            </div>
                        </div>
                        
                        <button class="btn-calculate" id="calculateBtn">
                            <i class="fas fa-calculator me-2"></i>Calculate EMI
                        </button>
                        
                        <div class="savings-alert" id="savingsAlert">
                            <i class="fas fa-lightbulb me-2"></i>
                            <span id="savingsText">You can save ₹50,000 by increasing your down payment!</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="results-section">
                        <h4>Loan Summary</h4>
                        
                        <div class="row mb-2">
                            <div class="col-md-6 mb-2">
                                <div class="result-card primary">
                                    <div class="result-label">Monthly EMI</div>
                                    <div class="result-value" id="emiValue">₹7,800.00</div>
                                    <small>Per month</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="result-card secondary">
                                    <div class="result-label">Total Interest</div>
                                    <div class="result-value" id="totalInterestValue">₹4,04,000.00</div>
                                    <small>Payable over loan term</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-md-6 mb-2">
                                <div class="result-card info">
                                    <div class="result-label">Total Payment</div>
                                    <div class="result-value" id="totalPaymentValue">₹9,04,000.00</div>
                                    <small>Principal + Interest</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="result-card warning">
                                    <div class="result-label">Interest Percentage</div>
                                    <div class="result-value" id="interestPercentage">44.70%</div>
                                    <small>Of total payment</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="breakdown-card">
                            <h5>Payment Breakdown</h5>
                            <div class="breakdown-item">
                                <span>Principal Amount</span>
                                <span id="principalAmount">₹2,50,000.00</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Total Interest</span>
                                <span id="breakdownInterest">₹4,04,000.00</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Additional Fees</span>
                                <span id="additionalFees">₹0.00</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Total Payment</span>
                                <span id="breakdownTotalPayment">₹9,04,000.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-container">
                <ul class="nav nav-tabs" id="loanTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="amortization-tab" data-bs-toggle="tab" data-bs-target="#amortization" type="button" role="tab">Amortization Schedule</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="yearly-tab" data-bs-toggle="tab" data-bs-target="#yearly" type="button" role="tab">Yearly Breakdown</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="distribution-tab" data-bs-toggle="tab" data-bs-target="#distribution" type="button" role="tab">Payment Distribution</button>
                    </li>
                </ul>
                <div class="tab-content" id="loanTabsContent">
                    <div class="tab-pane fade show active" id="amortization" role="tabpanel">
                        <div class="breakdown-card">
                            <h5>Amortization Schedule (All Months)</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover amortization-table">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Payment</th>
                                            <th>Principal</th>
                                            <th>Interest</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="amortizationTable">
                                        <!-- Amortization data will be inserted here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="yearly" role="tabpanel">
                        <div class="breakdown-card">
                            <h5>Yearly Payment Breakdown</h5>
                            <div id="yearlyBreakdown">
                                <!-- Yearly breakdown will be inserted here by JavaScript -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="distribution" role="tabpanel">
                        <div class="breakdown-card">
                            <h5>Payment Distribution Over Time</h5>
                            <div class="payment-distribution-chart">
                                <canvas id="paymentDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize variables
            let paymentDistributionChart = null;
            let currentInterestType = 'simple';
            
            // Format currency in Indian style with decimals
            function formatCurrency(amount) {
                return new Intl.NumberFormat('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                    style: 'currency',
                    currency: 'INR'
                }).format(amount);
            }
            
            // Format percentage with decimals
            function formatPercentage(value) {
                return `${parseFloat(value).toFixed(2)}%`;
            }
            
            // Update slider value displays
            function updateSliderValues() {
                $('#loanAmountValue').text(formatCurrency(parseInt($('#loanAmount').val())));
                $('#interestRateValue').text(formatPercentage($('#interestRate').val()));
                $('#loanTenureValue').text(`${$('#loanTenure').val()} year${$('#loanTenure').val() > 1 ? 's' : ''}`);
            }
            
            // Calculate EMI based on interest type
            function calculateEMI(principal, annualRate, years, interestType) {
                if (principal === 0 || annualRate === 0 || years === 0) return 0;
                
                const monthlyRate = annualRate / 12 / 100;
                const numberOfPayments = years * 12;
                
                if (interestType === 'simple') {
                    // Simple interest calculation
                    const totalInterest = principal * annualRate / 100 * years;
                    return (principal + totalInterest) / numberOfPayments;
                } else if (interestType === 'compound') {
                    // Standard compound interest (EMI formula)
                    if (monthlyRate === 0) {
                        return principal / numberOfPayments;
                    }
                    
                    const emi = principal * monthlyRate * 
                               Math.pow(1 + monthlyRate, numberOfPayments) / 
                               (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
                    
                    return emi;
                } else if (interestType === 'complex') {
                    // Complex interest with additional fees (2% of principal)
                    const additionalFees = principal * 0.02;
                    const adjustedPrincipal = principal + additionalFees;
                    
                    if (monthlyRate === 0) {
                        return adjustedPrincipal / numberOfPayments;
                    }
                    
                    const emi = adjustedPrincipal * monthlyRate * 
                               Math.pow(1 + monthlyRate, numberOfPayments) / 
                               (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
                    
                    return emi;
                }
                
                return 0;
            }
            
            // Calculate additional fees for complex interest
            function calculateAdditionalFees(principal, interestType) {
                if (interestType === 'complex') {
                    return principal * 0.02; // 2% of principal as additional fees
                }
                return 0;
            }
            
            // Generate amortization schedule
            function generateAmortizationSchedule(principal, annualRate, years, emi, interestType) {
                if (principal === 0 || annualRate === 0 || years === 0) return '';
                
                const monthlyRate = annualRate / 12 / 100;
                const numberOfPayments = years * 12;
                let balance = principal;
                let schedule = '';
                const additionalFees = calculateAdditionalFees(principal, interestType);
                
                // For complex interest, add fees to the first payment
                let feesAdded = false;
                
                for (let i = 1; i <= numberOfPayments; i++) {
                    let payment = emi;
                    let interest = 0;
                    let principalPaid = 0;
                    
                    if (interestType === 'simple') {
                        // For simple interest, interest is constant
                        interest = principal * annualRate / 100 / 12;
                        principalPaid = payment - interest;
                    } else {
                        // For compound and complex interest
                        interest = balance * monthlyRate;
                        principalPaid = payment - interest;
                    }
                    
                    // Add additional fees to first payment for complex interest
                    if (interestType === 'complex' && !feesAdded) {
                        payment += additionalFees;
                        feesAdded = true;
                    }
                    
                    balance -= principalPaid;
                    
                    // Add year separator
                    if (i === 1 || (i-1) % 12 === 0) {
                        const year = Math.ceil(i / 12);
                        schedule += `
                            <tr class="table-primary">
                                <td colspan="5" class="text-center fw-bold">Year ${year}</td>
                            </tr>
                        `;
                    }
                    
                    schedule += `
                        <tr>
                            <td>${i}</td>
                            <td>${formatCurrency(payment)}</td>
                            <td>${formatCurrency(principalPaid)}</td>
                            <td>${formatCurrency(interest)}</td>
                            <td>${formatCurrency(balance > 0 ? balance : 0)}</td>
                        </tr>
                    `;
                }
                
                return schedule;
            }
            
            // Generate yearly breakdown
            function generateYearlyBreakdown(principal, annualRate, years, emi, interestType) {
                if (principal === 0 || annualRate === 0 || years === 0) return '';
                
                const monthlyRate = annualRate / 12 / 100;
                const numberOfPayments = years * 12;
                let balance = principal;
                let yearlyHTML = '';
                const additionalFees = calculateAdditionalFees(principal, interestType);
                let feesAdded = false;
                
                for (let year = 1; year <= years; year++) {
                    let yearlyPrincipal = 0;
                    let yearlyInterest = 0;
                    let yearlyPayment = 0;
                    
                    for (let month = 1; month <= 12; month++) {
                        const paymentNumber = (year - 1) * 12 + month;
                        if (paymentNumber > numberOfPayments) break;
                        
                        let payment = emi;
                        let interest = 0;
                        let principalPaid = 0;
                        
                        if (interestType === 'simple') {
                            interest = principal * annualRate / 100 / 12;
                            principalPaid = payment - interest;
                        } else {
                            interest = balance * monthlyRate;
                            principalPaid = payment - interest;
                        }
                        
                        // Add additional fees to first payment for complex interest
                        if (interestType === 'complex' && !feesAdded) {
                            payment += additionalFees;
                            feesAdded = true;
                        }
                        
                        yearlyPrincipal += principalPaid;
                        yearlyInterest += interest;
                        yearlyPayment += payment;
                        
                        balance -= principalPaid;
                    }
                    
                    yearlyHTML += `
                        <div class="year-card">
                            <div class="year-header">
                                <span>Year ${year}</span>
                                <span>${formatCurrency(yearlyPayment)}</span>
                            </div>
                            <div class="year-details">
                                <div class="year-detail">
                                    <div class="year-detail-value">${formatCurrency(yearlyPrincipal)}</div>
                                    <div class="year-detail-label">Principal Paid</div>
                                </div>
                                <div class="year-detail">
                                    <div class="year-detail-value">${formatCurrency(yearlyInterest)}</div>
                                    <div class="year-detail-label">Interest Paid</div>
                                </div>
                                <div class="year-detail">
                                    <div class="year-detail-value">${formatCurrency(balance)}</div>
                                    <div class="year-detail-label">Remaining Balance</div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                return yearlyHTML;
            }
            
            // Create payment distribution chart
            function createPaymentDistributionChart(principal, annualRate, years, emi, interestType) {
                const ctx = document.getElementById('paymentDistributionChart').getContext('2d');
                
                // Destroy existing chart if it exists
                if (paymentDistributionChart) {
                    paymentDistributionChart.destroy();
                }
                
                const monthlyRate = annualRate / 12 / 100;
                const numberOfPayments = years * 12;
                let balance = principal;
                const additionalFees = calculateAdditionalFees(principal, interestType);
                let feesAdded = false;
                
                const labels = [];
                const principalData = [];
                const interestData = [];
                const feesData = [];
                
                for (let year = 1; year <= years; year++) {
                    labels.push(`Year ${year}`);
                    
                    let yearlyPrincipal = 0;
                    let yearlyInterest = 0;
                    let yearlyFees = 0;
                    
                    for (let month = 1; month <= 12; month++) {
                        const paymentNumber = (year - 1) * 12 + month;
                        if (paymentNumber > numberOfPayments) break;
                        
                        let payment = emi;
                        let interest = 0;
                        let principalPaid = 0;
                        
                        if (interestType === 'simple') {
                            interest = principal * annualRate / 100 / 12;
                            principalPaid = payment - interest;
                        } else {
                            interest = balance * monthlyRate;
                            principalPaid = payment - interest;
                        }
                        
                        // Add additional fees to first payment for complex interest
                        if (interestType === 'complex' && !feesAdded) {
                            yearlyFees += additionalFees;
                            feesAdded = true;
                        }
                        
                        yearlyPrincipal += principalPaid;
                        yearlyInterest += interest;
                        
                        balance -= principalPaid;
                    }
                    
                    principalData.push(yearlyPrincipal);
                    interestData.push(yearlyInterest);
                    feesData.push(yearlyFees);
                }
                
                const datasets = [
                    {
                        label: 'Principal',
                        data: principalData,
                        backgroundColor: '#1a3a5f',
                        borderColor: '#1a3a5f',
                        borderWidth: 1
                    },
                    {
                        label: 'Interest',
                        data: interestData,
                        backgroundColor: '#f8b500',
                        borderColor: '#f8b500',
                        borderWidth: 1
                    }
                ];
                
                // Add fees dataset only for complex interest
                if (interestType === 'complex') {
                    datasets.push({
                        label: 'Additional Fees',
                        data: feesData,
                        backgroundColor: '#dc3545',
                        borderColor: '#dc3545',
                        borderWidth: 1
                    });
                }
                
                paymentDistributionChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '₹' + value.toLocaleString('en-IN');
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += formatCurrency(context.raw);
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Validate inputs
            function validateInputs() {
                let isValid = true;
                
                // Reset errors
                $('.validation-error').hide();
                
                // Validate loan amount
                if ($('#loanAmount').val() < 0 || $('#loanAmount').val() > 500000) {
                    $('#loanAmountError').show();
                    isValid = false;
                }
                
                // Validate interest rate
                if ($('#interestRate').val() < 0 || $('#interestRate').val() > 15) {
                    $('#interestRateError').show();
                    isValid = false;
                }
                
                // Validate loan tenure
                if ($('#loanTenure').val() < 1 || $('#loanTenure').val() > 5) {
                    $('#loanTenureError').show();
                    isValid = false;
                }
                
                return isValid;
            }
            
            // Calculate and update all values
            function calculateAndUpdate() {
                if (!validateInputs()) return;
                
                const principal = parseInt($('#loanAmount').val());
                const annualRate = parseFloat($('#interestRate').val());
                const years = parseInt($('#loanTenure').val());
                
                // Calculate EMI
                const emi = calculateEMI(principal, annualRate, years, currentInterestType);
                
                // Calculate total values
                const totalPayment = emi * years * 12;
                const additionalFees = calculateAdditionalFees(principal, currentInterestType);
                const totalInterest = totalPayment - principal - additionalFees;
                const interestPercent = (totalInterest / totalPayment) * 100;
                
                // Update display values
                $('#emiValue').text(formatCurrency(emi));
                $('#totalInterestValue').text(formatCurrency(totalInterest));
                $('#totalPaymentValue').text(formatCurrency(totalPayment));
                $('#interestPercentage').text(formatPercentage(interestPercent));
                $('#principalAmount').text(formatCurrency(principal));
                $('#breakdownInterest').text(formatCurrency(totalInterest));
                $('#additionalFees').text(formatCurrency(additionalFees));
                $('#breakdownTotalPayment').text(formatCurrency(totalPayment));
                
                // Generate amortization schedule
                $('#amortizationTable').html(generateAmortizationSchedule(principal, annualRate, years, emi, currentInterestType));
                
                // Generate yearly breakdown
                $('#yearlyBreakdown').html(generateYearlyBreakdown(principal, annualRate, years, emi, currentInterestType));
                
                // Create payment distribution chart
                createPaymentDistributionChart(principal, annualRate, years, emi, currentInterestType);
                
                // Show savings tip if interest is high
                if (annualRate > 10) {
                    const potentialSavings = totalInterest * 0.1; // 10% of total interest
                    $('#savingsText').text(`You could save approximately ${formatCurrency(potentialSavings)} by negotiating a lower interest rate!`);
                    $('#savingsAlert').show();
                } else {
                    $('#savingsAlert').hide();
                }
                
                // Add pulse animation to results
                $('#emiValue, #totalInterestValue').addClass('pulse');
                setTimeout(() => {
                    $('#emiValue, #totalInterestValue').removeClass('pulse');
                }, 1500);
            }
            
            // Event listeners for real-time updates
            $('#loanAmount, #interestRate, #loanTenure').on('input', function() {
                updateSliderValues();
                calculateAndUpdate();
            });
            
            $('#calculateBtn').on('click', calculateAndUpdate);
            
            // Interest type selection
            $('.interest-type-card').on('click', function() {
                $('.interest-type-card').removeClass('selected');
                $(this).addClass('selected');
                currentInterestType = $(this).data('type');
                
                // Update interest type info
                let infoText = '';
                if (currentInterestType === 'simple') {
                    infoText = 'Simple interest is calculated only on the principal amount throughout the loan tenure.';
                } else if (currentInterestType === 'compound') {
                    infoText = 'Compound interest is calculated on the principal amount plus any accumulated interest from previous periods.';
                } else if (currentInterestType === 'complex') {
                    infoText = 'Complex interest includes additional fees and charges (2% of principal) added to the first payment.';
                }
                $('#interestTypeInfo').text(infoText);
                
                calculateAndUpdate();
            });
            
            // Initialize calculator
            updateSliderValues();
            calculateAndUpdate();
        });
    </script>
</body>
</html>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - Selvaganapathy Finance Group</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .tamil-text { font-family: 'Noto Sans Tamil', sans-serif; }
        
        /* Print Specific Styles */
        @media print {
            body { background-color: white; }
            .no-print { display: none !important; }
            .print-container { 
                box-shadow: none; 
                border: 1px solid #ddd; 
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10 px-4">

    <div class="print-container bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden relative">
        
        <div class="relative bg-gradient-to-br from-blue-900 to-blue-700 h-48 rounded-b-[40px] shadow-md text-center pt-8 px-4">
            
            <div class="relative z-10">
                <h1 class="text-white font-bold text-lg uppercase tracking-wider opacity-90">Selvaganapathy Finance</h1>
                <h2 class="text-yellow-300 font-bold text-sm tamil-text mt-1">செல்வகணபதி பைனான்ஸ்</h2>
                <div class="w-16 h-1 bg-yellow-400 mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="absolute top-[-50px] left-[-50px] w-32 h-32 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-[20px] right-[-20px] w-24 h-24 bg-yellow-400 opacity-20 rounded-full"></div>
        </div>

        <div class="relative z-20 -mt-16 flex justify-center">
            <div class="p-1.5 bg-white rounded-full shadow-lg">
                <img src="https://ui-avatars.com/api/?name=Senthil+Kumar&background=1e3a8a&color=fff&size=256" 
                     alt="Profile" 
                     class="w-32 h-32 rounded-full object-cover border-4 border-blue-50">
            </div>
        </div>

        <div class="text-center mt-4 px-6">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $profile->user->name ?? 'Senthil Kumar' }}
            </h2>
            
            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold mt-2 uppercase tracking-wide">
                {{ $profile->role ?? 'Senior Collection Agent' }}
            </span>

            <p class="text-gray-500 text-sm mt-2 font-mono">
                ID: {{ $profile->employee_id ?? 'EMP-2025-042' }}
            </p>
        </div>

        <div class="px-6 py-6 mt-2">
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 shadow-inner">
                
                <div class="grid grid-cols-2 gap-4 mb-4 border-b border-gray-200 pb-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Blood Group</p>
                        <p class="text-gray-800 font-medium flex items-center gap-2">
                            <i class="fas fa-tint text-red-500"></i> 
                            {{ $profile->blood_group ?? 'O+ve' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Date of Birth</p>
                        <p class="text-gray-800 font-medium flex items-center gap-2">
                            <i class="fas fa-birthday-cake text-purple-500"></i> 
                            {{ $profile->dob ?? '12 May, 1990' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Phone Number</p>
                        <a href="tel:{{ $profile->contact_number ?? '+919876543210' }}" class="text-blue-900 font-bold text-lg flex items-center gap-2 hover:underline">
                            <i class="fas fa-phone-alt text-green-600"></i> 
                            {{ $profile->contact_number ?? '+91 98765 43210' }}
                        </a>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Emergency Contact</p>
                        <p class="text-gray-700 font-medium flex items-center gap-2">
                            <i class="fas fa-user-shield text-orange-500"></i> 
                            {{ $profile->emergency_contact_number ?? '+91 88888 88888' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 text-center">
            <p class="text-xs text-gray-400 mb-2 uppercase tracking-widest">Scan to Verify</p>
            <div class="bg-white border-2 border-dashed border-gray-300 p-3 rounded-lg inline-block">
                @if(isset($profile->barcode_image))
                    <img src="{{ asset('img/barcodes/'.$profile->barcode_image) }}" alt="Barcode" style="height: 40px; width: 100%; max-width: 200px; object-fit: fill;">
                @else
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://selvaganapathyfinancegroup.com" alt="QR Code" class="w-24 h-24 mx-auto">
                @endif
            </div>
            <p class="text-[10px] text-gray-400 mt-2">Authorized Personnel Only</p>
        </div>

        <div class="bg-gray-900 text-white p-6 text-center text-sm relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="font-bold text-yellow-400 mb-1">Selvaganapathy Finance Group</h3>
                <p class="text-gray-400 text-xs mb-2">#24/1, Vellalar Street, Kodambakkam, Chennai - 600024</p>
                <a href="mailto:info@selvaganapathyfinancegroup.com" class="text-blue-300 text-xs hover:text-white transition">info@selvaganapathyfinancegroup.com</a>
            </div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 via-blue-500 to-yellow-400"></div>
        </div>

    </div>

    <!-- <div class="fixed bottom-6 w-full max-w-md px-4 flex gap-3 no-print z-50">
        <button onclick="window.print()" class="flex-1 bg-gray-800 text-white py-3 rounded-xl shadow-lg font-semibold hover:bg-gray-700 transition flex items-center justify-center gap-2">
            <i class="fas fa-print"></i> Print ID
        </button>
        <a href="tel:{{ $profile->contact_number ?? '' }}" class="flex-1 bg-green-600 text-white py-3 rounded-xl shadow-lg font-semibold hover:bg-green-700 transition flex items-center justify-center gap-2">
            <i class="fas fa-phone"></i> Call
        </a>
    </div> -->

</body>
</html>
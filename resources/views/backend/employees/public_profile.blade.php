<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - Selvaganapathy Finance Group</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .tamil-text { font-family: 'Noto Sans Tamil', sans-serif; }
        #map { 
            height: 180px; 
            border-radius: 10px;
            z-index: 1;
        }
        .leaflet-container { font-family: 'Poppins', sans-serif; font-size: 12px; }
        
        /* Compact spacing */
        .compact-p { padding: 0.75rem; }
        .compact-m { margin: 0.5rem 0; }
        .compact-text { font-size: 0.875rem; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 8px; }
        ::-webkit-scrollbar-thumb { background: #1e3a8a; border-radius: 8px; }
        
        /* Animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
        
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
            #map { height: 120px; }
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .profile-container {
                border-radius: 16px;
                margin: 0.5rem;
            }
            .compact-grid {
                grid-template-columns: 1fr !important;
                gap: 0.75rem !important;
            }
            .compact-padding {
                padding: 0.75rem !important;
            }
            #map { height: 150px; }
        }
        
        @media (min-width: 641px) and (max-width: 1024px) {
            .compact-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.75rem !important;
            }
        }
    </style>
</head>
<body class="min-h-screen p-2 md:p-4">
    <div class="max-w-6xl mx-auto">
        <!-- Compact Header -->
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 mb-4 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 md:w-24 md:h-24 bg-white opacity-10 rounded-full -mr-6 -mt-6 md:-mr-8 md:-mt-8"></div>
            
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-lg md:text-2xl font-bold">Selvaganapathy Finance Group</h1>
                        <h2 class="text-yellow-300 font-bold text-sm md:text-lg tamil-text mt-1">செல்வகணபதி பைனான்ஸ் குழு</h2>
                        <p class="mt-2 text-blue-100 text-xs md:text-sm max-w-2xl">Trusted financial services since 2025</p>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <span class="inline-block bg-white text-blue-900 px-3 py-1 rounded-lg font-bold text-xs md:text-sm">
                            Employee ID Portal
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content - Compact Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Employee Profile Card -->
            <div class="lg:col-span-2">
                <div class="profile-container bg-white rounded-xl md:rounded-2xl shadow-lg overflow-hidden animate-fade-in-up">
                    <!-- Compact Header -->
                    <div class="relative bg-gradient-to-br from-blue-900 to-blue-700 h-28 md:h-32 rounded-b-[30px] shadow-md text-center pt-6 px-4">
                        <div class="relative z-10">
                            <h2 class="text-white font-bold text-base md:text-lg uppercase tracking-wider">Employee Profile</h2>
                            <div class="w-16 h-0.5 bg-yellow-400 mx-auto mt-2 rounded-full"></div>
                        </div>
                    </div>

                    <!-- Compact Profile Image -->
                    <div class="relative z-20 -mt-12 flex justify-center">
                        <div class="p-1 bg-gradient-to-r from-blue-600 to-blue-800 rounded-full shadow-lg">
                            <img src="{{ asset('img/profile/'.$profile->profile_image) }}" 
                                 alt="Profile" 
                                 class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover border-3 border-white">
                        </div>
                    </div>

                    <!-- Compact Employee Info -->
                    <div class="text-center mt-3 px-4">
                        <h2 class="text-lg md:text-xl font-bold text-gray-800">
                            {{$profile->user->name}}
                        </h2>
                        
                        <span class="inline-block bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold mt-1 uppercase tracking-wide border border-blue-300">
                            {{$profile->role}}
                        </span>

                        <p class="text-gray-600 text-xs mt-1 font-mono bg-gray-50 inline-block px-2 py-0.5 rounded-md">
                            ID: {{$profile->employee_id}}
                        </p>
                    </div>

                    <!-- Compact Personal Details -->
                    <div class="px-4 py-4 mt-1">
                        <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-4 border border-gray-200">
                            <h3 class="text-base font-bold text-gray-800 mb-3 pb-1 border-b border-gray-300 flex items-center">
                                <i class="fas fa-id-card text-blue-600 mr-2 text-sm"></i> Personal Details
                            </h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Blood Group</p>
                                    <p class="text-gray-800 font-medium text-sm flex items-center">
                                        <i class="fas fa-tint text-red-500 mr-2 text-xs"></i> 
                                        {{$profile->blood_group}}
                                    </p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Date of Birth</p>
                                    <p class="text-gray-800 font-medium text-sm flex items-center">
                                        <i class="fas fa-birthday-cake text-purple-500 mr-2 text-xs"></i> 
                                        {{$profile->dob}}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Phone Number</p>
                                    <a href="tel:+91{{$profile->contact_number}}" class="text-blue-900 font-bold text-base flex items-center hover:text-blue-700 transition">
                                        <i class="fas fa-phone-alt text-green-600 mr-2 text-sm"></i> 
                                        +91 {{$profile->contact_number}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compact QR Code -->
                    <div class="px-4 pb-4 text-center">
                        <p class="text-xs text-gray-600 mb-2">Scan QR to verify employee</p>
                        <div class="bg-gradient-to-r from-blue-50 to-gray-50 border border-dashed border-blue-300 p-3 rounded-xl inline-block">
                            <div class="mb-1">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=SelvaganapathyFinanceGroup%3AEmployee%3A{{$profile->user->name}}%3A{{$profile->employee_id}}&format=svg&color=1e3a8a&bgcolor=ffffff" 
                                     alt="Employee QR Code" 
                                     class="w-36 h-36 md:w-40 md:h-40 mx-auto">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-green-500 mr-1 text-xs"></i> Authorized Personnel Only
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Compact Sidebar -->
            <div class="space-y-4 md:space-y-6">
                <!-- Company Details Card -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 animate-fade-in-up" style="animation-delay: 0.1s">
                    <h3 class="text-base font-bold text-gray-800 mb-3 pb-2 border-b border-gray-200 flex items-center">
                        <i class="fas fa-building text-blue-600 mr-2 text-sm"></i> Company Details
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-landmark text-blue-500 text-sm mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="font-bold text-gray-700 text-sm">Selvaganapathy Finance Group</h4>
                                <p class="text-gray-600 text-xs">Est. 2025</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-map-signs text-green-500 text-sm mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="font-bold text-gray-700 text-sm">Branch Network</h4>
                                <p class="text-gray-600 text-xs">01 branches across Tamil Nadu</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-users text-purple-500 text-sm mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="font-bold text-gray-700 text-sm">Employee Strength</h4>
                                <p class="text-gray-600 text-xs">7+ employees serving 100+ customers</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-handshake text-yellow-500 text-sm mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="font-bold text-gray-700 text-sm">Services</h4>
                                <p class="text-gray-600 text-xs">Loans & Financial Services</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <h4 class="font-bold text-gray-700 text-sm mb-2">Contact</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-blue-500 mr-2 text-xs"></i>
                                <a href="tel:+917358596377" class="text-gray-700 text-xs hover:text-blue-700">+91 73585 96377</a>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-red-500 mr-2 text-xs"></i>
                                <a href="mailto:sgfinancetech@gmail.com" class="text-gray-700 text-xs hover:text-blue-700">sgfinancetech@gmail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Location Map Card -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 animate-fade-in-up" style="animation-delay: 0.2s">
                    <h3 class="text-base font-bold text-gray-800 mb-3 pb-2 border-b border-gray-200 flex items-center">
                        <i class="fas fa-map-marked-alt text-red-500 mr-2 text-sm"></i> Office Location
                    </h3>
                    
                    <div id="map"></div>
                    
                    <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                        <h4 class="font-bold text-gray-700 text-sm mb-1">Head Office Address</h4>
                        <p class="text-gray-600 text-xs">
                            #24/1, Vellalar Street, Kodambakkam,<br>
                            Chennai - 600024, Tamil Nadu
                        </p>
                    </div>
                    
                    <div class="mt-3 flex gap-2">
                        <a href="https://maps.google.com/?q=13.0498,80.2129" target="_blank" class="flex-1 bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition flex items-center justify-center gap-1 text-xs">
                            <i class="fas fa-directions text-xs"></i> Directions
                        </a>
                        <button onclick="shareLocation()" class="flex-1 bg-gray-800 text-white py-2 rounded-lg font-medium hover:bg-gray-700 transition flex items-center justify-center gap-1 text-xs">
                            <i class="fas fa-share-alt text-xs"></i> Share
                        </button>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <!-- <div class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-xl md:rounded-2xl shadow-lg p-4 text-white animate-fade-in-up no-print" style="animation-delay: 0.3s">
                    <h3 class="text-base font-bold mb-3">Quick Actions</h3>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="window.print()" class="bg-white text-blue-900 py-2 rounded-lg font-medium hover:bg-blue-50 transition flex items-center justify-center gap-1 text-xs">
                            <i class="fas fa-print text-xs"></i> Print ID
                        </button>
                        
                        <a href="tel:+91{{$profile->contact_number}}" class="bg-green-600 text-white py-2 rounded-lg font-medium hover:bg-green-700 transition flex items-center justify-center gap-1 text-xs">
                            <i class="fas fa-phone text-xs"></i> Call
                        </a>
                        
                        <button onclick="downloadQR()" class="bg-yellow-500 text-gray-900 py-2 rounded-lg font-medium hover:bg-yellow-400 transition flex items-center justify-center gap-1 text-xs col-span-2">
                            <i class="fas fa-download text-xs"></i> Download QR Code
                        </button>
                    </div>
                </div> -->
            </div>
        </div>
        
        <!-- Compact Footer -->
        <div class="mt-4 text-center text-gray-500 text-xs">
            <p>© 2025 Selvaganapathy Finance Group. All rights reserved.</p>
            <p class="mt-0.5">Confidential document - Authorized use only</p>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize Map
        function initMap() {
            // Chennai coordinates (Kodambakkam area)
            const chennaiCoords = [13.0498, 80.2129];
            
            const map = L.map('map').setView(chennaiCoords, 16);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            
            // Custom icon
            const companyIcon = L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background-color:#1e3a8a; color:white; border-radius:50%; width:32px; height:32px; display:flex; align-items:center; justify-content:center; border:2px solid white; box-shadow:0 0 8px rgba(0,0,0,0.3)"><i class="fas fa-building text-xs"></i></div>',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            });
            
            // Add marker
            L.marker(chennaiCoords, {icon: companyIcon}).addTo(map)
                .bindPopup('<b>Selvaganapathy Finance Group</b><br>Head Office<br>Kodambakkam, Chennai')
                .openPopup();
        }
        
        // Initialize map after page load
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
        
        // Action Functions
        function downloadQR() {
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=SelvaganapathyFinanceGroup%3AEmployee%3A{{$profile->user->name}}%3A{{$profile->employee_id}}&format=png&color=1e3a8a&bgcolor=ffffff`;
            const link = document.createElement('a');
            link.href = qrUrl;
            link.download = `{{$profile->employee_id}}_QR.png`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        function shareLocation() {
            const shareText = `Selvaganapathy Finance Group - Head Office: #24/1, Vellalar Street, Kodambakkam, Chennai - 600024`;
            const shareUrl = `https://maps.google.com/?q=13.0498,80.2129`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Selvaganapathy Finance Group Location',
                    text: shareText,
                    url: shareUrl
                })
                .then(() => console.log('Location shared successfully'))
                .catch((error) => console.log('Error sharing:', error));
            } else {
                // Fallback for browsers that don't support Web Share API
                navigator.clipboard.writeText(`${shareText}\n${shareUrl}`).then(() => {
                    alert('Address copied to clipboard!');
                });
            }
        }
        
        // Print functionality with keyboard shortcut
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
        
        // Auto-adjust map size on window resize
        window.addEventListener('resize', function() {
            setTimeout(() => {
                const map = L.DomUtil.get('map');
                if (map && map._leaflet_id) {
                    map._leaflet_map.invalidateSize();
                }
            }, 100);
        });
    </script>
</body>
</html>
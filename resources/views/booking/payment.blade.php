<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Kos Arcadia') }} - Secure Payment</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Be+Vietnam+Pro:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed-dim": "#aacdd1",
                        "surface-bright": "#fbf9f5",
                        "on-error": "#ffffff",
                        "surface-variant": "#e4e2de",
                        "secondary": "#456554",
                        "on-primary-container": "#84a6ab",
                        "background": "#fbf9f5",
                        "error": "#ba1a1a",
                        "on-background": "#1b1c1a",
                        "surface-container-low": "#f5f3ef",
                        "primary": "#00262a",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-container": "#4b6b5a",
                        "tertiary": "#2e1f07",
                        "inverse-on-surface": "#f2f0ed",
                        "on-secondary-fixed": "#012114",
                        "secondary-fixed-dim": "#accfba",
                        "surface-container": "#efeeea",
                        "tertiary-fixed": "#fbdeb9",
                        "tertiary-container": "#46341a",
                        "surface-dim": "#dbdad6",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#e4e2de",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed-variant": "#2e4d3e",
                        "error-container": "#ffdad6",
                        "surface-container-high": "#eae8e4",
                        "on-surface-variant": "#414849",
                        "on-secondary": "#ffffff",
                        "on-tertiary-container": "#b69c7b",
                        "outline": "#717879",
                        "on-primary-fixed": "#001f23",
                        "primary-container": "#1a3c40",
                        "surface-tint": "#436468",
                        "on-tertiary": "#ffffff",
                        "on-surface": "#1b1c1a",
                        "inverse-surface": "#30312e",
                        "inverse-primary": "#aacdd1",
                        "on-tertiary-fixed-variant": "#564428",
                        "primary-fixed": "#c5e9ee",
                        "outline-variant": "#c1c8c9",
                        "tertiary-fixed-dim": "#dec29f",
                        "secondary-container": "#c7ebd6",
                        "surface": "#fbf9f5",
                        "on-primary-fixed-variant": "#2b4c50",
                        "secondary-fixed": "#c7ebd6",
                        "on-tertiary-fixed": "#271903"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "section-gap-mobile": "40px",
                        "base": "8px",
                        "gutter": "16px",
                        "container-padding": "24px",
                        "section-gap-desktop": "80px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Montserrat"],
                        "display-lg": ["Montserrat"],
                        "headline-lg-mobile": ["Montserrat"],
                        "headline-md": ["Montserrat"],
                        "body-lg": ["Be Vietnam Pro"],
                        "body-md": ["Be Vietnam Pro"],
                        "label-lg": ["Be Vietnam Pro"],
                        "label-sm": ["Be Vietnam Pro"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-lg": ["14px", {"lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .backdrop-blur-custom {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .custom-shadow {
            box-shadow: 0 10px 40px -10px rgba(26, 60, 64, 0.08);
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface">
    <header class="docked full-width top-0 sticky z-50 bg-surface/80 backdrop-blur-md border-b border-outline-variant/30 shadow-sm shadow-primary/5">
        <div class="flex justify-between items-center w-full px-container-padding py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-2">
                <a href="{{ url('/') }}" class="font-display-lg text-display-lg font-bold text-primary tracking-tight">Kos Arcadia</a>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/rooms') }}">Rooms</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/amenities') }}">Amenities</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/location') }}">Location</a>
            </nav>
            <div class="flex items-center gap-4">
                <button onclick="window.location.href='{{ url('/booking') }}'" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-label-lg text-label-lg font-bold hover:bg-primary-container transition-all active:scale-95 duration-150">
                    Book Now
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-container-padding py-section-gap-mobile md:py-section-gap-desktop">
        <form action="{{ route('booking.checkout', $booking) }}" method="POST" enctype="multipart/form-data" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-7 space-y-8">
                    <div>
                        <h1 class="font-headline-lg text-headline-lg text-primary mb-2">Secure Checkout</h1>
                        <p class="text-on-surface-variant">Complete your reservation for a tropical luxury experience.</p>
                    </div>

                    <section class="bg-surface-container-lowest rounded-xl p-6 custom-shadow border border-outline-variant/10">
                        <h2 class="font-headline-md text-headline-md text-primary mb-6">Payment Method</h2>
                        
                        {{-- Show Validation Errors if any exist --}}
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-error-container text-on-error-container rounded-lg font-label-sm">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <label class="relative flex items-center p-4 border border-outline-variant rounded-xl cursor-pointer hover:bg-primary/5 transition-all group has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input checked class="hidden peer" name="payment_method" value="qr" type="radio">
                                <span class="material-symbols-outlined text-primary mr-4" data-icon="qr_code">qr_code</span>
                                <div class="flex-grow">
                                    <span class="font-label-lg text-label-lg text-on-surface block">QR Payment</span>
                                    <span class="text-label-sm text-on-surface-variant">Scan QR code to pay instantly</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-outline rounded-full flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 border border-outline-variant rounded-xl cursor-pointer hover:bg-primary/5 transition-all group has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input class="hidden peer" name="payment_method" value="bank_transfer" type="radio">
                                <span class="material-symbols-outlined text-primary mr-4" data-icon="account_balance">account_balance</span>
                                <div class="flex-grow">
                                    <span class="font-label-lg text-label-lg text-on-surface block">Bank Transfer</span>
                                    <span class="text-label-sm text-on-surface-variant">BCA, Mandiri, BNI (Manual Verification)</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-outline rounded-full flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            </label>
                        </div>

                        <div class="mt-8 flex flex-col items-center justify-center p-6 bg-surface-container-low rounded-xl border border-outline-variant/30" id="qr-details">
                            <p class="font-label-lg text-label-lg text-primary mb-4">Scan QR Code to Pay</p>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-outline-variant/20">
                                {!! $qrCode !!}
                            </div>
                            <div class="mt-4 space-y-2 text-center">
                                <p class="font-label-sm text-label-sm text-on-surface-variant">Bank <span class="font-bold text-primary">{{ $bankName }}</span></p>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">No. Rekening <span class="font-bold text-primary">{{ $bankAccount }}</span></p>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">A.N <span class="font-bold text-primary">{{ $bankHolder }}</span></p>
                                <p class="font-headline-md text-headline-md text-primary mt-3">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-label-sm text-on-surface-variant mt-4 text-center">Setelah transfer, unggah bukti pembayaran di bawah.</p>
                        </div>
                    </section>

                    <section id="proof-upload" class="flex bg-surface-container-lowest rounded-xl p-6 border-2 border-dashed border-outline-variant/50 flex-col items-center justify-center text-center">
                        <span class="material-symbols-outlined text-primary text-4xl mb-2" data-icon="cloud_upload">cloud_upload</span>
                        <p class="font-label-lg text-label-lg text-on-surface">Upload Proof of Payment</p>
                        <p class="text-label-sm text-on-surface-variant mt-1">Upload your payment receipt here (PNG, JPG, PDF)</p>
                        <input type="file" name="payment_receipt" id="payment_receipt" class="hidden" accept=".png, .jpg, .jpeg, .pdf">
                        <label for="payment_receipt" class="mt-4 text-primary font-bold hover:underline cursor-pointer">Choose File</label>
                        <span id="file-name-display" class="block mt-2 text-label-sm text-secondary"></span>
                    </section>
                </div>

                <aside class="lg:col-span-5 space-y-6">
                    <div class="bg-primary-container text-on-primary-fixed-dim rounded-2xl overflow-hidden custom-shadow">
                        <div class="relative h-48">
                            <img class="w-full h-full object-cover" data-alt="A luxurious minimalist bedroom in a tropical villa in Lombok." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYSdAP2lpPqXLqHSKui0wJV-SY-gJwfhvowlb6X1x1kkdwsKZGijzQbfe9o1XfjApgkO3auPaZqZZi_eRHWR1488OfOrPgPUxUbYhgffIhtLrTgjBf_ghEMDP1w4TuWa9kujOGsCOHcCx3B9uAKNQGIQXg0xle4VriOsX3tae2uNN6cInCjdP3KSyHySZJaYzp0NzoHPCWk7SoGwfBEh383ydOJdtcLIkWAdEAdB9vQ1tfSOUi2xnVcm35o5EhWa51uhJvuRAdO7U">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
                            <div class="absolute bottom-4 left-6">
                                <span class="bg-secondary text-on-secondary text-label-sm px-3 py-1 rounded-full uppercase tracking-wider">{{ $booking->room->roomType->name }}</span>
                                <h3 class="font-headline-md text-headline-md text-white mt-1">{{ $roomName ?? 'The Azure Loft' }}</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center text-surface-bright/80 border-b border-white/10 pb-4">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm" data-icon="calendar_today">calendar_today</span>
                                    <span class="font-label-lg">Duration</span>
                                </div>
                                <span class="font-bold text-white">{{ $duration ?? '6 Months' }}</span>
                            </div>
                            <div class="space-y-3 pt-2">
                                <div class="flex justify-between items-center text-surface-bright/70">
                                    <span>Monthly Rent</span>
                                    <span>Rp {{ number_format($monthlyRent ?? 8500000, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-surface-bright/70">
                                    <span>Security Deposit</span>
                                    <span>Rp {{ number_format($deposit ?? 2000000, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-surface-bright/70">
                                    <span>Service Fee</span>
                                    <span>Rp {{ number_format($serviceFee ?? 150000, 0, ',', '.') }}</span>
                                </div>
                                <div class="pt-4 border-t border-white/20 flex justify-between items-end">
                                    <div>
                                        <p class="text-label-sm text-surface-bright/60 uppercase">Total Amount</p>
                                        <p class="font-headline-lg text-headline-lg text-white">Rp {{ number_format($totalAmount ?? 53150000, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-label-sm text-primary-fixed-dim">Inc. Taxes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface-container-high rounded-xl p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary" data-icon="verified_user" data-weight="fill">verified_user</span>
                            <div>
                                <p class="font-label-lg text-on-surface">Secure SSL Encryption</p>
                                <p class="text-label-sm text-on-surface-variant">Your transaction is protected by industry-leading 256-bit encryption.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary" data-icon="shield_checkered" data-weight="fill">shield</span>
                            <div>
                                <p class="font-label-lg text-on-surface">Managed Protection</p>
                                <p class="text-label-sm text-on-surface-variant">Payments are escrowed until move-in for your peace of mind.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-xl font-headline-md text-headline-md hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-[0.98]">
                        Complete Payment
                    </button>
                    <p class="text-center text-label-sm text-on-surface-variant">
                        By clicking "Complete Payment", you agree to Kos Arcadia's 
                        <a class="underline" href="{{ url('/terms') }}">Rental Terms</a> and <a class="underline" href="{{ url('/privacy') }}">Privacy Policy</a>.
                    </p>
                </aside>
            </div>
        </form>
    </main>

    <footer class="full-width bg-surface-container-highest border-t border-outline-variant/20 mt-section-gap-desktop">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-section-gap-mobile md:gap-section-gap-desktop w-full px-container-padding py-16 max-w-7xl mx-auto">
            <div class="md:col-span-1">
                <span class="font-headline-md text-headline-md font-bold text-primary mb-4 block">Kos Arcadia</span>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Luxury managed boarding in the heart of Lombok. Experience the perfect blend of comfort and tranquility.
                </p>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg font-bold text-primary mb-4">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ url('/about') }}">About Us</a></li>
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ url('/contact') }}">Contact</a></li>
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ url('/privacy') }}">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg font-bold text-primary mb-4">Support</h4>
                <ul class="space-y-3">
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ url('/faq') }}">FAQ</a></li>
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ url('/terms') }}">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg font-bold text-primary mb-4">Newsletter</h4>
                <p class="font-label-sm text-label-sm text-on-surface-variant mb-4">Get the latest updates on new units and seasonal offers.</p>
                <form action="{{ url('/newsletter') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input name="email" class="bg-surface-container border border-outline-variant rounded-lg px-3 py-2 text-label-sm w-full outline-none focus:ring-1 focus:ring-primary" placeholder="Email" type="email" required>
                    <button type="submit" class="bg-primary text-on-primary px-4 rounded-lg"><span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span></button>
                </form>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-container-padding pb-8">
            <p class="font-label-sm text-label-sm text-on-surface-variant text-center opacity-60">
                © {{ date('Y') }} Kos Arcadia Lombok. Luxury Managed Boarding.
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrDetails = document.getElementById('qr-details');
            const proofUpload = document.getElementById('proof-upload');
            const fileInput = document.getElementById('payment_receipt');
            const fileNameDisplay = document.getElementById('file-name-display');

            document.querySelectorAll('input[name="payment_method"]').forEach(input => {
                input.addEventListener('change', (e) => {
                    const selectedMethod = e.target.value;

                    if (selectedMethod === 'qr') {
                        qrDetails.style.display = 'flex';
                        proofUpload.style.display = 'flex';
                    } else {
                        qrDetails.style.display = 'none';
                        proofUpload.style.display = 'flex';
                    }
                });
            });

            // Show selected filename
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    fileNameDisplay.textContent = 'Selected: ' + e.target.files[0].name;
                } else {
                    fileNameDisplay.textContent = '';
                }
            });
        });
    </script>
</body>
</html>
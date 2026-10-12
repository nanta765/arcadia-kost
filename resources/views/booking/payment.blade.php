<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Kost — Secure Payment</title>
    <link rel="icon" href="{{ asset('images/arcadia-logo.jpg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD,opsz@300,0,0,24" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#0A0A0A",
                        canvas: "#FFFFFF",
                        surface: "#F3F4F6",
                        "border-subtle": "#E5E7EB",
                        "text-secondary": "#4B5563"
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    spacing: {
                        'section': '120px',
                    }
                }
            }
        }
    </script>
    <style>
        .footer-stroke-draw {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: drawIn 4s ease-in-out forwards;
        }
        @keyframes drawIn {
            to { stroke-dashoffset: 0; }
        }
    </style>
</head>
<body class="bg-canvas text-primary font-sans antialiased">

    {{-- Navbar — same as landing page --}}
    <nav id="navbar" class="fixed top-0 w-full bg-white/40 backdrop-blur-xl border-b border-white/20 shadow-sm shadow-black/5 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 md:px-12 h-20 flex items-center justify-between">
            <div class="flex items-center">
                @if(file_exists(public_path('images/arcadia-logo-no-bg.png')))
                <img src="{{ asset('images/arcadia-logo-no-bg.png') }}" alt="Arcadia" class="h-14 md:h-16 w-auto">
                @else
                <span class="font-sans font-semibold tracking-widest uppercase text-sm">Arca</span>
                @endif
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">Dashboard</a>
                <a href="{{ url('/') }}" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">Home</a>
                <a href="{{ route('booking.page') }}" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">Bookings</a>
            </div>
            <div class="flex items-center gap-3">
                @if(auth()->user()->profile_photo)
                <a href="{{ route('dashboard') }}" class="rounded-full overflow-hidden border-2 border-white/40 hover:border-white/80 transition-all" style="width: 38px; height: 38px;" title="Dashboard">
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                </a>
                @else
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center rounded-full bg-white/30 backdrop-blur-sm border-2 border-white/40 text-primary hover:border-white/80 transition-all" style="width: 38px; height: 38px;" title="Dashboard">
                    <span class="material-symbols-outlined text-xl">person</span>
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-5 py-2 rounded-full border border-border-subtle text-sm font-medium text-text-secondary hover:bg-white/50 hover:text-primary transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Stepper --}}
    <div class="pt-28 mb-8">
        <div class="flex items-center justify-between max-w-xl mx-auto relative">
            <div class="absolute top-1/2 left-0 w-full h-0.5 bg-primary -translate-y-1/2 -z-10"></div>

            <a href="{{ route('booking.page') }}" class="flex flex-col items-center gap-2 group">
                <div class="w-10 h-10 rounded-full bg-primary/20 text-primary/50 flex items-center justify-center text-sm font-bold">
                    <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">check</span>
                </div>
                <span class="text-xs font-semibold text-primary/50">Select Room</span>
            </a>
            <a href="{{ route('booking.details', $booking->room_id) }}" class="flex flex-col items-center gap-2 group">
                <div class="w-10 h-10 rounded-full bg-primary/20 text-primary/50 flex items-center justify-center text-sm font-bold">
                    <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">check</span>
                </div>
                <span class="text-xs font-semibold text-primary/50">Details</span>
            </a>
            <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">3</div>
                <span class="text-xs font-semibold text-primary">Payment</span>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-6 md:px-12 pb-16">
        <form action="{{ route('booking.checkout', $booking) }}" method="POST" enctype="multipart/form-data" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

                {{-- Left: Payment Form --}}
                <div class="lg:col-span-7 space-y-8">
                    <div>
                        <h1 class="text-2xl font-bold text-primary mb-2">Secure Checkout</h1>
                        <p class="text-text-secondary text-sm">Complete your reservation for a premium living experience.</p>
                    </div>

                    {{-- Payment Method --}}
                    <section class="bg-white rounded-2xl p-6 border border-border-subtle shadow-sm">
                        <h2 class="text-lg font-bold text-primary mb-6">Payment Method</h2>

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-50 text-red-600 rounded-xl text-xs">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-3">
                            <label class="relative flex items-center p-4 border border-border-subtle rounded-xl cursor-pointer hover:bg-surface transition-all has-[:checked]:border-primary has-[:checked]:bg-surface/50">
                                <input checked class="hidden peer" name="payment_method" value="bank_transfer" type="radio">
                                <span class="material-symbols-outlined text-primary mr-4">account_balance</span>
                                <div class="flex-grow">
                                    <span class="text-sm font-semibold text-primary block">Bank Transfer</span>
                                    <span class="text-xs text-text-secondary">Transfer to our bank account, then upload your proof (Manual Verification)</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-border-subtle rounded-full flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 border border-border-subtle rounded-xl cursor-pointer hover:bg-surface transition-all has-[:checked]:border-primary has-[:checked]:bg-surface/50">
                                <input class="hidden peer" name="payment_method" value="on_site" type="radio">
                                <span class="material-symbols-outlined text-primary mr-4">storefront</span>
                                <div class="flex-grow">
                                    <span class="text-sm font-semibold text-primary block">Pay on Site</span>
                                    <span class="text-xs text-text-secondary">Pay directly at the kost — no upload required</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-border-subtle rounded-full flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            </label>
                        </div>

                        {{-- Bank transfer details --}}
                        <div class="mt-6 flex flex-col items-center justify-center p-6 bg-surface rounded-xl border border-border-subtle" id="bank-details">
                            <p class="text-sm font-semibold text-primary mb-4">Transfer to the following account</p>
                            <div class="w-full space-y-2 text-center">
                                <p class="text-xs text-text-secondary">Bank <span class="font-bold text-primary">{{ $bankName }}</span></p>
                                <p class="text-xs text-text-secondary">No. Rekening <span class="font-bold text-primary">{{ $bankAccount }}</span></p>
                                <p class="text-xs text-text-secondary">A.N <span class="font-bold text-primary">{{ $bankHolder }}</span></p>
                                <p class="text-lg font-bold text-primary mt-3">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-xs text-text-secondary mt-4 text-center">After transferring, upload your proof of payment below.</p>
                        </div>

                        {{-- On site note --}}
                        <div class="mt-6 p-6 bg-surface rounded-xl border border-border-subtle hidden" id="on-site-details">
                            <p class="text-sm text-text-secondary text-center">
                                Please pay <span class="font-bold text-primary">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                directly at the kost. Your booking will be marked for review and confirmed by the owner.
                            </p>
                        </div>
                    </section>

                    {{-- Upload Proof (bank transfer only) --}}
                    <section id="proof-upload" class="bg-white rounded-2xl p-6 border-2 border-dashed border-border-subtle">
                        <div id="upload-prompt" class="flex flex-col items-center justify-center text-center">
                            <span class="material-symbols-outlined text-primary text-4xl mb-2">cloud_upload</span>
                            <p class="text-sm font-semibold text-primary">Upload Proof of Payment</p>
                            <p class="text-xs text-text-secondary mt-1">Upload your transfer receipt here (PNG, JPG)</p>
                            <input type="file" name="payment_receipt" id="payment_receipt" class="hidden" accept="image/*">
                            <label for="payment_receipt" class="mt-4 text-sm text-primary font-semibold hover:underline cursor-pointer">Choose File</label>
                        </div>
                        <div id="upload-preview" class="hidden flex flex-col items-center text-center">
                            <img id="preview-image" class="w-full max-h-64 object-contain rounded-xl mb-3" src="" alt="Payment preview">
                            <span id="file-name-display" class="text-xs text-text-secondary mb-1"></span>
                            <label for="payment_receipt" class="text-xs text-primary font-semibold hover:underline cursor-pointer">Change File</label>
                        </div>
                    </section>
                </div>

                {{-- Right: Summary Sidebar --}}
                <aside class="lg:col-span-5 space-y-6">
                    <div class="bg-[#0A0A0A] text-white rounded-2xl overflow-hidden shadow-lg">
                        <div class="relative h-48">
                            <img class="w-full h-full object-cover" alt="Room preview" src="{{ asset('images/gallery/front-room.jpeg') }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
                            <div class="absolute bottom-4 left-6">
                                <span class="bg-white/20 text-white text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">{{ $booking->room->roomType->name }}</span>
                                <h3 class="text-lg font-bold text-white mt-1">{{ $roomName ?? 'The Azure Loft' }}</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center text-white/80 border-b border-white/10 pb-4">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    <span class="text-sm font-medium">Duration</span>
                                </div>
                                <span class="font-bold text-white">{{ $duration ?? '6 Months' }}</span>
                            </div>
                            <div class="space-y-3 pt-2">
                                <div class="flex justify-between items-center text-white/60 text-xs">
                                    <span>Monthly Rent</span>
                                    <span>Rp {{ number_format($monthlyRent ?? 8500000, 0, ',', '.') }}</span>
                                </div>
                                <div class="pt-4 border-t border-white/20 flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] text-white/40 uppercase">Total Amount</p>
                                        <p class="text-xl font-bold text-white">Rp {{ number_format($totalAmount ?? 53150000, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-[10px] text-white/40">Inc. Taxes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Security Info --}}
                    <div class="bg-white rounded-2xl border border-border-subtle p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-xl">verified_user</span>
                            <div>
                                <p class="text-sm font-semibold text-primary">Secure SSL Encryption</p>
                                <p class="text-xs text-text-secondary">Your transaction is protected by industry-leading 256-bit encryption.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-xl">shield</span>
                            <div>
                                <p class="text-sm font-semibold text-primary">Managed Protection</p>
                                <p class="text-xs text-text-secondary">Payments are escrowed until move-in for your peace of mind.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl text-sm font-semibold hover:bg-black/80 transition-all active:scale-[0.98]">
                        Complete Payment
                    </button>
                    <p class="text-center text-xs text-text-secondary">
                        By clicking "Complete Payment", you agree to Kos Arcadia's
                        <a class="underline font-medium text-primary" href="{{ url('/terms') }}">Rental Terms</a> and <a class="underline font-medium text-primary" href="{{ url('/privacy') }}">Privacy Policy</a>.
                    </p>
                </aside>
            </div>
        </form>
    </main>

    {{-- Footer — same as landing page --}}
    <footer class="relative bg-[#0A0A0A] text-white overflow-hidden" x-data="footerTextEffect()">
        <div class="absolute inset-0 z-0" style="background: radial-gradient(125% 125% at 50% 0%, #0F0F1166 50%, #3ca2fa22 100%);"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 pt-20 pb-10">
            <div class="mb-16 -mt-4">
                <svg x-ref="svg" width="100%" height="140" viewBox="0 0 900 140" xmlns="http://www.w3.org/2000/svg"
                    class="select-none cursor-default"
                    @mousemove="onMove($event)" @mouseenter="hovered = true" @mouseleave="hovered = false">
                    <defs>
                        <radialGradient id="frReveal" gradientUnits="userSpaceOnUse" :cx="maskCx" :cy="maskCy" r="18%">
                            <stop offset="0%" stop-color="white" />
                            <stop offset="100%" stop-color="black" />
                        </radialGradient>
                        <mask id="frMask">
                            <rect x="0" y="0" width="900" height="140" fill="url(#frReveal)" />
                        </mask>
                    </defs>
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
                        stroke-width="1" fill="none" stroke="#ffffff"
                        font-family="Inter, sans-serif" font-size="120" font-weight="700" letter-spacing="-2"
                        :opacity="hovered ? 0.15 : 0">ARCADIA</text>
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
                        stroke-width="1" fill="none" stroke="#ffffff"
                        font-family="Inter, sans-serif" font-size="120" font-weight="700" letter-spacing="-2"
                        class="footer-stroke-draw">ARCADIA</text>
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
                        stroke="#ffffff" stroke-width="1" fill="none"
                        mask="url(#frMask)"
                        font-family="Inter, sans-serif" font-size="120" font-weight="700" letter-spacing="-2">ARCADIA</text>
                </svg>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-16">
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-widest text-white/40 mb-5">Kos Arcadia</h4>
                    <p class="text-white/60 text-sm leading-relaxed max-w-xs">
                        Premium managed boarding in the heart of Mataram, Lombok. A sanctuary for students and professionals who value peace, cleanliness, and intentional living.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-widest text-white/40 mb-5">Navigate</h4>
                    <ul class="space-y-3 text-sm text-white/60">
                        <li><a href="{{ url('/') }}#about" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="{{ url('/') }}#facility" class="hover:text-white transition-colors">Facilities</a></li>
                        <li><a href="{{ url('/') }}#room" class="hover:text-white transition-colors">The Room</a></li>
                        <li><a href="{{ url('/') }}#location" class="hover:text-white transition-colors">Location</a></li>
                        <li><a href="{{ url('/book') }}" class="hover:text-white transition-colors">Book a Room</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-widest text-white/40 mb-5">Contact</h4>
                    <ul class="space-y-3 text-sm text-white/60">
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-white/30">location_on</span>
                            Mataram, Lombok, NTB
                        </li>
                        <li>
                            <a href="mailto:arcadiakost@gmail.com" class="flex items-center gap-2 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm text-white/30">mail</span>
                                arcadiakost@gmail.com
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/6280000000" class="flex items-center gap-2 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm text-white/30">call</span>
                                WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center border-t border-white/10 pt-8 text-xs text-white/30 uppercase tracking-widest gap-4">
                <div>&copy; {{ date('Y') }} Kos Arcadia. All rights reserved.</div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white/60 transition-colors">Instagram</a>
                    <a href="#" class="hover:text-white/60 transition-colors">Terms</a>
                    <a href="#" class="hover:text-white/60 transition-colors">Privacy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function footerTextEffect() {
            return {
                hovered: false,
                maskCx: '50%',
                maskCy: '50%',
                onMove(e) {
                    const rect = this.$refs.svg.getBoundingClientRect();
                    this.maskCx = ((e.clientX - rect.left) / rect.width * 100) + '%';
                    this.maskCy = ((e.clientY - rect.top) / rect.height * 100) + '%';
                },
            };
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankDetails = document.getElementById('bank-details');
            const onSiteDetails = document.getElementById('on-site-details');
            const proofUpload = document.getElementById('proof-upload');
            const fileInput = document.getElementById('payment_receipt');
            const fileNameDisplay = document.getElementById('file-name-display');

            function applyMethod(method) {
                if (method === 'bank_transfer') {
                    bankDetails.style.display = 'flex';
                    onSiteDetails.style.display = 'none';
                    proofUpload.style.display = 'block';
                } else {
                    bankDetails.style.display = 'none';
                    onSiteDetails.style.display = 'block';
                    proofUpload.style.display = 'none';
                }
            }

            document.querySelectorAll('input[name="payment_method"]').forEach(input => {
                input.addEventListener('change', (e) => applyMethod(e.target.value));
            });

            // Initialise based on the pre-checked option
            const checked = document.querySelector('input[name="payment_method"]:checked');
            applyMethod(checked ? checked.value : 'bank_transfer');

            fileInput.addEventListener('change', function(e) {
                const uploadPrompt = document.getElementById('upload-prompt');
                const uploadPreview = document.getElementById('upload-preview');
                const previewImage = document.getElementById('preview-image');

                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    fileNameDisplay.textContent = file.name;

                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            previewImage.src = ev.target.result;
                            uploadPrompt.classList.add('hidden');
                            uploadPreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        uploadPrompt.classList.add('hidden');
                        uploadPreview.classList.remove('hidden');
                        previewImage.src = '';
                        previewImage.classList.add('hidden');
                    }
                } else {
                    fileNameDisplay.textContent = '';
                    uploadPrompt.classList.remove('hidden');
                    uploadPreview.classList.add('hidden');
                    previewImage.classList.remove('hidden');
                }
            });
        });
    </script>

</body>
</html>

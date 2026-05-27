<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Kost — Booking Details</title>
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
<body class="bg-surface text-primary font-sans antialiased">

    {{-- Navbar --}}
    <nav class="fixed top-0 w-full bg-white/40 backdrop-blur-xl border-b border-white/20 shadow-sm shadow-black/5 z-50">
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

    <main class="max-w-4xl mx-auto px-6 pt-28 pb-16">
        {{-- Stepper --}}
        <div class="mb-14">
            <div class="flex items-center justify-between max-w-xl mx-auto relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-surface -translate-y-1/2 -z-10"></div>
                <div class="absolute top-1/2 left-0 w-2/3 h-0.5 bg-primary -translate-y-1/2 -z-10 transition-all duration-500"></div>

                <a href="{{ route('booking.page') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-10 h-10 rounded-full bg-primary/20 text-primary/50 flex items-center justify-center text-sm font-bold">
                        <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">check</span>
                    </div>
                    <span class="text-xs font-semibold text-primary/50">Select Room</span>
                </a>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">2</div>
                    <span class="text-xs font-semibold text-primary">Details</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-surface text-text-secondary flex items-center justify-center text-sm font-bold">3</div>
                    <span class="text-xs font-semibold text-text-secondary">Payment</span>
                </div>
            </div>
        </div>

        {{-- Error messages --}}
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-xl text-xs">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            {{-- Form --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6">
                    <h1 class="text-xl font-bold text-primary mb-6">Booking Details</h1>

                    <form id="details-form" action="{{ route('booking.store-room', $room) }}" method="POST">
                        @csrf

                        {{-- Room info --}}
                        <div class="bg-surface rounded-xl p-4 mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-xs text-text-secondary uppercase tracking-wider">Selected Room</p>
                                <p class="text-lg font-bold text-primary">{{ $room->room_number }} <span class="text-text-secondary text-sm font-normal">— {{ $room->roomType->name }}</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-text-secondary">Monthly Rate</p>
                                <p class="text-sm font-bold text-primary">Rp {{ number_format($room->roomType->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Check-in date --}}
                        <div class="mb-5">
                            <label for="start_date" class="block text-sm font-semibold text-primary mb-2">Check-in Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                                class="w-full bg-surface px-4 py-3 rounded-xl border border-border-subtle focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none text-sm transition-all"
                                required min="{{ date('Y-m-d') }}">
                            @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Duration --}}
                        <div class="mb-6">
                            <label for="duration" class="block text-sm font-semibold text-primary mb-2">Duration</label>
                            <select name="duration" id="duration" onchange="updateTotal()"
                                class="w-full bg-surface px-4 py-3 rounded-xl border border-border-subtle focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none text-sm transition-all">
                                <option value="1">1 Month</option>
                                <option value="3" {{ old('duration') == 3 ? 'selected' : '' }}>3 Months</option>
                                <option value="6" {{ old('duration') == 6 ? 'selected' : '' }}>6 Months</option>
                                <option value="12" {{ old('duration') == 12 ? 'selected' : '' }}>1 Year</option>
                            </select>
                            @error('duration')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-primary text-white text-sm font-semibold py-4 rounded-xl hover:bg-black/80 transition-all active:scale-[0.98]">
                            Continue to Payment
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </form>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('booking.page') }}" class="inline-flex items-center gap-1 text-text-secondary hover:text-primary text-xs transition-colors">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Choose a different room
                    </a>
                </div>
            </div>

            {{-- Summary Sidebar --}}
            <aside class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6 sticky top-28">
                    <h3 class="text-lg font-bold text-primary mb-4">Summary</h3>

                    <div class="space-y-3 py-4 border-y border-border-subtle">
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-xs">Room</span>
                            <span class="text-primary font-bold text-sm">{{ $room->room_number }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-xs">Type</span>
                            <span class="text-primary text-sm font-medium">{{ $room->roomType->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-xs">Check-in</span>
                            <span class="text-primary text-sm font-medium" id="summary-date">{{ date('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-xs">Duration</span>
                            <span class="text-primary text-sm font-medium" id="summary-duration">1 Month</span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-2">
                        <div class="flex justify-between items-center text-text-secondary text-xs">
                            <span>Monthly Rate</span>
                            <span>Rp {{ number_format($room->roomType->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 mt-2 border-t border-border-subtle">
                            <span class="text-sm font-bold text-primary">Total</span>
                            <span class="text-sm font-bold text-primary" id="summary-total">Rp {{ number_format($room->roomType->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    {{-- Footer --}}
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
                        Premium managed boarding in the heart of Mataram, Lombok.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-widest text-white/40 mb-5">Navigate</h4>
                    <ul class="space-y-3 text-sm text-white/60">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('booking.page') }}" class="hover:text-white transition-colors">Book a Room</a></li>
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
                    </ul>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center border-t border-white/10 pt-8 text-xs text-white/30 uppercase tracking-widest gap-4">
                <div>&copy; {{ date('Y') }} Kos Arcadia. All rights reserved.</div>
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

        const price = {{ $room->roomType->price }};

        function updateTotal() {
            const duration = parseInt(document.getElementById('duration').value);
            const total = price * duration;
            document.getElementById('summary-total').innerText = 'Rp ' + total.toLocaleString('id-ID');

            const select = document.getElementById('duration');
            document.getElementById('summary-duration').innerText = select.options[select.selectedIndex].text;
        }

        document.getElementById('start_date').addEventListener('change', function() {
            document.getElementById('summary-date').innerText = new Date(this.value).toLocaleDateString('en-GB', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
        });
    </script>

</body>
</html>

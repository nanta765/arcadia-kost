<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Kost — My Bookings</title>
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

    <main class="max-w-7xl mx-auto px-6 md:px-12 pt-28 pb-16">
        <div class="mb-10">
            <h1 class="text-2xl font-bold text-primary mb-2">My Bookings</h1>
            <p class="text-text-secondary text-sm">Manage all your reservations in one place.</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl text-xs flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        @if($bookings->isEmpty())
        <div class="bg-white rounded-2xl border border-border-subtle p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-text-secondary/20 mb-4">night_shelter</span>
            <h3 class="text-lg font-bold text-primary mb-2">No rooms booked yet</h3>
            <p class="text-text-secondary text-sm mb-8">Start by choosing a comfortable room for your stay.</p>
            <a href="{{ route('booking.page') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white text-sm font-semibold rounded-full hover:bg-black/80 transition-all active:scale-95">
                <span class="material-symbols-outlined">search</span>
                Browse Room Catalog
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($bookings as $booking)
            <div class="bg-white rounded-2xl border border-border-subtle overflow-hidden shadow-sm hover:shadow-md transition-shadow">

                {{-- Status header --}}
                <div class="px-6 py-4 border-b border-border-subtle flex justify-between items-center bg-surface/50">
                    <span class="text-xs text-text-secondary">
                        Booked {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                    </span>
                    @if($booking->status == 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700 border border-orange-100">
                            Awaiting Payment
                        </span>
                    @elseif($booking->status == 'review')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            Awaiting Confirmation
                        </span>
                    @elseif($booking->status == 'active')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                            Active
                        </span>
                    @elseif($booking->status == 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                            Completed
                        </span>
                    @elseif($booking->status == 'cancelled')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                            Cancelled
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-surface text-text-secondary border border-border-subtle">
                            {{ ucfirst($booking->status) }}
                        </span>
                    @endif
                </div>

                {{-- Room details --}}
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-primary">{{ $booking->room->roomType->name }}</h3>
                            <p class="text-text-secondary text-sm mt-1">
                                <span class="material-symbols-outlined text-sm align-middle">door_open</span>
                                Room <span class="font-bold text-primary">{{ $booking->room->room_number }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-text-secondary">Total</p>
                            <p class="text-lg font-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="bg-surface rounded-xl p-4 border border-border-subtle">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-text-secondary">Check-in</p>
                                <p class="text-sm font-semibold text-primary">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-text-secondary">End Date</p>
                                <p class="text-sm font-semibold text-primary">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-border-subtle">
                            <p class="text-xs text-text-secondary">Duration <span class="font-bold text-primary">{{ $booking->duration_months }} Months</span></p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 py-4 border-t border-border-subtle bg-surface/30 flex flex-col gap-2">
                    @if($booking->status == 'pending')
                        <a href="{{ route('booking.pay', $booking->id) }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white text-sm font-semibold py-3 rounded-xl hover:bg-black/80 transition-all active:scale-95">
                            <span class="material-symbols-outlined text-sm">payments</span>
                            Pay Now
                        </a>
                    @elseif($booking->status == 'review')
                        <p class="text-center text-xs text-text-secondary py-2 flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-sm">hourglass_top</span>
                            Waiting for admin confirmation
                        </p>
                    @elseif($booking->status == 'active')
                        <form action="{{ route('booking.extend', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center justify-center gap-2 w-full bg-primary text-white text-sm font-semibold py-3 rounded-xl hover:bg-black/80 transition-all active:scale-95">
                                <span class="material-symbols-outlined text-sm">autorenew</span>
                                Extend Stay (1 Month)
                            </button>
                        </form>
                        @if(!$booking->review)
                        <a href="{{ route('review.create', $booking->id) }}" class="flex items-center justify-center gap-2 w-full border border-border-subtle text-primary text-sm font-semibold py-3 rounded-xl hover:bg-surface transition-all">
                            <span class="material-symbols-outlined text-sm">reviews</span>
                            Write Review
                        </a>
                        @endif
                        <a href="{{ route('service.create', $booking->id) }}" class="flex items-center justify-center gap-2 w-full border border-border-subtle text-text-secondary text-xs font-medium py-2 rounded-xl hover:bg-surface transition-all">
                            <span class="material-symbols-outlined text-sm">build</span>
                            Request Service
                        </a>
                    @elseif($booking->status == 'completed')
                        @if(!$booking->review)
                        <a href="{{ route('review.create', $booking->id) }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white text-sm font-semibold py-3 rounded-xl hover:bg-black/80 transition-all active:scale-95">
                            <span class="material-symbols-outlined text-sm">reviews</span>
                            Write Review
                        </a>
                        @endif
                    @endif
                </div>

            </div>
            @endforeach
        </div>
        @endif
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

</body>
</html>

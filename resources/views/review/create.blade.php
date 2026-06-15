<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Kost — Write Review</title>
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

    {{-- Navbar --}}
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
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sidebar --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6 flex flex-col items-center text-center">
                    <form id="photo-form" action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="photo-input" class="cursor-pointer group relative">
                            <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-4 ring-4 ring-surface overflow-hidden group-hover:ring-primary/20 transition-all">
                                @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover group-hover:opacity-70 transition-opacity">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="material-symbols-outlined text-white text-xl bg-black/40 rounded-full p-1">photo_camera</span>
                                </div>
                                @else
                                <span class="material-symbols-outlined text-4xl text-primary/40 group-hover:text-primary/60 transition-colors">person</span>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="material-symbols-outlined text-white text-xl bg-black/40 rounded-full p-1">add_a_photo</span>
                                </div>
                                @endif
                            </div>
                        </label>
                        <input type="file" id="photo-input" name="profile_photo" accept=".jpg,.jpeg,.png" class="hidden" onchange="document.getElementById('photo-form').submit();">
                    </form>
                    <h3 class="text-lg font-bold text-primary">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-text-secondary mt-1">Room {{ $booking->room->room_number }}</p>
                </div>

                <nav class="mt-4 bg-white rounded-2xl border border-border-subtle shadow-sm p-2 flex flex-row lg:flex-col overflow-x-auto gap-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-surface transition-all">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="text-sm font-medium whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="{{ route('booking.my-bookings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-surface transition-all">
                        <span class="material-symbols-outlined">night_shelter</span>
                        <span class="text-sm font-medium whitespace-nowrap">My Bookings</span>
                    </a>
                </nav>
            </aside>

            {{-- Main Content --}}
            <section class="flex-1 min-w-0">
                <header class="mb-8">
                    <h1 class="text-2xl font-bold text-primary mb-2">Write a Review</h1>
                    <p class="text-text-secondary text-sm">Share your experience to help future tenants and improve our service.</p>
                </header>

                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-xl text-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-xl text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined">error</span>
                    {{ session('error') }}
                </div>
                @endif

                <div class="bg-white rounded-2xl border border-border-subtle shadow-sm">
                    <form action="{{ route('review.store', $booking->id) }}" method="POST" class="p-6 md:p-8">
                        @csrf

                        {{-- Room summary --}}
                        <div class="mb-8 p-5 bg-surface rounded-xl border border-border-subtle">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-xl bg-white text-primary">
                                        <span class="material-symbols-outlined text-3xl">night_shelter</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-primary">{{ $booking->room->roomType->name }}</p>
                                        <p class="text-xs text-text-secondary">Room {{ $booking->room->room_number }} &middot; Stayed {{ \Carbon\Carbon::parse($booking->start_date)->format('d M') }} – {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-medium border border-green-200">Completed</span>
                            </div>
                        </div>

                        {{-- Star rating --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-primary mb-4">How many stars for this room?</label>
                            <div class="flex items-center justify-center gap-2 p-4 bg-surface rounded-xl border border-border-subtle {{ !$durationDone ? 'opacity-50 pointer-events-none select-none' : '' }}" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-btn cursor-pointer bg-transparent border-0 p-1" data-value="{{ $i }}">
                                    <span class="material-symbols-outlined text-5xl text-border-subtle transition-all duration-150 star-icon"
                                        data-value="{{ $i }}"
                                        style="font-variation-settings: 'FILL' 0;">
                                        star
                                    </span>
                                </button>
                                @endfor
                                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', '') }}" required>
                            </div>
                            @error('rating')
                            <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Comment --}}
                        <div class="mb-8 pt-8 border-t border-border-subtle">
                            <label for="comment" class="block text-sm font-semibold text-primary mb-2">
                                Share your experience
                            </label>
                            <p class="text-text-secondary text-xs mb-3">Tell future tenants what you liked — or what could be better.</p>
                            <textarea name="comment" id="comment" rows="4" placeholder="Clean room, complete facilities, good water pressure..."
                                class="w-full text-sm text-primary bg-surface border border-border-subtle rounded-xl p-4 focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none resize-none transition-all"
                                @if(!$durationDone) disabled @endif>{{ old('comment') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t border-border-subtle">
                            @if($durationDone)
                            <button type="submit"
                                class="w-full sm:w-auto flex-1 flex items-center justify-center gap-2 bg-primary text-white text-sm font-semibold py-4 px-8 rounded-xl hover:bg-black/80 transition-all active:scale-95">
                                <span class="material-symbols-outlined">send</span>
                                Submit Review
                            </button>
                            @else
                            <div class="flex-1 p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-sm text-yellow-700 flex items-center gap-3">
                                <span class="material-symbols-outlined">schedule</span>
                                <span>Your stay ends on <strong>{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</strong>. You can submit your review after that date.</span>
                            </div>
                            @endif
                            <a href="{{ route('booking.my-bookings') }}"
                                class="w-full sm:w-auto flex items-center justify-center gap-2 text-text-secondary hover:text-primary text-sm font-medium py-4 px-6 rounded-xl hover:bg-surface transition-all">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </section>
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
        (function() {
            const stars = document.querySelectorAll('.star-icon');
            const buttons = document.querySelectorAll('.star-btn');
            const input = document.getElementById('rating-input');
            const filledColor = '#f59e0b';
            let selectedValue = parseInt(input.value) || 0;

            function fillUpTo(value) {
                stars.forEach(s => {
                    const v = parseInt(s.dataset.value);
                    if (v <= value) {
                        s.style.color = filledColor;
                        s.style.fontVariationSettings = "'FILL' 1";
                    } else {
                        s.style.color = '';
                        s.style.fontVariationSettings = "'FILL' 0";
                    }
                });
            }

            if (selectedValue > 0) {
                fillUpTo(selectedValue);
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    selectedValue = parseInt(btn.dataset.value);
                    input.value = selectedValue;
                    fillUpTo(selectedValue);
                });

                btn.addEventListener('mouseenter', () => {
                    fillUpTo(parseInt(btn.dataset.value));
                });
            });

            document.getElementById('star-rating').addEventListener('mouseleave', () => {
                fillUpTo(selectedValue);
            });
        })();
    </script>

</body>
</html>

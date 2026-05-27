<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Kost — Book a Room</title>
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

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-6 md:px-12 pt-28 pb-16">
        {{-- Stepper --}}
        <div class="mb-14">
            <div class="flex items-center justify-between max-w-xl mx-auto relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-surface -translate-y-1/2 -z-10"></div>
                <div class="absolute top-1/2 left-0 w-1/3 h-0.5 bg-primary -translate-y-1/2 -z-10 transition-all duration-500"></div>

                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">1</div>
                    <span class="text-xs font-semibold text-primary">Select Room</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-surface text-text-secondary flex items-center justify-center text-sm font-bold">2</div>
                    <span class="text-xs font-semibold text-text-secondary">Details</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-surface text-text-secondary flex items-center justify-center text-sm font-bold">3</div>
                    <span class="text-xs font-semibold text-text-secondary">Payment</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            {{-- Left: Room Grid --}}
            <div class="lg:col-span-8 space-y-10">

                {{-- Filters --}}
                <div class="bg-surface/50 rounded-2xl border border-border-subtle p-6">
                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="flex-1 space-y-2">
                            <label class="text-xs font-semibold text-text-secondary flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">calendar_today</span>
                                Check-in Date
                            </label>
                            <input class="w-full bg-white px-4 py-3 rounded-xl border border-border-subtle focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm" type="date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="text-xs font-semibold text-text-secondary flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">event_busy</span>
                                Duration
                            </label>
                            <select id="duration-select" onchange="updateDuration()" class="w-full bg-white px-4 py-3 rounded-xl border border-border-subtle focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm">
                                <option value="1">1 Month</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="12">1 Year</option>
                            </select>
                        </div>
                        <button class="bg-primary text-white px-8 py-3 rounded-full text-xs font-semibold hover:bg-black/80 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">search</span>
                            Update
                        </button>
                    </div>
                </div>

                {{-- Room Grid --}}
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-primary">Available Rooms</h2>
                        <div class="flex items-center gap-2 text-text-secondary text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            Available
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($rooms as $room)
                            @if($room->status === 'available')
                            <div class="room-card group cursor-pointer relative bg-white border border-border-subtle rounded-2xl p-5 transition-all duration-300 hover:shadow-lg hover:shadow-black/5 hover:border-primary/30"
                                 onclick="selectRoom(this, '{{ $room->id }}', '{{ $room->room_number }}', '{{ $room->roomType->price }}')">
                                <div class="check-mark absolute top-3 right-3 transition-opacity" style="opacity: 0">
                                    <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                </div>
                                <div class="flex flex-col items-center text-center gap-2.5">
                                    <span class="text-[10px] font-semibold text-text-secondary tracking-widest uppercase">{{ $room->roomType->name }}</span>
                                    <span class="text-2xl font-bold text-primary">{{ $room->room_number }}</span>
                                    <div class="w-full h-px bg-border-subtle/30 my-0.5"></div>
                                    <span class="text-sm font-semibold text-primary">IDR {{ number_format($room->roomType->price / 1000, 1, ',', '.') }}M<span class="text-[10px] text-text-secondary font-normal">/mo</span></span>
                                </div>
                            </div>
                            @else
                            <div class="relative bg-surface/50 border border-border-subtle/30 rounded-2xl p-5 flex flex-col items-center text-center gap-2.5 opacity-50 cursor-not-allowed">
                                <span class="text-[10px] font-semibold text-text-secondary tracking-widest uppercase">{{ $room->roomType->name }}</span>
                                <span class="text-2xl font-bold text-text-secondary">{{ $room->room_number }}</span>
                                <div class="w-full h-px bg-border-subtle/20 my-0.5"></div>
                                <span class="text-xs font-medium text-red-400">{{ ucfirst($room->status) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </section>

                {{-- Amenities --}}
                <section class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4">
                    <div class="p-6 bg-white border border-border-subtle rounded-2xl">
                        <h3 class="text-sm font-semibold text-primary mb-4 uppercase tracking-wider">Room Amenities</h3>
                        <div class="flex flex-wrap gap-2">
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface rounded-full text-xs font-medium">
                                <span class="material-symbols-outlined text-base">ac_unit</span>
                                Climate Control
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface rounded-full text-xs font-medium">
                                <span class="material-symbols-outlined text-base">wifi</span>
                                High-Speed Fiber
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface rounded-full text-xs font-medium">
                                <span class="material-symbols-outlined text-base">hot_tub</span>
                                Water Heater
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white border border-border-subtle rounded-2xl">
                        <h3 class="text-sm font-semibold text-primary mb-4 uppercase tracking-wider">Managed Services</h3>
                        <div class="flex flex-wrap gap-2">
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface rounded-full text-xs font-medium">
                                <span class="material-symbols-outlined text-base">security</span>
                                24/7 Security
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface rounded-full text-xs font-medium">
                                <span class="material-symbols-outlined text-base">cleaning_services</span>
                                Weekly Cleaning
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Right: Summary Sidebar --}}
            <aside class="lg:col-span-4">
                <div class="sticky top-28 bg-white rounded-2xl border border-border-subtle shadow-lg shadow-black/5 overflow-hidden">
                    <div class="h-44 relative">
                        <img class="w-full h-full object-cover" alt="Room preview" src="{{ asset('images/gallery/front-room.jpeg') }}">
                        <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1.5 rounded-full text-xs font-semibold">Premium Managed</div>
                    </div>
                    <div class="p-7 space-y-5">
                        <div>
                            <h3 class="text-lg font-bold text-primary mb-1">Reservation Summary</h3>
                            <p class="text-text-secondary text-xs">Mataram, Lombok Living Experience</p>
                        </div>
                        <div class="space-y-3 py-5 border-y border-border-subtle">
                            <div class="flex justify-between items-center">
                                <span class="text-text-secondary text-xs font-medium">Selected Room</span>
                                <span class="text-primary font-bold text-lg" id="summary-room-id">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-text-secondary text-xs font-medium">Check-in</span>
                                <span class="text-primary text-sm font-medium" id="summary-date">{{ date('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-text-secondary text-xs font-medium">Duration</span>
                                <span class="text-primary text-sm font-medium" id="summary-duration">1 Month</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-text-secondary text-xs">
                                <span>Monthly Rate</span>
                                <span id="summary-price">-</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 mt-2 border-t border-border-subtle">
                                <span class="text-sm font-bold text-primary">Total</span>
                                <span class="text-sm font-bold text-primary" id="summary-total">-</span>
                            </div>
                        </div>
                        <a id="btn-continue"
                            class="w-full bg-text-secondary text-white py-4 rounded-xl text-sm font-semibold cursor-not-allowed transition-all text-center block pointer-events-none">
                            Select a Room to Continue
                        </a>
                        <div class="flex items-center justify-center gap-2 text-text-secondary/50 text-xs">
                            <span class="material-symbols-outlined text-sm">lock</span>
                            Secure Booking Encryption
                        </div>
                    </div>
                </div>
            </aside>
        </div>
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
        function updateDuration() {
            var select = document.getElementById('duration-select');
            var durationText = select.options[select.selectedIndex].text;
            document.getElementById('summary-duration').innerText = durationText;

            if (selectedRoomId && selectedPrice) {
                var duration = parseInt(select.value);
                var total = parseInt(selectedPrice) * duration;
                document.getElementById('summary-total').innerText = 'IDR ' + total.toLocaleString('id-ID');
            }
        }

        var selectedRoomId = null;
        var selectedPrice = null;

        function selectRoom(el, roomId, roomNumber, price) {
            document.querySelectorAll('.room-card').forEach(card => {
                card.classList.remove('border-2', 'border-primary', 'shadow-lg', 'shadow-black/5');
                card.classList.add('border', 'border-border-subtle');
                const mark = card.querySelector('.check-mark');
                if (mark) {
                    mark.style.opacity = '0';
                    const icon = mark.querySelector('.material-symbols-outlined');
                    if (icon) icon.style.fontVariationSettings = "'FILL' 0";
                }
            });

            el.classList.add('border-2', 'border-primary', 'shadow-lg', 'shadow-black/5');
            el.classList.remove('border', 'border-border-subtle');

            const mark = el.querySelector('.check-mark');
            if (mark) {
                mark.style.opacity = '1';
                const icon = mark.querySelector('.material-symbols-outlined');
                if (icon) icon.style.fontVariationSettings = "'FILL' 1";
            }

            selectedRoomId = roomId;
            selectedPrice = price;

            var rawPrice = parseInt(price);
            document.getElementById('summary-room-id').innerText = roomNumber;
            document.getElementById('summary-price').innerText = 'IDR ' + rawPrice.toLocaleString('id-ID');

            var duration = parseInt(document.getElementById('duration-select').value);
            var total = rawPrice * duration;
            document.getElementById('summary-total').innerText = 'IDR ' + total.toLocaleString('id-ID');

            var btn = document.getElementById('btn-continue');
            btn.href = '/book/' + roomId + '/details';
            btn.className = 'w-full bg-primary text-white py-4 rounded-xl text-sm font-semibold hover:bg-black/80 active:scale-[0.98] transition-all text-center block pointer-events-auto';
            btn.innerText = 'Continue to Details';

            el.classList.add('scale-95');
            setTimeout(function() { el.classList.remove('scale-95'); }, 150);
        }
    </script>

</body>
</html>

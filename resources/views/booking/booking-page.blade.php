<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Kos Arcadia') }} - Booking</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Be+Vietnam+Pro:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-effect {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        input:focus {
            outline: none;
            box-shadow: none;
        }
    </style>

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
                },
            },
        }
    </script>
</head>
<body class="bg-background text-on-background font-body-md">

    <header class="docked full-width top-0 sticky z-50 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md shadow-sm shadow-primary/5 border-b border-outline-variant/30">
        <nav class="flex justify-between items-center w-full px-container-padding py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-8">
                <a href="{{ url('/') }}" class="font-display-lg text-display-lg font-bold text-primary dark:text-primary-fixed-dim tracking-tight">Kos Arcadia</a>
                <div class="hidden md:flex items-center gap-6">
                    <a class="font-label-lg text-label-lg text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
                    <a class="font-label-lg text-label-lg text-primary dark:text-primary-fixed-dim border-b-2 border-primary pb-1 font-bold" href="{{ route('booking.page') }}">Rooms</a>
                    <a class="font-label-lg text-label-lg text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#facility">Amenities</a>
                    <a class="font-label-lg text-label-lg text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#location">Location</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @auth
                <a href="{{ route('booking.page') }}" class="hidden md:flex px-6 py-2 bg-primary text-on-primary font-label-lg text-label-lg rounded-full hover:bg-primary-container transition-all active:scale-95">Book Now</a>
                <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-full bg-surface-container overflow-hidden border border-outline-variant/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">person</span>
                </a>
                @else
                <a href="{{ route('login') }}" class="hidden md:flex px-6 py-2 bg-primary text-on-primary font-label-lg text-label-lg rounded-full hover:bg-primary-container transition-all active:scale-95">Login to Book</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-container-padding py-12 md:py-16">
        <div class="mb-12">
            <div class="flex items-center justify-between max-w-3xl mx-auto relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-surface-container-highest -translate-y-1/2 -z-10"></div>
                <div class="absolute top-1/2 left-0 w-1/3 h-0.5 bg-primary -translate-y-1/2 -z-10 transition-all duration-500"></div>
                
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold shadow-lg shadow-primary/20">1</div>
                    <span class="font-label-lg text-label-lg text-primary">Select Room</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-surface-container-highest text-on-surface-variant flex items-center justify-center font-bold">2</div>
                    <span class="font-label-lg text-label-lg text-on-surface-variant">Details</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-surface-container-highest text-on-surface-variant flex items-center justify-center font-bold">3</div>
                    <span class="font-label-lg text-label-lg text-on-surface-variant">Payment</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8 space-y-10">
                
                <section class="bg-surface-container-low p-8 rounded-xl border border-outline-variant/20 shadow-sm shadow-primary/5">
                    <div class="flex flex-col md:flex-row md:items-end gap-6">
                        <div class="flex-1 space-y-2">
                            <label class="font-label-lg text-label-lg text-on-surface-variant flex items-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                                Check-in Date
                            </label>
                            <input class="w-full bg-surface p-3 border-b-2 border-outline-variant focus:border-primary transition-colors font-body-md text-on-surface" type="date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="font-label-lg text-label-lg text-on-surface-variant flex items-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">event_busy</span>
                                Duration
                            </label>
                            <select class="w-full bg-surface p-3 border-b-2 border-outline-variant focus:border-primary transition-colors font-body-md text-on-surface">
                                <option value="1">1 Month</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="12">1 Year</option>
                            </select>
                        </div>
                        <button class="bg-primary-container text-on-primary-container px-8 py-3 rounded-lg font-label-lg text-label-lg hover:brightness-110 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">search</span>
                            Update
                        </button>
                    </div>
                </section>

                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-headline-lg text-headline-lg text-primary">Available Sanctuaries</h2>
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="w-3 h-3 rounded-full bg-secondary"></span>
                            <span class="font-label-sm text-label-sm">Available</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($rooms as $room)
                            @if($room->status === 'available')
                            <div class="room-card group cursor-pointer relative bg-white border border-outline-variant/30 rounded-xl p-6 transition-all duration-300 hover:shadow-xl hover:shadow-primary/5 hover:border-primary/50"
                                 onclick="selectRoom(this, '{{ $room->id }}', '{{ $room->room_number }}', '{{ number_format($room->roomType->price) }}')">
                                <div class="check-mark absolute top-3 right-3 transition-opacity" style="opacity: 0">
                                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 0;">check_circle</span>
                                </div>
                                <div class="flex flex-col items-center text-center gap-3">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant tracking-widest uppercase">{{ $room->roomType->name }}</span>
                                    <span class="font-display-lg text-headline-lg text-primary">{{ $room->room_number }}</span>
                                    <div class="w-full h-px bg-outline-variant/20 my-1"></div>
                                    <span class="font-label-lg text-label-lg text-secondary">IDR {{ number_format($room->roomType->price / 1000, 1, ',', '.') }}M<span class="text-[10px] text-on-surface-variant">/mo</span></span>
                                </div>
                            </div>
                            @else
                            <div class="relative bg-surface-container-highest/50 border border-outline-variant/10 rounded-xl p-6 flex flex-col items-center text-center gap-3 opacity-60 cursor-not-allowed">
                                <span class="font-label-sm text-label-sm text-on-surface-variant tracking-widest uppercase">{{ $room->roomType->name }}</span>
                                <span class="font-display-lg text-headline-lg text-on-surface-variant">{{ $room->room_number }}</span>
                                <div class="w-full h-px bg-outline-variant/20 my-1"></div>
                                <span class="font-label-sm text-label-sm text-red-500">{{ ucfirst($room->status) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </section>

                <section class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                    <div class="p-6 bg-surface-container-lowest border border-outline-variant/20 rounded-xl">
                        <h3 class="font-label-lg text-label-lg text-primary mb-4 uppercase tracking-wider">Premium In-Room Amenities</h3>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full">
                                <span class="material-symbols-outlined text-[18px] text-secondary">ac_unit</span>
                                <span class="font-label-sm text-label-sm">Climate Control</span>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full">
                                <span class="material-symbols-outlined text-[18px] text-secondary">wifi</span>
                                <span class="font-label-sm text-label-sm">High-Speed Fiber</span>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full">
                                <span class="material-symbols-outlined text-[18px] text-secondary">hot_tub</span>
                                <span class="font-label-sm text-label-sm">Water Heater</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-surface-container-lowest border border-outline-variant/20 rounded-xl">
                        <h3 class="font-label-lg text-label-lg text-primary mb-4 uppercase tracking-wider">Managed Excellence</h3>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full">
                                <span class="material-symbols-outlined text-[18px] text-secondary">security</span>
                                <span class="font-label-sm text-label-sm">24/7 Security</span>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-surface-container-high rounded-full">
                                <span class="material-symbols-outlined text-[18px] text-secondary">cleaning_services</span>
                                <span class="font-label-sm text-label-sm">Weekly Cleaning</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="lg:col-span-4">
                <div class="sticky top-28 bg-white rounded-2xl border border-outline-variant/30 shadow-xl shadow-primary/5 overflow-hidden">
                    <div class="h-48 relative">
                        <img class="w-full h-full object-cover" alt="Minimalist bedroom" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAenxRA0jmgLmTPIuaLeAq_HHgAK6VLLq4t5B5bgC61LoH5Lm3GaruaB_5miK_usrZMwol3nZHLn-ChohRBmV5BDy1NVdc6xPe4M0gKBZGBKn25vMQiuD5Uk35H1IxeTf_fAJhg8VmwmYHoZQNZsitCY7HHnfmydN6y3pr0dj43nBt2h8A4W7ofWWlKQSdiNd0eyb7I_mke1x5zXmiRSMgF0zabccSK2EdjNsSsfk3ge1zla3Pg7sTJFyJ98U7C088GNJi92zcSjxs">
                        <div class="absolute top-4 right-4 bg-primary text-on-primary px-3 py-1 rounded-lg font-label-lg text-label-lg">Premium Managed</div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <h3 class="font-headline-md text-headline-md text-primary mb-1">Reservation Summary</h3>
                            <p class="font-body-md text-on-surface-variant">Lombok's Premier Living Experience</p>
                        </div>
                        <div class="space-y-4 py-6 border-y border-outline-variant/20">
                            <div class="flex justify-between items-center">
                                <span class="text-on-surface-variant font-label-lg text-label-lg">Selected Room</span>
                                <span class="text-primary font-bold font-headline-md text-headline-md" id="summary-room-id">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-on-surface-variant font-label-lg text-label-lg">Check-in</span>
                                <span class="text-on-surface font-body-md" id="summary-date">{{ date('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-on-surface-variant font-label-lg text-label-lg">Duration</span>
                                <span class="text-on-surface font-body-md">1 Month</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-on-surface-variant">
                                <span class="font-body-md">Monthly Rate</span>
                                <span class="font-body-md" id="summary-price">-</span>
                            </div>
                            <div class="flex justify-between items-center text-on-surface-variant">
                                <span class="font-body-md">Security Deposit</span>
                                <span class="font-body-md">IDR 1.000.000</span>
                            </div>
                            <div class="flex justify-between items-center pt-4">
                                <span class="font-headline-md text-headline-md text-primary">Total Payable</span>
                                <span class="font-headline-md text-headline-md text-secondary" id="summary-total">-</span>
                            </div>
                        </div>
                        <form id="booking-form" method="POST" action="" data-action="{{ url('/book') }}">
                            @csrf
                            <input type="hidden" name="room_id" id="form-room-id">
                            <input type="hidden" name="start_date" id="form-start-date" value="{{ date('Y-m-d') }}">
                            <button type="submit" id="btn-continue" disabled
                                    class="w-full bg-on-surface-variant text-on-primary py-4 rounded-xl font-headline-md text-headline-md cursor-not-allowed transition-all shadow-lg">
                                Select a Room to Continue
                            </button>
                        </form>
                        <div class="flex items-center justify-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[16px]">lock</span>
                            <span class="font-label-sm text-label-sm">Secure Booking Encryption</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <footer class="bg-surface-container-highest dark:bg-surface-container-low border-t border-outline-variant/20 mt-20">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-section-gap-mobile md:gap-section-gap-desktop w-full px-container-padding py-16 max-w-7xl mx-auto">
            <div class="md:col-span-1 flex flex-col gap-4">
                <span class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim">Kos Arcadia</span>
                <p class="font-body-md text-body-md text-on-surface-variant">Elevating the boarding experience in Lombok with luxury management and serene environments.</p>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-label-lg text-label-lg text-primary font-bold">Explore</h4>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">About Us</a>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">Rooms</a>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">Amenities</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-label-lg text-label-lg text-primary font-bold">Support</h4>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">Contact</a>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">FAQ</a>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">Privacy Policy</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-label-lg text-label-lg text-primary font-bold">Connect</h4>
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-primary cursor-pointer hover:scale-110 transition-transform">share</span>
                    <span class="material-symbols-outlined text-primary cursor-pointer hover:scale-110 transition-transform">mail</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant mt-4">© {{ date('Y') }} Kos Arcadia Lombok. Luxury Managed Boarding.</p>
            </div>
        </div>
    </footer>

    <script>
        function selectRoom(el, roomId, roomNumber, price) {
            // Deselect all cards
            document.querySelectorAll('.room-card').forEach(card => {
                card.classList.remove('selected', 'border-2', 'border-primary', 'shadow-xl', 'shadow-primary/5');
                card.classList.add('border', 'border-outline-variant/30');
                const mark = card.querySelector('.check-mark');
                if (mark) {
                    mark.style.opacity = '0';
                    const icon = mark.querySelector('.material-symbols-outlined');
                    if (icon) icon.style.fontVariationSettings = "'FILL' 0";
                }
            });

            // Select clicked card
            el.classList.add('selected', 'border-2', 'border-primary', 'shadow-xl', 'shadow-primary/5');
            el.classList.remove('border', 'border-outline-variant/30');

            const mark = el.querySelector('.check-mark');
            if (mark) {
                mark.style.opacity = '1';
                const icon = mark.querySelector('.material-symbols-outlined');
                if (icon) icon.style.fontVariationSettings = "'FILL' 1";
            }

            // Update Summary Sidebar
            document.getElementById('summary-room-id').innerText = roomNumber;
            document.getElementById('summary-price').innerText = 'IDR ' + price;
            document.getElementById('summary-total').innerText = 'IDR ' + (parseInt(price.replace(/\./g, '')) + 1000000).toLocaleString('id-ID');

            // Update hidden form fields
            document.getElementById('form-room-id').value = roomId;
            document.getElementById('form-start-date').value = document.querySelector('input[type="date"]').value;

            // Update form action URL
            var baseUrl = document.getElementById('booking-form').getAttribute('data-action');
            document.getElementById('booking-form').action = baseUrl + '/' + roomId;

            // Enable continue button
            var btn = document.getElementById('btn-continue');
            btn.disabled = false;
            btn.className = 'w-full bg-primary text-on-primary py-4 rounded-xl font-headline-md text-headline-md hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-primary/20';
            btn.innerText = 'Continue to Details';

            // Interaction Feedback
            el.classList.add('scale-95');
            setTimeout(function() { el.classList.remove('scale-95'); }, 150);
        }
    </script>
</body>
</html>
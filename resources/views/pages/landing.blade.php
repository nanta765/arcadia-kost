<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Kost</title>
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
        /* Hide scrollbar for clean look in bento scrolls */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Reveal animations */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-scale {
            opacity: 0;
            transform: scale(0.94);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-scale.visible {
            opacity: 1;
            transform: scale(1);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
        .delay-500 { transition-delay: 500ms; }

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
<body class="bg-canvas text-primary font-sans antialiased selection:bg-primary selection:text-white">

    <nav id="navbar" class="fixed top-0 w-full bg-transparent border-b border-transparent z-50 transition-all duration-500">
        <div class="max-w-7xl mx-auto px-6 md:px-12 h-20 flex items-center justify-between">
            <div class="flex items-center">
                @if(file_exists(public_path('images/arcadia-logo-no-bg.png')))
                <img src="{{ asset('images/arcadia-logo-no-bg.png') }}" alt="Arcadia" class="h-14 md:h-16 w-auto">
                @else
                <span class="font-sans font-semibold tracking-widest uppercase text-sm">Arca</span>
                @endif
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm font-medium">
                <a href="#about" class="nav-link px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/30 transition-all">About</a>
                <a href="#facility" class="nav-link px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/30 transition-all">Facilities</a>
                <a href="#gallery" class="nav-link px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/30 transition-all">Gallery</a>
                <a href="#room" class="nav-link px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/30 transition-all">The Room</a>
                <a href="#location" class="nav-link px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/30 transition-all">Location</a>
                <a href="#reviews" class="nav-link px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/30 transition-all">Reviews</a>
            </div>
            <div class="flex items-center gap-4">
                @auth
                <a href="{{ route('booking.page') }}" class="bg-white text-primary px-6 py-3 rounded-full text-xs font-semibold tracking-widest uppercase hover:bg-white/80 transition-all">
                    Book Now
                </a>
                @else
                <a href="{{ route('login') }}" class="nav-link px-5 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm font-medium text-white hover:bg-white/30 transition-all">
                    Login
                </a>
                <a href="{{ route('booking.page') }}" class="bg-white text-primary px-6 py-3 rounded-full text-xs font-semibold tracking-widest uppercase hover:bg-white/80 transition-all">
                    Reserve Now
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="relative h-screen w-full flex items-center justify-center overflow-hidden">
        @php
            $localHero = 'images/hero.jpg';
            $roomImage = $roomTypes->first()?->image;
            $heroSrc = file_exists(public_path($localHero))
                ? asset($localHero)
                : ($roomImage ? asset("storage/{$roomImage}") : 'https://cdn.discordapp.com/attachments/1496404849678487552/1507956601133334558/IMG_2980.jpg?ex=6a13c986&is=6a127806&hm=a9edb914e9c1fb0302c0c312c5b23b885f7d887b0c6bcce72443fae83a2bce14&');
        @endphp
        <img src="{{ $heroSrc }}"
             alt="Premium Boarding Room"
             class="absolute inset-0 w-full h-full object-cover" />
        
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60"></div>
        
        <div class="relative z-10 text-center px-6 max-w-4xl mt-16">
            <span class="block text-white/80 text-sm tracking-[0.2em] uppercase font-medium mb-6 reveal">Lombok</span>
            <h1 class="text-5xl md:text-7xl text-white font-sans font-semibold tracking-tight leading-tight mb-8 reveal delay-100">
                Refined living for <br class="hidden md:block">
                <span class="text-white/70 font-light">focused minds.</span>
            </h1>
            <p class="text-white/80 text-lg max-w-lg mx-auto font-light mb-10 reveal delay-200">
                A premium minimalist sanctuary designed for students and professionals who appreciate quiet, clean, and intentional spaces.
            </p>
            <a href="#room" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 text-white px-8 py-4 rounded-full text-sm font-semibold hover:bg-white/20 hover:scale-105 transition-all duration-300 reveal delay-300">
                Explore The Room
                <span class="material-symbols-outlined text-lg">arrow_downward</span>
            </a>
        </div>
    </section>

    <section id="about" class="py-24 bg-white font-sans text-[#0A0A0A]">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-[minmax(240px,auto)]">
            
            <div class="md:col-span-6 md:row-span-2 bg-[#F3F4F6] rounded-[2rem] p-10 md:p-14 flex flex-col justify-between reveal">
                <div class="mb-10">
                    <span class="text-xs font-semibold tracking-widest text-[#4B5563] uppercase mb-4 block">
                        The Philosophy
                    </span>
                    <h2 class="text-4xl md:text-5xl font-sans leading-tight">
                        More than just a room.<br>
                        <span class="font-light text-text-secondary">An editorial standard.</span>
                    </h2>
                </div>
                <div>
                    <p class="text-[#4B5563] text-base md:text-lg leading-relaxed mb-8">
                        We reimagine the boarding house experience in Mataram. Kost Arcadia is built on the principles of spatial harmony and eliminating clutter, embracing natural light, and delivering a seamless living experience in the heart of Lombok.
                    </p>
                    <a href="#facility" class="inline-flex items-center text-sm font-semibold uppercase tracking-widest border-b-2 border-[#0A0A0A] pb-1 hover:opacity-70 transition-opacity">
                        Discover Features
                        <span class="material-symbols-outlined text-sm ml-2">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="md:col-span-3 bg-[#F3F4F6] rounded-[2rem] p-8 flex flex-col justify-center reveal delay-100">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-[#0A0A0A]">wifi</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">100 Mbps Network</h3>
                <p class="text-sm text-[#4B5563] leading-relaxed">
                    Enterprise-grade connection with individual access points per room.
                </p>
            </div>

            <div class="md:col-span-3 bg-[#F3F4F6] rounded-[2rem] p-8 flex flex-col justify-center reveal delay-200">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-[#0A0A0A]">build</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Service Request</h3>
                <p class="text-sm text-[#4B5563] leading-relaxed">
                    Request cleaning or repair services anytime. Track progress and deadlines from your dashboard.
                </p>
            </div>

            <div class="md:col-span-4 relative rounded-[2rem] overflow-hidden min-h-[260px] group reveal delay-300">
                <img src="{{ asset('images/gallery/front-room.jpeg') }}"
                     alt="Modern Room Interior"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-8 w-full z-10">
                    <div class="text-white text-lg font-medium mb-1">Thoughtfully Designed</div>
                    <div class="text-white/70 text-sm">Clean lines, premium materials, and natural light.</div>
                </div>
            </div>

            <div class="md:col-span-2 relative rounded-[2rem] overflow-hidden min-h-[260px] group reveal delay-400">
                <img src="{{ asset('images/gallery/facility.jpeg') }}"
                     alt="Private Facilities"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full z-10">
                    <div class="text-white text-base font-medium mb-1">Private Facilities</div>
                    <div class="text-white/70 text-xs">Ensuite bathroom & premium fittings.</div>
                </div>
            </div>

        </div>
    </div>
</section>

    <section id="facility" class="py-section bg-surface">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="mb-16 reveal">
                <h2 class="text-3xl font-sans mb-4">Curated Facilities</h2>
                <p class="text-text-secondary max-w-xl">Everything you need to live comfortably, without the excess. Included in your flat monthly rate.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-canvas p-8 rounded-2xl border border-border-subtle col-span-1 md:col-span-2 reveal delay-100">
                    <span class="material-symbols-outlined text-3xl mb-6">wifi</span>
                    <h3 class="text-xl font-semibold mb-2">Dedicated High-Speed Network</h3>
                    <p class="text-text-secondary">Enterprise-grade 100 Mbps connection with individual access points per room to ensure zero latency for your online exams or remote work.</p>
                </div>
                <div class="bg-canvas p-8 rounded-2xl border border-border-subtle reveal delay-200">
                    <span class="material-symbols-outlined text-3xl mb-6">build</span>
                    <h3 class="text-xl font-semibold mb-2">On-Demand Services</h3>
                    <p class="text-text-secondary">Request cleaning or repair services directly from your dashboard. Track progress, set deadlines, and get notified when complete.</p>
                </div>
                <div class="bg-canvas p-8 rounded-2xl border border-border-subtle reveal delay-300">
                    <span class="material-symbols-outlined text-3xl mb-6">kitchen</span>
                    <h3 class="text-xl font-semibold mb-2">Communal Pantry</h3>
                    <p class="text-text-secondary">Fully equipped minimalist kitchen with microwave, induction stove, and water dispenser.</p>
                </div>
                <div class="bg-canvas p-8 rounded-2xl border border-border-subtle col-span-1 md:col-span-2 reveal delay-400">
                    <span class="material-symbols-outlined text-3xl mb-6">lock</span>
                    <h3 class="text-xl font-semibold mb-2">Smart Access & Security</h3>
                    <p class="text-text-secondary">Keyless RFID entry to the main gate and your personal room. 24/7 CCTV surveillance in all communal corridors.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-section max-w-7xl mx-auto px-6 md:px-12">
        <div class="mb-16 reveal">
            <h2 class="text-3xl font-sans mb-4">A Glimpse Inside</h2>
            <p class="text-text-secondary max-w-xl">Every corner is intentionally designed. Clean, airy, and thoughtfully composed.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5 auto-rows-[180px] md:auto-rows-[220px]">

            @php
            $gallery = fn($file) => asset("images/gallery/{$file}");
            @endphp

            {{-- Row 1-2, Col 1-2: Front Room (2x2) --}}
            <div class="md:col-span-2 md:row-span-2 relative rounded-[2rem] overflow-hidden group reveal">
                <img src="{{ $gallery('front-room.jpeg') }}" alt="Front Room" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 z-10">
                    <span class="text-white/70 text-xs font-semibold uppercase tracking-widest">The Room</span>
                    <p class="text-white text-lg font-sans">Spacious & Modern</p>
                </div>
            </div>

            {{-- Row 1, Col 3-4: Outdoor (2x1) --}}
            <div class="md:col-span-2 relative rounded-[2rem] overflow-hidden group reveal delay-100">
                <img src="{{ $gallery('kost-field.jpeg') }}" alt="Outdoor" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-5 z-10">
                    <p class="text-white text-sm font-medium">Outdoor Area</p>
                </div>
            </div>

            {{-- Row 2, Col 3: Bathroom --}}
            <div class="relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-200">
                <img src="{{ $gallery('bathroom.jpeg') }}" alt="Bathroom" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4 z-10">
                    <p class="text-white text-sm font-medium">Bathroom</p>
                </div>
            </div>

            {{-- Row 2, Col 4: Private Facility --}}
            <div class="relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-300">
                <img src="{{ $gallery('facility.jpeg') }}" alt="Facilities" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4 z-10">
                    <p class="text-white text-sm font-medium">Private Facility</p>
                </div>
            </div>

            {{-- Row 3, Col 1-2: Kitchen (2x1) --}}
            <div class="md:col-span-2 relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-100">
                <img src="{{ $gallery('communal-kitchen.jpeg') }}" alt="Kitchen" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-5 z-10">
                    <p class="text-white text-sm font-medium">Kitchen</p>
                </div>
            </div>

            {{-- Row 3, Col 3-4: Parking (2x1) --}}
            <div class="md:col-span-2 relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-200">
                <img src="{{ $gallery('parking-space.jpeg') }}" alt="Parking" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-5 z-10">
                    <p class="text-white text-sm font-medium">Parking Space</p>
                </div>
            </div>

        </div>
    </section>

    <section id="room" class="py-section max-w-7xl mx-auto px-6 md:px-12">
        @foreach($roomTypes as $roomType)
        <div class="border border-border-subtle rounded-[2rem] overflow-hidden bg-canvas reveal {{ !$loop->first ? 'mt-12' : '' }}">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="h-[400px] lg:h-auto">
                    @if($roomType->image)
                    <img src="{{ asset('storage/' . $roomType->image) }}" class="w-full h-full object-cover" alt="{{ $roomType->name }}">
                    @else
                    <div class="w-full h-full bg-surface flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-text-secondary/30">bed</span>
                    </div>
                    @endif
                </div>
                <div class="p-10 lg:p-16 flex flex-col justify-center">
                    @php $availableCount = $roomType->rooms->where('status', 'available')->count(); @endphp
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 border border-border-subtle rounded-full text-xs font-semibold uppercase tracking-wider mb-6 w-max">
                        <span class="w-2 h-2 rounded-full {{ $availableCount > 0 ? 'bg-green-500' : 'bg-red-400' }}"></span>
                        {{ $availableCount }} Room{{ $availableCount !== 1 ? 's' : '' }} Available
                    </div>
                    <h2 class="text-4xl font-sans mb-4">{{ $roomType->name }}</h2>

                    <div class="text-text-secondary text-sm leading-relaxed mb-8 max-w-prose whitespace-pre-line">
                        {{ $roomType->description }}
                    </div>

                    <div class="flex items-end gap-3 mb-6">
                        <span class="text-2xl font-semibold">Rp {{ number_format($roomType->price, 0, ',', '.') }}</span>
                        <span class="text-text-secondary text-sm pb-0.5">/ month</span>
                    </div>

                    <a href="{{ url('/book') }}" class="block text-center w-full bg-primary text-white py-3.5 rounded-xl text-sm font-medium hover:bg-black/80 transition-colors tracking-wide">
                        Check Availability
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </section>

    <section id="location" class="py-section border-t border-border-subtle">
        <div class="max-w-7xl mx-auto px-6 md:px-12">

            <div class="mb-16 reveal">
                <h2 class="text-3xl font-sans mb-4">Prime Location</h2>
                <p class="text-text-secondary max-w-xl">Nestled in the heart of Mataram, Lombok. Steps from campuses, dining, and everyday essentials.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-[minmax(240px,auto)]">

                {{-- Map — full width, interactive --}}
                <div class="md:col-span-12 relative rounded-[2rem] overflow-hidden h-[350px] md:h-[450px] reveal">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.5!2d116.145345!3d-8.5853078!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdb900010f60d7%3A0xd5f834f341a1e248!2sARCADIA%20ROOM!5e0!3m2!1sen!2sid!4v1716800000000"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="absolute inset-0 w-full h-full grayscale-[20%]"></iframe>
                    <div class="absolute bottom-6 left-6 md:left-8 z-10">
                        <a href="https://www.google.com/maps/place/ARCADIA+ROOM/@-8.5853078,116.145345,17z/data=!3m1!4b1!4m6!3m5!1s0x2dcdb900010f60d7:0xd5f834f341a1e248!8m2!3d-8.5853078!4d116.145345!16s%2Fg%2F11nbh3s1vr!18m1!1e1?entry=ttu"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 bg-white text-primary px-5 py-3 rounded-full text-sm font-semibold hover:bg-white/90 transition-all shadow-lg">
                            <span class="material-symbols-outlined text-lg">open_in_new</span>
                            Open in Google Maps
                        </a>
                    </div>
                </div>

                {{-- District Highlights --}}
                <div class="md:col-span-8 bg-surface p-8 md:p-10 rounded-[2rem] flex flex-col justify-center reveal delay-100">
                    <span class="text-xs font-semibold tracking-widest text-text-secondary uppercase mb-3">Center of Mataram</span>
                    <h2 class="text-2xl md:text-3xl font-sans mb-5">Arcadia Enclave</h2>
                    <div class="space-y-4 text-text-secondary leading-relaxed text-sm md:text-base">
                        <p>
                            Located in the vibrant <strong class="text-primary">Mataram city center</strong>, Kos Arcadia sits at the crossroads of convenience and calm. Major universities, shopping districts, and healthcare facilities are all within easy reach.
                        </p>
                        <p>
                            Step outside to find local eateries, coffee shops, and minimarkets. Despite the central location, the property is tucked away on a quiet street — the best of both worlds.
                        </p>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="bg-canvas px-4 py-1.5 rounded-full text-xs font-medium text-text-secondary border border-border-subtle">Shopping</span>
                        <span class="bg-canvas px-4 py-1.5 rounded-full text-xs font-medium text-text-secondary border border-border-subtle">Education</span>
                        <span class="bg-canvas px-4 py-1.5 rounded-full text-xs font-medium text-text-secondary border border-border-subtle">Dining</span>
                        <span class="bg-canvas px-4 py-1.5 rounded-full text-xs font-medium text-text-secondary border border-border-subtle">Healthcare</span>
                    </div>
                </div>

                {{-- Proximity --}}
                <div class="md:col-span-4 bg-primary text-white p-8 md:p-10 rounded-[2rem] flex flex-col justify-between reveal delay-200">
                    <div>
                        <h3 class="text-lg font-sans font-semibold mb-6">Walking Distance</h3>
                        <ul class="space-y-4">
                            <li class="flex justify-between items-center border-b border-white/15 pb-3">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-white/50 text-lg">shopping_bag</span>
                                    <span class="text-sm">Mataram Mall</span>
                                </div>
                                <span class="text-xs text-white/50">5 min</span>
                            </li>
                            <li class="flex justify-between items-center border-b border-white/15 pb-3">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-white/50 text-lg">local_cafe</span>
                                    <span class="text-sm">Cafe District</span>
                                </div>
                                <span class="text-xs text-white/50">3 min</span>
                            </li>
                            <li class="flex justify-between items-center border-b border-white/15 pb-3">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-white/50 text-lg">local_hospital</span>
                                    <span class="text-sm">RS Harapan Keluarga</span>
                                </div>
                                <span class="text-xs text-white/50">8 min</span>
                            </li>
                            <li class="flex justify-between items-center border-b border-white/15 pb-3">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-white/50 text-lg">school</span>
                                    <span class="text-sm">Universitas Mataram</span>
                                </div>
                                <span class="text-xs text-white/50">12 min</span>
                            </li>
                        </ul>
                    </div>
                    <p class="text-xs text-white/40 uppercase tracking-widest mt-6">Central Access, Peaceful Living</p>
                </div>

                {{-- Bottom row: 3 info cards --}}
                <div class="md:col-span-4 bg-surface border border-border-subtle p-8 rounded-[2rem] hover:bg-surface/70 transition-colors reveal delay-300">
                    <span class="material-symbols-outlined text-2xl mb-4 text-primary">local_convenience_store</span>
                    <h4 class="text-lg font-semibold mb-2">Daily Essentials</h4>
                    <p class="text-sm text-text-secondary leading-relaxed">Minimarkets, pharmacies, and laundries all within a short walk from the property.</p>
                </div>

                <div class="md:col-span-4 bg-surface border border-border-subtle p-8 rounded-[2rem] hover:bg-surface/70 transition-colors reveal delay-400">
                    <span class="material-symbols-outlined text-2xl mb-4 text-primary">nature_people</span>
                    <h4 class="text-lg font-semibold mb-2">Green Spaces</h4>
                    <p class="text-sm text-text-secondary leading-relaxed">Minutes from Taman Sangkareang and the Mataram city park for morning walks and fresh air.</p>
                </div>

                <div class="md:col-span-4 bg-surface border border-border-subtle p-8 rounded-[2rem] hover:bg-surface/70 transition-colors reveal delay-500">
                    <span class="material-symbols-outlined text-2xl mb-4 text-primary">security</span>
                    <h4 class="text-lg font-semibold mb-2">Secure & Gated</h4>
                    <p class="text-sm text-text-secondary leading-relaxed">24/7 CCTV surveillance with gated entry. Peace of mind comes standard at Kos Arcadia.</p>
                </div>

            </div>
        </div>
    </section>

    <section id="reviews" class="py-section bg-primary text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 md:px-12 text-center">
            <h2 class="text-3xl font-sans mb-12 reveal">Resident Stories</h2>
            @if($reviews->count())
            <div class="relative" x-data="reviewCarousel()" x-init="init()">
                <div class="flex gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar scroll-smooth items-stretch"
                     x-ref="track">
                    @foreach($reviews as $review)
                    <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.25rem)] snap-start shrink-0">
                        <div class="p-8 rounded-2xl bg-white/5 border border-white/10 h-full flex flex-col justify-between min-h-[260px]">
                            <div class="flex-1 min-w-0">
                                <div class="flex gap-1 mb-6 text-white">
                                    @for($i = 0; $i < $review->rating; $i++)
                                    <span class="material-symbols-outlined text-sm">star</span>
                                    @endfor
                                </div>
                                <p class="text-white/80 leading-relaxed mb-8 line-clamp-5" title="{{ $review->comment }}">{{ $review->comment }}</p>
                            </div>
                            <div class="shrink-0">
                                <p class="font-semibold text-sm truncate">{{ $review->user->name }}</p>
                                @if($review->user->profession)
                                <p class="text-xs text-white/50 truncate">{{ $review->user->profession }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <template x-if="showNav">
                    <div class="flex items-center justify-center gap-3 mt-10">
                        <button @click="prev()" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-white/10 transition-colors">
                            <span class="material-symbols-outlined text-sm text-white">chevron_left</span>
                        </button>
                        <template x-for="(_, i) in dots" :key="i">
                            <button @click="go(i)" class="w-2 h-2 rounded-full transition-all duration-300"
                                    :class="i === current ? 'bg-white w-6' : 'bg-white/30'"></button>
                        </template>
                        <button @click="next()" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-white/10 transition-colors">
                            <span class="material-symbols-outlined text-sm text-white">chevron_right</span>
                        </button>
                    </div>
                </template>
            </div>
            @else
            <p class="text-white/60">No reviews yet. Be the first to share your experience!</p>
            @endif
        </div>
    </section>

    @push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function reviewCarousel() {
            return {
                current: 0,
                dots: [],
                showNav: false,
                observer: null,
                scrolling: false,
                init() {
                    const cards = Array.from(this.$refs.track.children);
                    this.dots = cards;
                    this.showNav = cards.length > 3;

                    this.observer = new IntersectionObserver((entries) => {
                        if (this.scrolling) return;
                        const visible = entries
                            .filter(e => e.isIntersecting)
                            .sort((a, b) => a.boundingClientRect.left - b.boundingClientRect.left);
                        if (visible.length) {
                            this.current = cards.indexOf(visible[0].target);
                        }
                    }, { threshold: 0.6, root: this.$refs.track });

                    cards.forEach(c => this.observer.observe(c));
                },
                go(i) {
                    if (i < 0 || i >= this.dots.length) return;
                    this.current = i;
                    this.scrolling = true;
                    const card = this.dots[i];
                    this.$refs.track.scrollTo({ left: card.offsetLeft, behavior: 'smooth' });
                    setTimeout(() => { this.scrolling = false; }, 500);
                },
                next() {
                    this.go(this.current + 1);
                },
                prev() {
                    this.go(this.current - 1);
                },
            };
        }
    </script>

    <footer class="relative bg-[#0A0A0A] text-white overflow-hidden" x-data="footerTextEffect()">
        {{-- Background gradient --}}
        <div class="absolute inset-0 z-0" style="background: radial-gradient(125% 125% at 50% 0%, #0F0F1166 50%, #3ca2fa22 100%);"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 pt-20 pb-10">

            {{-- SVG Text Hover Effect --}}
            <div class="mb-16 -mt-4">
                <svg
                    x-ref="svg"
                    width="100%"
                    height="140"
                    viewBox="0 0 900 140"
                    xmlns="http://www.w3.org/2000/svg"
                    class="select-none cursor-default"
                    @mousemove="onMove($event)"
                    @mouseenter="hovered = true"
                    @mouseleave="hovered = false"
                >
                    <defs>
                        <radialGradient id="footerReveal" gradientUnits="userSpaceOnUse" :cx="maskCx" :cy="maskCy" r="18%">
                            <stop offset="0%" stop-color="white" />
                            <stop offset="100%" stop-color="black" />
                        </radialGradient>
                        <mask id="footerMask">
                            <rect x="0" y="0" width="900" height="140" fill="url(#footerReveal)" />
                        </mask>
                    </defs>

                    {{-- Faint outline visible on hover --}}
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
                        stroke-width="1" fill="none" stroke="#ffffff"
                        font-family="Inter, sans-serif" font-size="120" font-weight="700" letter-spacing="-2"
                        :opacity="hovered ? 0.15 : 0">ARCADIA</text>

                    {{-- Animated white stroke --}}
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
                        stroke-width="1" fill="none" stroke="#ffffff"
                        font-family="Inter, sans-serif" font-size="120" font-weight="700" letter-spacing="-2"
                        class="footer-stroke-draw">ARCADIA</text>

                    {{-- White fill revealed by cursor mask --}}
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
                        stroke="#ffffff" stroke-width="1" fill="none"
                        mask="url(#footerMask)"
                        font-family="Inter, sans-serif" font-size="120" font-weight="700" letter-spacing="-2">ARCADIA</text>
                </svg>
            </div>

            {{-- Footer Content Grid --}}
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
                        <li><a href="#about" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#facility" class="hover:text-white transition-colors">Facilities</a></li>
                        <li><a href="#room" class="hover:text-white transition-colors">The Room</a></li>
                        <li><a href="#location" class="hover:text-white transition-colors">Location</a></li>
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

            {{-- Bottom bar --}}
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
            const navbar = document.getElementById('navbar');
            const links = document.querySelectorAll('.nav-link');
            let scrolled = false;

            window.addEventListener('scroll', () => {
                const past = window.scrollY > 20;
                if (past === scrolled) return;
                scrolled = past;

                if (past) {
                    navbar.classList.add('bg-white/40', 'backdrop-blur-xl', 'border-white/20', 'shadow-sm', 'shadow-black/5');
                    navbar.classList.remove('bg-transparent', 'border-transparent');
                    links.forEach(l => {
                        l.classList.remove('bg-white/10', 'border-white/20', 'text-white', 'hover:bg-white/30');
                        l.classList.add('bg-white/30', 'border-white/40', 'text-primary', 'hover:bg-white/50');
                    });
                } else {
                    navbar.classList.remove('bg-white/40', 'backdrop-blur-xl', 'border-white/20', 'shadow-sm', 'shadow-black/5');
                    navbar.classList.add('bg-transparent', 'border-transparent');
                    links.forEach(l => {
                        l.classList.add('bg-white/10', 'border-white/20', 'text-white', 'hover:bg-white/30');
                        l.classList.remove('bg-white/30', 'border-white/40', 'text-primary', 'hover:bg-white/50');
                    });
                }
            });
        })();
    </script>

    <script>
        (function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal, .reveal-scale').forEach(el => observer.observe(el));
        })();
    </script>

</body>
</html>
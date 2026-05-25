<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Stay | Premium Boarding</title>
    
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
    </style>
</head>
<body class="bg-canvas text-primary font-sans antialiased selection:bg-primary selection:text-white">

    <nav class="fixed top-0 w-full bg-white/40 backdrop-blur-xl border-b border-white/20 shadow-sm shadow-black/5 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 md:px-12 h-20 flex items-center justify-between">
            <div class="flex items-center">
                @if(file_exists(public_path('images/arcadia-logo-no-bg.png')))
                <img src="{{ asset('images/arcadia-logo-no-bg.png') }}" alt="Arcadia" class="h-14 md:h-16 w-auto">
                @else
                <span class="font-sans font-semibold tracking-widest uppercase text-sm">Arca</span>
                @endif
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm font-medium">
                <a href="#about" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">About</a>
                <a href="#facility" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">Facilities</a>
                <a href="#room" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">The Room</a>
                <a href="#location" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">Location</a>
                <a href="{{ url('/book') }}" class="px-4 py-2 rounded-full bg-white/50 backdrop-blur-sm border border-white/60 text-primary hover:bg-white/70 transition-all">Book</a>
            </div>
            <div class="flex items-center gap-4">
                @auth
                <a href="{{ route('booking.page') }}" class="bg-primary text-white px-6 py-3 rounded-full text-xs font-semibold tracking-widest uppercase hover:bg-black/80 transition-all">
                    Book Now
                </a>
                @else
                <a href="{{ route('login') }}" class="px-5 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-sm font-medium text-primary hover:bg-white/50 transition-all">
                    Login
                </a>
                <a href="{{ route('booking.page') }}" class="bg-primary text-white px-6 py-3 rounded-full text-xs font-semibold tracking-widest uppercase hover:bg-black/80 transition-all">
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

    <section class="py-24 bg-white font-sans text-[#0A0A0A]">
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
                        We disrupt the traditional chaotic boarding house model. Urban Stay is built on the principles of spatial harmony, eliminating clutter, and providing a seamless living experience in Malang.
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
                    <span class="material-symbols-outlined text-[#0A0A0A]">cleaning_services</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Weekly Cleaning</h3>
                <p class="text-sm text-[#4B5563] leading-relaxed">
                    Complimentary deep cleaning of your room and bathroom every week.
                </p>
            </div>

            <div class="md:col-span-4 relative rounded-[2rem] overflow-hidden min-h-[260px] group reveal delay-300">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1000&auto=format&fit=crop" 
                     alt="Minimalist interior" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-8 w-full z-10">
                    <div class="text-white text-lg font-medium mb-1">Spatial Harmony</div>
                    <div class="text-white/70 text-sm">Clean lines and authentic materials.</div>
                </div>
            </div>

            <div class="md:col-span-2 relative rounded-[2rem] overflow-hidden min-h-[260px] group reveal delay-400">
                <img src="https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80&w=600&auto=format&fit=crop" 
                     alt="Smart Access" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full z-10">
                    <div class="text-white text-base font-medium mb-1">Smart Access</div>
                    <div class="text-white/70 text-xs">RFID Keyless entry.</div>
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
                    <span class="material-symbols-outlined text-3xl mb-6">cleaning_services</span>
                    <h3 class="text-xl font-semibold mb-2">Weekly Housekeeping</h3>
                    <p class="text-text-secondary">Complimentary deep cleaning of your room and bathroom every week.</p>
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

            @php $featuredType = $roomTypes->first(); @endphp

            {{-- Row 1-2, Col 1-2: Large feature (2x2) --}}
            <div class="md:col-span-2 md:row-span-2 relative rounded-[2rem] overflow-hidden group reveal">
                @if($featuredType?->image)
                <img src="{{ asset("storage/{$featuredType->image}") }}" alt="Room interior" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                @else
                <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&auto=format&fit=crop" alt="Room interior" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 z-10">
                    <span class="text-white/70 text-xs font-semibold uppercase tracking-widest">The Suite</span>
                    <p class="text-white text-lg font-sans">{{ $featuredType?->name ?? 'Standard Room' }}</p>
                </div>
            </div>

            {{-- Row 1, Col 3: Small --}}
            <div class="relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-100">
                <img src="https://images.unsplash.com/photo-1560185007-cde436f6a4d0?w=400&auto=format&fit=crop" alt="Minimalist workspace" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4 z-10">
                    <p class="text-white text-sm font-medium">Workspace</p>
                </div>
            </div>

            {{-- Row 1, Col 4: Small --}}
            <div class="relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-200">
                <img src="https://images.unsplash.com/photo-1586105251261-72a756497a11?w=400&auto=format&fit=crop" alt="Lighting details" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4 z-10">
                    <p class="text-white text-sm font-medium">Ambient Light</p>
                </div>
            </div>

            {{-- Row 2, Col 3-4: Wide landscape --}}
            <div class="md:col-span-2 relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-300">
                <img src="https://images.unsplash.com/photo-1538688525198-9b88f6f53126?w=800&auto=format&fit=crop" alt="Common area" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-5 z-10">
                    <p class="text-white text-sm font-medium">Communal Lounge</p>
                </div>
            </div>

            {{-- Row 3, Col 1: Small --}}
            <div class="relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-100">
                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&auto=format&fit=crop" alt="Interior detail" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4 z-10">
                    <p class="text-white text-sm font-medium">Details</p>
                </div>
            </div>

            {{-- Row 3, Col 2: Small --}}
            <div class="relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-200">
                <img src="https://images.unsplash.com/photo-1554995207-c18c203602cb?w=400&auto=format&fit=crop" alt="Smart lock" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4 z-10">
                    <p class="text-white text-sm font-medium">Keyless Entry</p>
                </div>
            </div>

            {{-- Row 3, Col 3-4: Wide landscape --}}
            <div class="md:col-span-2 relative rounded-[2rem] overflow-hidden group bg-surface reveal delay-300">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&auto=format&fit=crop" alt="Hallway" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-5 z-10">
                    <p class="text-white text-sm font-medium">Hallway</p>
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
        <div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-16">

            <div class="reveal">
                <h2 class="text-3xl font-sans mb-6">Strategic Location</h2>
                <p class="text-text-secondary mb-8 leading-relaxed">
                    Situated in the heart of Malang's educational district. Close enough to walk to major campuses, yet tucked away in a quiet residential street to ensure peace of mind.
                </p>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-surface flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">school</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">5 mins to Binus University</h4>
                            <p class="text-sm text-text-secondary">Quick commute for students.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-surface flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">local_cafe</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Surrounded by Cafe & Eateries</h4>
                            <p class="text-sm text-text-secondary">Walking distance to local coffee shops and minimarkets.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-surface p-10 rounded-2xl reveal delay-200">
                <h2 class="text-2xl font-sans mb-6">House Rules</h2>
                <p class="text-sm text-text-secondary mb-8">To maintain the premium standard and comfort for all residents, we strictly enforce these rules:</p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 bg-canvas p-4 rounded-xl border border-border-subtle">
                        <span class="material-symbols-outlined text-primary">smoke_free</span>
                        <div>
                            <h4 class="font-semibold text-sm">Strictly Non-Smoking</h4>
                            <p class="text-xs text-text-secondary">Inside rooms and all communal areas.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 bg-canvas p-4 rounded-xl border border-border-subtle">
                        <span class="material-symbols-outlined text-primary">volume_off</span>
                        <div>
                            <h4 class="font-semibold text-sm">Quiet Hours</h4>
                            <p class="text-xs text-text-secondary">10:00 PM to 06:00 AM. Respect your neighbors.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 bg-canvas p-4 rounded-xl border border-border-subtle">
                        <span class="material-symbols-outlined text-primary">group_off</span>
                        <div>
                            <h4 class="font-semibold text-sm">No Overnight Guests</h4>
                            <p class="text-xs text-text-secondary">For security and privacy reasons, guests are only allowed in the lobby until 9 PM.</p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    <section class="py-section bg-primary text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 md:px-12 text-center">
            <h2 class="text-3xl font-sans mb-12 reveal">Resident Stories</h2>
            @if($reviews->count())
            <div class="relative" x-data="reviewCarousel()" x-init="init()">
                <div class="flex gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar scroll-smooth items-stretch"
                     x-ref="track"
                     @scroll="update()">
                    @foreach($reviews as $review)
                    <div class="min-w-[calc(100%-2rem)] md:min-w-[calc(50%-1rem)] lg:min-w-[calc(33.333%-1.25rem)] snap-start shrink-0">
                        <div class="p-8 rounded-2xl bg-white/5 border border-white/10 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex gap-1 mb-6 text-white">
                                    @for($i = 0; $i < $review->rating; $i++)
                                    <span class="material-symbols-outlined text-sm">star</span>
                                    @endfor
                                </div>
                                <p class="text-white/80 leading-relaxed mb-8">{{ $review->comment }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-sm">{{ $review->user->name }}</p>
                                @if($review->user->profession)
                                <p class="text-xs text-white/50">{{ $review->user->profession }}</p>
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
                init() {
                    this.dots = Array.from(this.$refs.track.children);
                    this.showNav = this.dots.length > 3;
                    this.update();
                },
                update() {
                    const track = this.$refs.track;
                    const card = track.children[0];
                    if (!card) return;
                    const scroll = track.scrollLeft;
                    const w = card.offsetWidth + 24; // card width + gap
                    this.current = Math.round(scroll / w);
                },
                go(i) {
                    const card = this.$refs.track.children[i];
                    if (card) card.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
                },
                next() {
                    this.go(Math.min(this.current + 1, this.dots.length - 1));
                },
                prev() {
                    this.go(Math.max(this.current - 1, 0));
                },
            };
        }
    </script>

    <footer class="bg-canvas border-t border-border-subtle pt-24 pb-10 reveal">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-24">
                <div>
                    <h2 class="text-5xl md:text-7xl font-sans font-bold tracking-tighter uppercase mb-6">URBAN STAY.</h2>
                    <p class="text-text-secondary text-lg max-w-sm">The new standard of premium student and professional living in Malang.</p>
                </div>
                <div class="flex flex-col lg:items-end justify-start">
                    <a href="mailto:hello@urbanstay.id" class="text-2xl font-sans border-b border-primary pb-1 hover:text-text-secondary hover:border-text-secondary transition-colors mb-4">hello@urbanstay.id</a>
                    <a href="https://wa.me/6280000000" class="text-text-secondary hover:text-primary transition-colors">WhatsApp: +62 800 0000 0000</a>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center border-t border-border-subtle pt-8 text-xs font-semibold text-text-secondary uppercase tracking-widest gap-4">
                <div>© 2026 URBAN STAY MALANG. ALL RIGHTS RESERVED.</div>
                <div class="flex gap-8">
                    <a href="#" class="hover:text-primary transition-colors">Instagram</a>
                    <a href="#" class="hover:text-primary transition-colors">Terms</a>
                    <a href="#" class="hover:text-primary transition-colors">Privacy</a>
                </div>
            </div>
        </div>
    </footer>

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
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Arcadia Kost — Dashboard</title>
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
    <nav class="fixed top-0 w-full bg-white/40 backdrop-blur-xl border-b border-white/20 shadow-sm shadow-black/5 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 md:px-12 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if(file_exists(public_path('images/arcadia-logo-no-bg.png')))
                <img src="{{ asset('images/arcadia-logo-no-bg.png') }}" alt="Arcadia" class="h-14 md:h-16 w-auto">
                @else
                <span class="font-sans font-semibold tracking-widest uppercase text-sm">Arca</span>
                @endif
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full bg-primary/5 text-primary font-semibold">Dashboard</a>
                <a href="{{ url('/') }}" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">Home</a>
                <a href="{{ route('booking.page') }}" class="px-4 py-2 rounded-full bg-white/30 backdrop-blur-sm border border-white/40 text-primary hover:bg-white/50 transition-all">Bookings</a>
            </div>
            <div class="flex items-center gap-3">
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
                    @if($activeBooking)
                    <p class="text-xs text-text-secondary mt-1">
                        Room <span class="font-semibold text-primary">{{ $activeBooking->room->room_number }}</span> &middot; {{ $activeBooking->room->roomType->name }}
                    </p>
                    @else
                    <p class="text-xs text-text-secondary mt-1">No active stay</p>
                    @endif
                </div>

                <nav class="mt-4 bg-white rounded-2xl border border-border-subtle shadow-sm p-2 flex flex-row lg:flex-col overflow-x-auto gap-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/5 text-primary font-semibold transition-all">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                        <span class="text-sm font-medium whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="{{ route('booking.my-bookings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-surface transition-all">
                        <span class="material-symbols-outlined">night_shelter</span>
                        <span class="text-sm font-medium whitespace-nowrap">My Bookings</span>
                    </a>
                    @if($activeBooking)
                    <a href="{{ route('service.create', $activeBooking->id) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-surface transition-all">
                        <span class="material-symbols-outlined">build</span>
                        <span class="text-sm font-medium whitespace-nowrap">Request Service</span>
                    </a>
                    @endif
                </nav>
            </aside>

            {{-- Main Content --}}
            <section class="flex-1 space-y-8 min-w-0">

                {{-- Welcome Header --}}
                <header class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-primary">Welcome back, {{ auth()->user()->name }}</h1>
                        <p class="text-text-secondary text-sm mt-1">Manage your stay and check your property status.</p>
                    </div>
                    @if($activeBooking)
                    <div class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-full w-fit text-xs font-medium">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">verified</span>
                        Active Resident
                    </div>
                    @endif
                </header>

                {{-- Stat Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Monthly Bill --}}
                    <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-6">
                            <div class="p-3 rounded-xl bg-red-50 text-red-500">
                                <span class="material-symbols-outlined text-3xl">receipt_long</span>
                            </div>
                            @if($activeBooking)
                            @if($daysUntilDue === 0)
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">Due Today</span>
                            @else
                            <span class="px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-medium">{{ $daysUntilDue }} day{{ $daysUntilDue > 1 ? 's' : '' }} left</span>
                            @endif
                            @endif
                        </div>
                        <p class="text-xs text-text-secondary uppercase tracking-wider mb-1">Monthly Bill</p>
                        @if($activeBooking)
                        <h2 class="text-2xl font-bold text-primary">Rp {{ number_format($activeBooking->room->roomType->price, 0, ',', '.') }}</h2>
                        <p class="text-xs text-text-secondary mt-3">Due on {{ $nextDueDate->format('d F Y') }}.</p>
                        @else
                        <h2 class="text-2xl font-bold text-primary">—</h2>
                        <p class="text-xs text-text-secondary mt-3">No active booking. <a href="{{ route('booking.page') }}" class="text-primary underline font-medium">Book a room</a> to get started.</p>
                        @endif
                    </div>

                    {{-- WiFi Password --}}
                    <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div class="p-3 rounded-xl bg-blue-50 text-blue-500">
                                <span class="material-symbols-outlined text-3xl">wifi</span>
                            </div>
                        </div>
                        <p class="text-xs text-text-secondary uppercase tracking-wider mb-1">WiFi Password</p>
                        @if($activeBooking)
                        <div class="flex items-center justify-between bg-surface px-4 py-3 rounded-xl border border-dashed border-border-subtle mt-2">
                            <code class="font-bold text-primary tracking-widest text-sm">{{ $wifiPassword }}</code>
                            <button onclick="copyWifi()" class="text-text-secondary hover:text-primary transition-colors" title="Copy password">
                                <span class="material-symbols-outlined text-lg" id="copy-icon">content_copy</span>
                            </button>
                        </div>
                        <p class="text-xs text-text-secondary mt-3 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">speed</span>
                            Up to 100 Mbps Unlimited
                        </p>
                        @else
                        <p class="text-sm text-text-secondary mt-2">Available for active residents only.</p>
                        @endif
                    </div>

                    {{-- Booking Status --}}
                    <div class="bg-white rounded-2xl border border-border-subtle shadow-sm p-6 relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div class="p-3 rounded-xl bg-green-50 text-green-600">
                                    <span class="material-symbols-outlined text-3xl">apartment</span>
                                </div>
                            </div>
                            <p class="text-xs text-text-secondary uppercase tracking-wider mb-1">Booking Status</p>
                            @if($activeBooking)
                            <h2 class="text-lg font-bold text-primary">Active</h2>
                            <p class="text-xs text-text-secondary mt-1">Check-in: {{ \Carbon\Carbon::parse($activeBooking->start_date)->format('d M Y') }}</p>
                            <p class="text-xs text-text-secondary">Contract ends: {{ \Carbon\Carbon::parse($activeBooking->end_date)->format('d M Y') }}</p>
                            @else
                            <h2 class="text-lg font-bold text-primary">No Active Stay</h2>
                            <a href="{{ route('booking.page') }}" class="inline-block mt-2 text-xs text-primary font-medium underline hover:no-underline">Browse available rooms</a>
                            @endif
                        </div>
                        <div class="absolute -bottom-4 -right-4 opacity-[0.04] text-primary">
                            <span class="material-symbols-outlined text-[120px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <section>
                    <h3 class="text-lg font-bold text-primary mb-5">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @if($activeBooking)
                        <a href="{{ route('service.create', $activeBooking->id) }}" class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-border-subtle hover:bg-surface transition-colors group">
                            <div class="p-3 bg-surface rounded-xl text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">handyman</span>
                            </div>
                            <span class="text-sm font-semibold text-primary">Request Service</span>
                        </a>
                        <a href="{{ route('review.create', $activeBooking->id) }}" class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-border-subtle hover:bg-surface transition-colors group">
                            <div class="p-3 bg-surface rounded-xl text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">reviews</span>
                            </div>
                            <span class="text-sm font-semibold text-primary">Write Review</span>
                        </a>
                        <a href="{{ route('booking.extend', $activeBooking->id) }}" onclick="event.preventDefault(); document.getElementById('extend-form').submit();" class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-border-subtle hover:bg-surface transition-colors group">
                            <div class="p-3 bg-surface rounded-xl text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">autorenew</span>
                            </div>
                            <span class="text-sm font-semibold text-primary">Extend Stay</span>
                        </a>
                        <form id="extend-form" action="{{ route('booking.extend', $activeBooking->id) }}" method="POST" class="hidden">@csrf</form>
                        @else
                        <a href="{{ route('booking.page') }}" class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-border-subtle hover:bg-surface transition-colors group">
                            <div class="p-3 bg-surface rounded-xl text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">night_shelter</span>
                            </div>
                            <span class="text-sm font-semibold text-primary">Book a Room</span>
                        </a>
                        @endif
                        <a href="{{ route('booking.my-bookings') }}" class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-border-subtle hover:bg-surface transition-colors group">
                            <div class="p-3 bg-surface rounded-xl text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">history</span>
                            </div>
                            <span class="text-sm font-semibold text-primary">View History</span>
                        </a>
                    </div>
                </section>

                {{-- Recent Activity --}}
                <section class="bg-white rounded-2xl border border-border-subtle shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-border-subtle flex justify-between items-center">
                        <h3 class="text-lg font-bold text-primary">Recent Activity</h3>
                    </div>
                    @if($recentActivity->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <span class="material-symbols-outlined text-5xl text-text-secondary/15 mb-3">inbox</span>
                        <p class="text-text-secondary text-sm">No recent activity yet.</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-surface/50">
                                    <th class="px-6 py-3 text-xs text-text-secondary uppercase tracking-wider font-medium">Description</th>
                                    <th class="px-6 py-3 text-xs text-text-secondary uppercase tracking-wider font-medium">Date</th>
                                    <th class="px-6 py-3 text-xs text-text-secondary uppercase tracking-wider font-medium">Amount</th>
                                    <th class="px-6 py-3 text-xs text-text-secondary uppercase tracking-wider font-medium text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-subtle">
                                @foreach($recentActivity as $activity)
                                <tr class="hover:bg-surface/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-text-secondary text-lg">{{ $activity['icon'] }}</span>
                                            <span class="text-sm font-medium text-primary">{{ $activity['title'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-text-secondary">{{ \Carbon\Carbon::parse($activity['date'])->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-primary">
                                        {{ $activity['amount'] ? 'Rp ' . number_format($activity['amount'], 0, ',', '.') : '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @php
                                            $statusColors = [
                                                'success'     => 'bg-green-50 text-green-700',
                                                'pending'     => 'bg-orange-50 text-orange-700',
                                                'failed'      => 'bg-red-50 text-red-600',
                                                'completed'   => 'bg-green-50 text-green-700',
                                                'active'      => 'bg-green-50 text-green-700',
                                                'validated'   => 'bg-blue-50 text-blue-700',
                                                'in_progress' => 'bg-blue-50 text-blue-700',
                                                'cancelled'   => 'bg-red-50 text-red-600',
                                            ];
                                            $color = $statusColors[$activity['status']] ?? 'bg-surface text-text-secondary';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $color }}">
                                            {{ ucfirst(str_replace('_', ' ', $activity['status'])) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </section>

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
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ url('/') }}#facility" class="hover:text-white transition-colors">Facilities</a></li>
                        <li><a href="{{ url('/') }}#gallery" class="hover:text-white transition-colors">Gallery</a></li>
                        <li><a href="{{ url('/') }}#location" class="hover:text-white transition-colors">Location</a></li>
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

    <x-chat-widget />

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

        function copyWifi() {
            const code = document.querySelector('#copy-icon').closest('div').querySelector('code').innerText;
            navigator.clipboard.writeText(code).then(() => {
                const icon = document.getElementById('copy-icon');
                icon.innerText = 'check';
                icon.style.color = '#16a34a';
                setTimeout(() => {
                    icon.innerText = 'content_copy';
                    icon.style.color = '';
                }, 2000);
            });
        }
    </script>

</body>
</html>

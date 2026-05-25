<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Kos Arcadia') }} - My Bookings</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Be+Vietnam+Pro:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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
<body class="bg-background text-on-surface font-body-md">

    <header class="docked full-width top-0 sticky z-50 bg-surface/80 backdrop-blur-md shadow-sm shadow-primary/5 border-b border-outline-variant/30">
        <nav class="flex justify-between items-center w-full px-container-padding py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-8">
                <a href="{{ url('/') }}" class="font-display-lg text-display-lg font-bold text-primary tracking-tight">Kos Arcadia</a>
                <div class="hidden md:flex items-center gap-6">
                    <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
                    <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ route('booking.page') }}">Rooms</a>
                    <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#facility">Amenities</a>
                    <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#location">Location</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('booking.page') }}" class="hidden md:flex px-6 py-2 bg-primary text-on-primary font-label-lg text-label-lg rounded-full hover:bg-primary-container transition-all active:scale-95">Book Now</a>
                <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-full bg-surface-container overflow-hidden border border-outline-variant/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">person</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-container-padding py-section-gap-mobile md:py-section-gap-desktop">
        <div class="mb-10">
            <h1 class="font-headline-lg text-headline-lg text-primary mb-2">My Bookings</h1>
            <p class="text-on-surface-variant font-body-md">Kelola semua reservasi anda dalam satu tempat.</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-secondary-container text-on-secondary-container rounded-xl font-label-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-xl">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        @if($bookings->isEmpty())
        <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4">night_shelter</span>
            <h3 class="font-headline-md text-headline-md text-primary mb-2">Belum ada kamar yang dipesan</h3>
            <p class="text-on-surface-variant font-body-md mb-8">Mulai pilih kamar yang nyaman untuk Anda tempati.</p>
            <a href="{{ route('booking.page') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-on-primary font-label-lg text-label-lg rounded-xl hover:bg-primary-container transition-all active:scale-95">
                <span class="material-symbols-outlined">search</span>
                Lihat Katalog Kamar
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($bookings as $booking)
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-md transition-shadow">

                {{-- Status header --}}
                <div class="px-6 py-4 border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-low">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">
                        Dipesan {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                    </span>
                    @if($booking->status == 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm text-label-sm bg-[#fff3e0] text-[#e65100] border border-[#ffe0b2]">
                            Menunggu Pembayaran
                        </span>
                    @elseif($booking->status == 'review')
                        <span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm text-label-sm bg-[#e3f2fd] text-[#1565c0] border border-[#bbdefb]">
                            Menunggu Konfirmasi
                        </span>
                    @elseif($booking->status == 'active')
                        <span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm text-label-sm bg-secondary-container text-on-secondary-container border border-secondary-fixed-dim/50">
                            Aktif
                        </span>
                    @elseif($booking->status == 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm text-label-sm bg-[#e8f5e9] text-[#2e7d32] border border-[#c8e6c9]">
                            Selesai
                        </span>
                    @elseif($booking->status == 'cancelled')
                        <span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm text-label-sm bg-error-container text-on-error-container border border-error-container">
                            Dibatalkan
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant border border-outline-variant/30">
                            {{ ucfirst($booking->status) }}
                        </span>
                    @endif
                </div>

                {{-- Room details --}}
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="font-headline-md text-headline-md text-primary">{{ $booking->room->roomType->name }}</h3>
                            <p class="text-on-surface-variant font-body-md mt-1">
                                <span class="material-symbols-outlined text-sm align-middle">door_open</span>
                                Kamar <span class="font-bold text-on-surface">{{ $booking->room->room_number }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Total</p>
                            <p class="font-headline-md text-headline-md text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant/10">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">Tanggal Masuk</p>
                                <p class="font-label-lg text-label-lg text-on-surface">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">Jatuh Tempo</p>
                                <p class="font-label-lg text-label-lg text-on-surface">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-outline-variant/10">
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Durasi <span class="font-bold text-primary">{{ $booking->duration_months }} Bulan</span></p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/50 flex flex-col gap-2">
                    @if($booking->status == 'pending')
                        <a href="{{ route('booking.pay', $booking->id) }}" class="flex items-center justify-center gap-2 w-full bg-primary text-on-primary font-label-lg text-label-lg py-3 rounded-xl hover:bg-primary-container transition-all active:scale-95">
                            <span class="material-symbols-outlined text-sm">payments</span>
                            Bayar Sekarang
                        </a>
                    @elseif($booking->status == 'review')
                        <p class="text-center font-label-sm text-label-sm text-on-surface-variant py-2 flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-sm">hourglass_top</span>
                            Menunggu konfirmasi admin
                        </p>
                    @elseif($booking->status == 'active')
                        <form action="{{ route('booking.extend', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center justify-center gap-2 w-full bg-secondary text-on-secondary font-label-lg text-label-lg py-3 rounded-xl hover:bg-on-secondary-container transition-all active:scale-95">
                                <span class="material-symbols-outlined text-sm">autorenew</span>
                                Perpanjang Sewa (1 Bulan)
                            </button>
                        </form>
                        @if(!$booking->review)
                        <a href="{{ route('review.create', $booking->id) }}" class="flex items-center justify-center gap-2 w-full border border-outline-variant text-primary font-label-lg text-label-lg py-3 rounded-xl hover:bg-surface-container transition-all">
                            <span class="material-symbols-outlined text-sm">reviews</span>
                            Tulis Review
                        </a>
                        @endif
                        <a href="{{ route('service.create', $booking->id) }}" class="flex items-center justify-center gap-2 w-full border border-outline-variant text-on-surface-variant font-label-sm text-label-sm py-2 rounded-xl hover:bg-surface-container transition-all">
                            <span class="material-symbols-outlined text-sm">build</span>
                            Request Service
                        </a>
                    @elseif($booking->status == 'completed')
                        @if(!$booking->review)
                        <a href="{{ route('review.create', $booking->id) }}" class="flex items-center justify-center gap-2 w-full bg-primary text-on-primary font-label-lg text-label-lg py-3 rounded-xl hover:bg-primary-container transition-all active:scale-95">
                            <span class="material-symbols-outlined text-sm">reviews</span>
                            Tulis Review
                        </a>
                        @endif
                    @endif
                </div>

            </div>
            @endforeach
        </div>
        @endif
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
                <h4 class="font-label-lg text-label-lg font-bold text-primary mb-6">Discover</h4>
                <ul class="space-y-3">
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ route('booking.page') }}">Rooms</a></li>
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ url('/') }}#facility">Amenities</a></li>
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="{{ url('/') }}#location">Location</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg font-bold text-primary mb-6">Company</h4>
                <ul class="space-y-3">
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">About Us</a></li>
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">Contact</a></li>
                    <li><a class="font-label-sm text-label-sm text-on-surface-variant hover:underline decoration-secondary transition-all" href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg font-bold text-primary mb-6">Newsletter</h4>
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
                &copy; {{ date('Y') }} Kos Arcadia Lombok. Luxury Managed Boarding.
            </p>
        </div>
    </footer>

</body>
</html>

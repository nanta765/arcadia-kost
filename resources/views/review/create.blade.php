<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Kos Arcadia') }} - Tulis Ulasan</title>

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

    <main class="max-w-lg mx-auto px-container-padding py-section-gap-mobile md:py-section-gap-desktop">
        <div class="mb-8">
            <h1 class="font-headline-lg text-headline-lg text-primary mb-2">Ulas Pengalamanmu</h1>
            <p class="text-on-surface-variant font-body-md">Bantu calon penghuni lain dengan ulasan jujurmu.</p>
        </div>

        {{-- Room info card --}}
        <div class="bg-primary-container/20 border border-primary-fixed-dim/30 rounded-2xl p-5 mb-6 flex items-center justify-between">
            <div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Kamar</p>
                <p class="font-headline-md text-headline-md text-primary">{{ $booking->room->room_number }}</p>
            </div>
            <div class="text-right">
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Tipe</p>
                <p class="font-label-lg text-label-lg text-primary">{{ $booking->room->roomType->name }}</p>
            </div>
        </div>

        {{-- Error messages --}}
        @if ($errors->any())
        <div class="mb-6 p-4 bg-error-container text-on-error-container rounded-xl font-label-sm">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-error-container text-on-error-container rounded-xl font-label-sm flex items-center gap-2">
            <span class="material-symbols-outlined">error</span>
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 shadow-sm p-6">
            <form action="{{ route('review.store', $booking->id) }}" method="POST">
                @csrf

                {{-- Star rating --}}
                <div class="mb-6">
                    <label class="block font-label-lg text-label-lg text-primary mb-4 text-center">Berapa bintang untuk kamar ini?</label>
                    <div class="flex justify-center gap-2" id="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn cursor-pointer bg-transparent border-0 p-0" data-value="{{ $i }}">
                            <span class="material-symbols-outlined text-4xl text-outline-variant transition-colors duration-150 star-icon"
                                data-value="{{ $i }}"
                                style="font-variation-settings: 'FILL' 0;">
                                star
                            </span>
                        </button>
                        @endfor
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', '') }}" required>
                    </div>
                    @error('rating')
                    <p class="text-error text-label-sm mt-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Comment --}}
                <div class="mb-6 pt-6 border-t border-outline-variant/20">
                    <label for="comment" class="block font-label-lg text-label-lg text-primary mb-2">
                        Ceritakan pengalamanmu
                    </label>
                    <textarea name="comment" id="comment" rows="4" placeholder="Kamar bersih, fasilitas lengkap, air lancar..."
                        class="w-full text-body-md text-on-surface bg-surface-container-low border border-outline-variant rounded-xl p-4 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none transition-all">{{ old('comment') }}</textarea>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-primary text-on-primary font-label-lg text-label-lg py-4 rounded-xl hover:bg-primary-container transition-all active:scale-95 shadow-sm">
                    <span class="material-symbols-outlined">send</span>
                    Kirim Ulasan
                </button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('my-bookings') }}" class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary font-label-sm text-label-sm transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke My Bookings
            </a>
        </div>
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
                    <button type="submit" class="bg-primary text-on-primary px-4 rounded-lg"><span class="material-symbols-outlined">arrow_forward</span></button>
                </form>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-container-padding pb-8">
            <p class="font-label-sm text-label-sm text-on-surface-variant text-center opacity-60">
                &copy; {{ date('Y') }} Kos Arcadia Lombok. Luxury Managed Boarding.
            </p>
        </div>
    </footer>

    <script>
        (function() {
            const stars = document.querySelectorAll('.star-icon');
            const buttons = document.querySelectorAll('.star-btn');
            const input = document.getElementById('rating-input');
            const filledColor = '#f59e0b';
            const emptyColor = '';
            let selectedValue = parseInt(input.value) || 0;

            function fillUpTo(value) {
                stars.forEach(s => {
                    const v = parseInt(s.dataset.value);
                    if (v <= value) {
                        s.style.color = filledColor;
                        s.style.fontVariationSettings = "'FILL' 1";
                    } else {
                        s.style.color = emptyColor;
                        s.style.fontVariationSettings = "'FILL' 0";
                    }
                });
            }

            // Initial state from old()
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

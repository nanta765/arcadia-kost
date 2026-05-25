<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Kos Arcadia') }} - Login & Registration</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Be+Vietnam+Pro:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
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
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .form-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-effect {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md overflow-x-hidden">
    <nav class="bg-surface/80 backdrop-blur-md border-b border-outline-variant/30 docked full-width top-0 sticky z-50 shadow-sm shadow-primary/5">
        <div class="flex justify-between items-center w-full px-container-padding py-4 max-w-7xl mx-auto">
            <a href="{{ url('/') }}" class="font-display-lg text-headline-md md:text-display-lg font-bold text-primary tracking-tight">Kos Arcadia</a>
            <div class="hidden md:flex gap-8 items-center">
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/rooms') }}">Rooms</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/amenities') }}">Amenities</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/location') }}">Location</a>
                <button onclick="window.location.href='{{ url('/booking') }}';" class="bg-primary text-on-primary px-6 py-2 rounded-lg font-label-lg text-label-lg hover:bg-primary-container transition-all active:scale-95">Book Now</button>
            </div>
            <div class="md:hidden">
                <span class="material-symbols-outlined text-primary text-3xl cursor-pointer">menu</span>
            </div>
        </div>
    </nav>

    <main class="min-h-[calc(100vh-80px)] flex flex-col md:flex-row w-full max-w-[1920px] mx-auto overflow-hidden">
        <section class="hidden md:block w-1/2 relative min-h-[600px]">
            <div class="absolute inset-0 bg-primary/20 z-10"></div>
            <img alt="Luxury Resort Lombok" class="absolute inset-0 w-full h-full object-cover" data-alt="A luxurious tropical resort exterior in Lombok at sunset. The scene features modern white architectural lines of a boutique boarding house with lush palm trees, a shimmering turquoise swimming pool, and a warm golden hour sky. The photography style is clean and high-end, emphasizing the serene and premium atmosphere of Kos Arcadia." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhEWOs7vlH_IraPCDbPpPT8snfBTCXVhpdu52t-t69BAhLsZkEyKhQvjNxCnDgM4IPqtgCY_UD78UOfiwusxm7j3tvOgLTNjANCOq-WxaEnpMWMFmfFriLe4M--R6vZdQJIxZv_CN8dt_rd0N2-MCBo8FUDOivN37o4tEuTAwqD-ohSt0aXMPSLuL4GLvi4J9KFas9EqgijbLwiO3x6UezfamUE0JOHeniiibrBFSHSY6ZfqruXoCf6LM5KqVqDopjGCOPmRTgC9Y">
            <div class="absolute bottom-16 left-16 z-20 max-w-md">
                <h1 class="font-display-lg text-display-lg text-white mb-4">Escape to Tranquility.</h1>
                <p class="font-body-lg text-body-lg text-white/90">Experience the perfect blend of modern minimalist living and organic tropical beauty in the heart of Lombok.</p>
            </div>
        </section>

        <section class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-12 lg:p-24 bg-surface-bright">
            <div class="w-full max-w-md">
                <div class="flex mb-12 bg-surface-container rounded-xl p-1 relative">
                    <button class="flex-1 py-3 text-center rounded-lg font-label-lg text-label-lg z-10 transition-all duration-300 text-primary font-bold" id="tab-masuk" onclick="toggleAuth('masuk')">Masuk</button>
                    <button class="flex-1 py-3 text-center rounded-lg font-label-lg text-label-lg z-10 transition-all duration-300 text-on-surface-variant" id="tab-daftar" onclick="toggleAuth('daftar')">Daftar</button>
                    <div class="absolute top-1 left-1 w-[calc(50%-4px)] h-[calc(100%-8px)] bg-white shadow-sm rounded-lg transition-transform duration-300 transform translate-x-0" id="tab-slider"></div>
                </div>
                
                <div class="mb-8">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-2" id="form-title">Selamat Datang</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant" id="form-subtitle">Masuk untuk mengelola reservasi anda.</p>
                </div>

                {{-- Update form action to route dynamically using Laravel --}}
                <form method="POST" action="{{ url('/login') }}" class="space-y-6" id="auth-form">
                    @csrf
                    <input type="hidden" id="auth-mode" value="{{ $mode ?? 'login' }}">
                    <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-name">
                        <label class="block font-label-lg text-label-lg text-primary mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">person</span>
                            <input name="name" class="w-full pl-12 pr-4 py-4 rounded-xl border border-outline-variant bg-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="John Doe" type="text" value="{{ old('name') }}">
                        </div>
                        @error('name')
                        <p class="text-error text-label-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-label-lg text-label-lg text-primary mb-2">Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">mail</span>
                            <input name="email" class="w-full pl-12 pr-4 py-4 rounded-xl border border-outline-variant bg-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="email@arcadia.com" type="email" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                        <p class="text-error text-label-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-label-lg text-label-lg text-primary mb-2">Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">lock</span>
                            <input name="password" class="w-full pl-12 pr-12 py-4 rounded-xl border border-outline-variant bg-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="••••••••" type="password" required>
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary" type="button">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-error text-label-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-password-confirmation">
                        <label class="block font-label-lg text-label-lg text-primary mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">lock</span>
                            <input name="password_confirmation" class="w-full pl-12 pr-4 py-4 rounded-xl border border-outline-variant bg-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="••••••••" type="password">
                        </div>
                        @error('password_confirmation')
                        <p class="text-error text-label-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-phone">
                        <label class="block font-label-lg text-label-lg text-primary mb-2">Nomor Telepon</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">call</span>
                            <input name="phone_number" class="w-full pl-12 pr-4 py-4 rounded-xl border border-outline-variant bg-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="+62 812 3456 7890" type="tel" value="{{ old('phone_number') }}">
                        </div>
                        @error('phone_number')
                        <p class="text-error text-label-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-profession">
                        <label class="block font-label-lg text-label-lg text-primary mb-2">Profesi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">work</span>
                            <input name="profession" class="w-full pl-12 pr-4 py-4 rounded-xl border border-outline-variant bg-surface focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="Mahasiswa, Karyawan, dll." type="text" value="{{ old('profession') }}">
                        </div>
                        @error('profession')
                        <p class="text-error text-label-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button class="w-full bg-primary text-on-primary py-4 rounded-xl font-label-lg text-label-lg hover:bg-primary-container transition-all shadow-lg shadow-primary/10 active:scale-95" id="submit-btn" type="submit">Masuk Sekarang</button>
                        <div class="relative my-8">
                            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-outline-variant/30"></div></div>
                            <div class="relative flex justify-center text-label-sm"><span class="px-4 bg-surface-bright text-on-surface-variant">Atau lanjut dengan</span></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="flex items-center justify-center gap-2 border border-outline-variant py-3 rounded-xl hover:bg-surface-container transition-all" type="button">
                                <img alt="Google" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDH8jYFPvLMv99OdzcGLHLVsKXJ9QzTenZp9x-5UkYqirpabhhB3MHLNlC1L2UI8ddMd9lYip1sdqGiHyIGz1SWJbfYPYHpwQtZMqQndW3qTZciIPRaQVWvCjGycIWa6KnDNzVA9ERodlkP98M0E15LKrAs-vHB7s_ToUaLCNRV7jcWDOSJhnN_tSptGPD3Q5tbddLT6zCUQdr27dF4Hr-mrSS-LP6U-CPeiS722Yfef8Wg6DQaXxxoOIsjFaowKxVT0-Cr-YdiARs">
                                <span class="text-label-lg">Google</span>
                            </button>
                            <button class="flex items-center justify-center gap-2 border border-outline-variant py-3 rounded-xl hover:bg-surface-container transition-all" type="button">
                                <img alt="Facebook" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDGxcVx6R2CpGk01N0rw6PVQlVAbf-vkhIJxA-qbWmvpubC-e2ijTDMVjTECkdPCNu9EMUf4ZHsUoJ5nb3bOE_R_W4oJtDn40eSUQZc-drNaeHnqBj_KNeSXsooPRMe7KF0kfTuUZDNIxb3D7KDTVro6QWyBtzxO1jiIf2koTIHZxezuQ26EeiyJNIL7sTyBvHh6_WaDvUi-8wLdLT77ZImIrPFkkX8W-TgiTkbKNsDgET1zYRd5kH95tTllk0ZKlKAMXtF6WIyDXA">
                                <span class="text-label-lg">Facebook</span>
                            </button>
                        </div>
                    </div>
                </form>
                
                <p class="mt-8 text-center text-on-surface-variant font-label-sm">
                    Lupa kata sandi? <a class="text-primary font-semibold hover:underline" href="{{ route('password.request') }}">Klik di sini</a>
                </p>
            </div>
        </section>
    </main>

    <footer class="bg-surface-container-highest border-t border-outline-variant/20 full-width">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-section-gap-mobile md:gap-section-gap-desktop w-full px-container-padding py-16 max-w-7xl mx-auto">
            <div class="md:col-span-1">
                <div class="font-headline-md text-headline-md font-bold text-primary tracking-tight mb-4">Kos Arcadia</div>
                <p class="text-on-surface-variant font-body-md text-body-md mb-6">Experience the pinnacle of tropical living in Lombok. Managed luxury, shared community.</p>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg text-primary mb-6">Discover</h4>
                <ul class="space-y-4">
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="{{ url('/rooms') }}">Rooms</a></li>
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="{{ url('/amenities') }}">Amenities</a></li>
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="{{ url('/location') }}">Location</a></li>
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="#">Reviews</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg text-primary mb-6">Company</h4>
                <ul class="space-y-4">
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="{{ url('/about') }}">About Us</a></li>
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="{{ url('/contact') }}">Contact</a></li>
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="#">Privacy Policy</a></li>
                    <li><a class="text-on-surface-variant hover:underline hover:text-secondary transition-all font-label-sm text-label-sm" href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-lg text-label-lg text-primary mb-6">Newsletter</h4>
                <form action="{{ url('/newsletter') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input name="email" class="bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 w-full text-label-sm focus:outline-primary" placeholder="Enter email" type="email" required>
                    <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-sm hover:opacity-90">Join</button>
                </form>
            </div>
        </div>
        <div class="border-t border-outline-variant/10 py-8 px-container-padding text-center">
            <p class="text-on-surface-variant font-label-sm text-label-sm">© {{ date('Y') }} Kos Arcadia Lombok. Luxury Managed Boarding.</p>
        </div>
    </footer>

    <script>
        const registerFields = ['field-name', 'field-phone', 'field-password-confirmation', 'field-profession'];

        function toggleAuth(mode) {
            const slider = document.getElementById('tab-slider');
            const masukBtn = document.getElementById('tab-masuk');
            const daftarBtn = document.getElementById('tab-daftar');
            const formTitle = document.getElementById('form-title');
            const formSubtitle = document.getElementById('form-subtitle');
            const submitBtn = document.getElementById('submit-btn');
            const form = document.getElementById('auth-form');

            if (mode === 'daftar') {
                slider.style.transform = 'translateX(100%)';
                masukBtn.classList.remove('text-primary', 'font-bold');
                masukBtn.classList.add('text-on-surface-variant');
                daftarBtn.classList.add('text-primary', 'font-bold');
                daftarBtn.classList.remove('text-on-surface-variant');

                registerFields.forEach(id => {
                    const el = document.getElementById(id);
                    el.classList.remove('hidden');
                    setTimeout(() => el.classList.add('opacity-100', 'translate-y-0'), 10);
                });

                formTitle.innerText = 'Daftar Akun Baru';
                formSubtitle.innerText = 'Mulai perjalanan anda bersama Kos Arcadia.';
                submitBtn.innerText = 'Daftar Sekarang';
                form.action = "{{ url('/register') }}";

            } else {
                slider.style.transform = 'translateX(0)';
                daftarBtn.classList.remove('text-primary', 'font-bold');
                daftarBtn.classList.add('text-on-surface-variant');
                masukBtn.classList.add('text-primary', 'font-bold');
                masukBtn.classList.remove('text-on-surface-variant');

                registerFields.forEach(id => {
                    const el = document.getElementById(id);
                    el.classList.remove('opacity-100', 'translate-y-0');
                    setTimeout(() => el.classList.add('hidden'), 300);
                });

                formTitle.innerText = 'Selamat Datang';
                formSubtitle.innerText = 'Masuk untuk mengelola reservasi anda.';
                submitBtn.innerText = 'Masuk Sekarang';
                form.action = "{{ url('/login') }}";
            }
        }

        // Initialize to register tab if user came from /register
        if (window.__authMode === 'register') {
            toggleAuth('daftar');
        }
    </script>
</body>
</html>
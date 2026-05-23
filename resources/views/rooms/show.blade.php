<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room->room_number }} - Kos Arcadia Lombok</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col">

    <!-- Header Navbar -->
    <nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200/50 dark:border-slate-800/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20 text-white font-bold text-xl">
                        A
                    </a>
                    <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent dark:from-emerald-400 dark:to-teal-300">
                        Kos Arcadia
                    </a>
                </div>
                
                <div class="flex items-center gap-6">
                    <a href="{{ route('rooms.index') }}" class="font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400">Kembali ke Daftar Kamar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Room Detail Main Content -->
    <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Back Link and Notifications -->
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 dark:bg-red-950/20 dark:border-red-900 text-red-800 dark:text-red-300 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Room Image Gallery Section -->
            <div class="space-y-6">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-250/20 dark:border-slate-800/50 aspect-square">
                    <img src="{{ asset($room->image_path) }}" alt="{{ $room->room_number }}" class="w-full h-full object-cover">
                </div>
                <!-- Small thumbnail mockups -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="rounded-2xl overflow-hidden border-2 border-emerald-500 aspect-video cursor-pointer">
                        <img src="{{ asset('images/room_interior.png') }}" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 opacity-60 hover:opacity-100 transition-opacity aspect-video cursor-pointer">
                        <img src="{{ asset('images/shared_kitchen.png') }}" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 opacity-60 hover:opacity-100 transition-opacity aspect-video cursor-pointer">
                        <img src="{{ asset('images/kos_exterior.png') }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Room Description and Booking Form -->
            <div class="flex flex-col justify-between space-y-8">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h1 class="text-4xl font-extrabold tracking-tight">{{ $room->room_number }}</h1>
                        @if($room->status === 'available')
                            <span class="px-4 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 font-bold text-sm">
                                Tersedia
                            </span>
                        @else
                            <span class="px-4 py-1.5 rounded-full bg-red-100 dark:bg-red-950/50 text-red-700 dark:text-red-400 font-bold text-sm">
                                Penuh
                            </span>
                        @endif
                    </div>

                    <div class="p-6 bg-slate-100 dark:bg-slate-950 border border-slate-200/50 dark:border-slate-800/50 rounded-3xl">
                        <span class="text-xs text-slate-450 dark:text-slate-500 uppercase tracking-wider font-bold block mb-1">Harga Sewa Bulanan</span>
                        <span class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($room->price_per_month, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500">/ bulan</span></span>
                    </div>

                    <div class="space-y-3">
                        <h3 class="font-bold text-lg">Deskripsi Kamar</h3>
                        <p class="text-slate-650 dark:text-slate-400 leading-relaxed text-sm">
                            {{ $room->description }}
                        </p>
                    </div>

                    <!-- Room Facilities Grid -->
                    <div class="space-y-3">
                        <h3 class="font-bold text-lg">Fasilitas Kamar Mandiri</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold">✓</span> <span>Kasur Queen/Single Size</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold">✓</span> <span>Meja & Kursi Belajar</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold">✓</span> <span>Lemari Pakaian Pribadi</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold">✓</span> <span>Pendingin Ruangan (AC)</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold">✓</span> <span>Kamar Mandi Dalam</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold">✓</span> <span>Water Heater</span>
                            </div>
                        </div>
                    </div>

                    <!-- Shared/General Facilities -->
                    <div class="space-y-3">
                        <h3 class="font-bold text-lg">Fasilitas Umum (Bersama)</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <div class="flex items-center gap-2">👨‍🍳 <span>Dapur bersama lengkap</span></div>
                            <div class="flex items-center gap-2">🚗 <span>Lahan parkir kendaraan luas</span></div>
                            <div class="flex items-center gap-2">📶 <span>WiFi broadband gratis</span></div>
                            <div class="flex items-center gap-2">📹 <span>Pengawasan CCTV 24 Jam</span></div>
                            <div class="flex items-center gap-2">💂 <span>Penjaga Keamanan/Satpam</span></div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-6 border-t border-slate-200 dark:border-slate-800">
                    @if($room->status === 'available')
                        <a href="{{ route('bookings.create', $room->id) }}" class="w-full text-center block px-8 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/35 transition-all text-base">
                            Booking Sekarang
                        </a>
                    @else
                        <button disabled class="w-full text-center block px-8 py-4 bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-600 font-bold rounded-2xl cursor-not-allowed">
                            Kamar Sudah Terisi (Penuh)
                        </button>
                    @endif
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800 text-center text-xs mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            © 2026 Kos Arcadia. Hak Cipta Dilindungi. Built with Laravel & Tailwind CSS.
        </div>
    </footer>
</body>
</html>
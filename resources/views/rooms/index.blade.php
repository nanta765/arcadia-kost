<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kamar - Kos Arcadia Lombok</title>
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
                    <a href="{{ route('home') }}" class="font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400">Kembali ke Home</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold transition-all shadow-md shadow-emerald-500/10 hover:shadow-lg text-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 text-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold transition-all shadow-md shadow-emerald-500/10 text-sm">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="space-y-8">
            <!-- Header Text -->
            <div class="space-y-3">
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Daftar Seluruh Kamar</h1>
                <p class="text-slate-500 dark:text-slate-400 max-w-2xl">Jelajahi dan pilih kamar kos impian Anda di Kos Arcadia Lombok. Tersedia 18 kamar dengan fasilitas lengkap.</p>
            </div>

            <!-- Filter Panel -->
            <form action="{{ route('rooms.index') }}" method="GET" class="p-6 bg-white dark:bg-slate-900 border border-slate-200/50 dark:border-slate-800/50 rounded-3xl flex flex-wrap items-center justify-between gap-6 shadow-sm">
                <div class="flex flex-wrap gap-4 items-center">
                    <!-- Status Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label for="status" class="text-xs uppercase tracking-wider font-bold text-slate-450 dark:text-slate-500">Status</label>
                        <select name="status" id="status" class="rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 text-sm focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-4 min-w-[150px]">
                            <option value="">Semua Status</option>
                            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="occupied" {{ request('status') === 'occupied' ? 'selected' : '' }}>Penuh</option>
                        </select>
                    </div>

                    <!-- Price Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label for="price" class="text-xs uppercase tracking-wider font-bold text-slate-450 dark:text-slate-500">Harga Kamar</label>
                        <select name="price" id="price" class="rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 text-sm focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-4 min-w-[170px]">
                            <option value="">Semua Harga</option>
                            <option value="low" {{ request('price') === 'low' ? 'selected' : '' }}>Standard (< Rp 1.6jt)</option>
                            <option value="high" {{ request('price') === 'high' ? 'selected' : '' }}>Premium (>= Rp 1.6jt)</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-350 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 font-semibold text-sm transition-colors text-center">
                        Reset Filter
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl text-sm transition-colors shadow-md shadow-emerald-500/10">
                        Terapkan Filter
                    </button>
                </div>
            </form>

            <!-- Room Grid -->
            @if($rooms->isEmpty())
                <div class="py-20 text-center space-y-4">
                    <span class="text-5xl block">🛏️</span>
                    <h3 class="text-xl font-bold">Kamar Tidak Ditemukan</h3>
                    <p class="text-slate-500 dark:text-slate-400">Tidak ada kamar yang memenuhi kriteria filter Anda saat ini.</p>
                </div>
            @else
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($rooms as $room)
                        <div class="rounded-3xl overflow-hidden border border-slate-200/50 dark:border-slate-800/50 bg-white dark:bg-slate-900 shadow-md hover:shadow-xl transition-all flex flex-col group">
                            <div class="relative overflow-hidden aspect-[4/3]">
                                <img src="{{ asset($room->image_path) }}" alt="{{ $room->room_number }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 right-4">
                                    @if($room->status === 'available')
                                        <span class="px-3 py-1 rounded-full bg-emerald-500 text-white font-bold text-xs shadow-md">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-red-500 text-white font-bold text-xs shadow-md">
                                            Penuh
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-6 flex-grow flex flex-col justify-between space-y-6">
                                <div>
                                    <h3 class="text-2xl font-bold tracking-tight mb-2">{{ $room->room_number }}</h3>
                                    <p class="text-sm text-slate-500 line-clamp-3">{{ $room->description }}</p>
                                    
                                    <div class="flex flex-wrap gap-2 mt-4 text-xs text-slate-600 dark:text-slate-400">
                                        <span class="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">Kasur</span>
                                        <span class="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">AC</span>
                                        <span class="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">Toilet Dalam</span>
                                        <span class="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">Water Heater</span>
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                    <div>
                                        <span class="text-xs text-slate-400 block">Harga / Bulan</span>
                                        <span class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($room->price_per_month, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('rooms.show', $room->id) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm font-semibold transition-colors">
                                            Detail
                                        </a>
                                        @if($room->status === 'available')
                                            <a href="{{ route('bookings.create', $room->id) }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold transition-colors">
                                                Booking
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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
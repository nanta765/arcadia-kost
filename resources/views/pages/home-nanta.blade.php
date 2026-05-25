<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Kos Arcadia - Boarding house eksklusif dan modern dengan fasilitas terlengkap di Lombok, Indonesia.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user-id" content="{{ auth()->user()->id ?? '' }}">
  <title>Dashboard — Kos Arcadia</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  @filamentStyles
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #ffffff;
    }
  </style>
</head>

<body class="text-slate-800 antialiased">

  <!-- Header Navbar -->
  <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="flex justify-between h-20 items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
          <span class="font-extrabold text-2xl tracking-tight text-slate-900 flex items-center gap-2">
            <span class="w-10 h-10 rounded-xl bg-arcadia flex items-center justify-center text-white font-extrabold text-xl shadow-md">AR</span>
            <span class="font-bold text-xl text-slate-800">Kos Arcadia</span>
          </span>
        </a>

        <div class="hidden md:flex items-center gap-10">
          <a href="#home" class="font-bold text-xs uppercase tracking-widest text-slate-800 hover:text-arcadia transition-colors">Dashboard</a>
          <a href="#rooms" class="font-bold text-xs uppercase tracking-widest text-slate-400 hover:text-arcadia transition-colors">Rooms</a>
          <a href="#facilities" class="font-bold text-xs uppercase tracking-widest text-slate-400 hover:text-arcadia transition-colors">Amenities</a>
          <a href="#location" class="font-bold text-xs uppercase tracking-widest text-slate-400 hover:text-arcadia transition-colors">Location</a>
        </div>

        <div class="hidden md:flex items-center gap-4">
          <a href="{{ route('my-bookings') }}"
            class="font-bold text-xs uppercase tracking-widest text-slate-500 hover:text-arcadia">
            My Bookings
          </a>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit"
              class="px-6 py-3 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold text-xs uppercase tracking-widest transition-all">
              Logout
            </button>
          </form>
        </div>

        <div class="flex items-center md:hidden">
          <button id="mobile-menu-btn" class="p-2 rounded-lg text-slate-655 hover:bg-slate-50">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 px-6 py-6 space-y-4">
      <a href="#home" class="block font-bold text-xs uppercase tracking-widest text-slate-800">Dashboard</a>
      <a href="#rooms" class="block font-bold text-xs uppercase tracking-widest text-slate-400">Rooms</a>
      <a href="#facilities" class="block font-bold text-xs uppercase tracking-widest text-slate-400">Amenities</a>
      <a href="#location" class="block font-bold text-xs uppercase tracking-widest text-slate-400">Location</a>
      <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
        <a href="{{ route('my-bookings') }}"
          class="w-full text-center py-3 font-bold text-xs uppercase tracking-widest text-slate-600">
          My Bookings
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
            class="w-full text-center px-4 py-3 rounded-lg border border-slate-200 text-slate-600 font-bold text-xs uppercase tracking-widest">
            Logout
          </button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Session Alerts -->
  @if(session('success'))
    <div class="max-w-7xl mx-auto px-6 mt-6">
      <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
      </div>
    </div>
  @endif
  @if(session('error'))
    <div class="max-w-7xl mx-auto px-6 mt-6">
      <div class="p-4 bg-red-50 border border-red-100 text-red-800 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('error') }}</span>
      </div>
    </div>
  @endif

  <!-- Hero Section -->
  <section id="home" class="relative h-[650px] bg-slate-900">
    <div class="absolute inset-0">
      <img src="{{ asset('images/kos_exterior.png') }}" alt="Kos Arcadia Exterior"
        class="w-full h-full object-cover opacity-80">
      <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 to-slate-950/50"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 h-full flex items-center relative z-10">
      <div class="max-w-2xl space-y-6">
        <span class="inline-block px-3 py-1 rounded bg-[#a7f3cf]/25 text-[#a7f3cf] font-bold text-[10px] uppercase tracking-wider">
          Selamat datang, {{ auth()->user()->name }}
        </span>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight">
          Temukan Kamar<br>Impian Anda
        </h1>

        <p class="text-slate-300 text-sm leading-relaxed max-w-lg">
          Pilih tipe kamar yang sesuai dengan kebutuhan Anda. Semua kamar dilengkapi fasilitas modern dan lingkungan yang aman.
        </p>

        <!-- Live Stats -->
        <div class="flex gap-8 pt-4">
          <div class="text-white">
            <span class="block text-3xl font-extrabold">{{ $availableRooms }}</span>
            <span class="text-xs text-slate-400">Kamar Tersedia</span>
          </div>
          <div class="text-white">
            <span class="block text-3xl font-extrabold text-[#C9A252]">
              {{ $averageRating > 0 ? '★ ' . $averageRating : '—' }}
            </span>
            <span class="text-xs text-slate-400">Rating ({{ $totalReviews }} ulasan)</span>
          </div>
        </div>

        <div class="flex flex-wrap gap-4 pt-4">
          <a href="#rooms"
            class="px-8 py-4 bg-white hover:bg-slate-100 text-arcadia font-bold rounded-lg text-xs uppercase tracking-widest shadow-lg transition-all">
            Lihat Katalog Kamar
          </a>
          <a href="{{ route('my-bookings') }}"
            class="px-8 py-4 border-2 border-white/60 hover:bg-white/10 text-white font-bold rounded-lg text-xs uppercase tracking-widest transition-all">
            Riwayat Booking
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Room Types Section — Dynamic from Model -->
  <section id="rooms" class="py-24 bg-[#f8f9fa]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="text-center space-y-3 mb-16">
        <span class="text-[10px] uppercase tracking-widest font-extrabold text-slate-400 block">Katalog Kamar</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
          {{ $roomTypes->count() }} Tipe Kamar Tersedia
        </h2>
      </div>

      @foreach($roomTypes as $type)
      <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-md grid md:grid-cols-2 {{ !$loop->last ? 'mb-10' : '' }}">
        <!-- Left: image -->
        <div class="relative overflow-hidden min-h-[350px]">
          @if($type->image)
            <img src="{{ asset('storage/' . $type->image) }}" alt="{{ $type->name }}"
              class="absolute inset-0 w-full h-full object-cover">
          @else
            <div class="absolute inset-0 w-full h-full bg-slate-200 flex items-center justify-center">
              <span class="text-slate-400 text-sm">No Image</span>
            </div>
          @endif
          <div class="absolute top-6 left-6">
            <span class="px-4 py-2 bg-arcadia text-white font-bold text-xs uppercase tracking-wider rounded-lg shadow-md">
              Rp {{ number_format($type->price, 0, ',', '.') }} / bln
            </span>
          </div>
          @php $availableCount = $type->rooms->where('status', 'available')->count(); @endphp
          <div class="absolute top-6 right-6">
            <span class="px-4 py-2 {{ $availableCount > 0 ? 'bg-emerald-500' : 'bg-red-500' }} text-white font-bold text-xs uppercase tracking-wider rounded-lg shadow-md">
              {{ $availableCount > 0 ? $availableCount . ' Tersedia' : 'Penuh' }}
            </span>
          </div>
        </div>

        <!-- Right: info -->
        <div class="p-8 sm:p-12 flex flex-col justify-between space-y-8">
          <div class="space-y-6">
            <div class="flex items-center">
              <span class="px-3 py-1 rounded bg-[#a7f3cf]/30 text-arcadia font-bold text-[9px] uppercase tracking-wider">
                {{ $availableCount > 0 ? 'Tersedia untuk dibooking' : 'Saat ini penuh' }}
              </span>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $type->name }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">
              {{ $type->description ?: 'Kamar nyaman dengan fasilitas lengkap. Cocok untuk mahasiswa maupun pekerja profesional di Mataram.' }}
            </p>

            <div class="flex gap-8 pt-4 border-t border-slate-100">
              <div class="flex items-center gap-3">
                <span class="text-2xl">🛏️</span>
                <div class="text-xs">
                  <span class="text-slate-400 block">KAMAR</span>
                  <span class="font-bold text-slate-800">{{ $type->rooms->count() }} Unit</span>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <span class="text-2xl">💰</span>
                <div class="text-xs">
                  <span class="text-slate-400 block">SEWA</span>
                  <span class="font-bold text-slate-800">Rp {{ number_format($type->price, 0, ',', '.') }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="pt-6 border-t border-slate-100">
            @if($availableCount > 0)
              <a href="{{ route('booking.create', $type) }}"
                class="w-full text-center py-4 bg-arcadia hover:bg-arcadia-hover text-white font-bold rounded-lg text-xs uppercase tracking-widest transition-colors shadow-lg block">
                Booking Sekarang
              </a>
            @else
              <button disabled
                class="w-full text-center py-4 bg-slate-300 text-slate-500 font-bold rounded-lg text-xs uppercase tracking-widest cursor-not-allowed block">
                Sedang Penuh
              </button>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- World Class Facilities Section -->
  <section id="facilities" class="py-24 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-8 items-end mb-16">
        <div class="space-y-3">
          <span class="text-[10px] uppercase tracking-widest font-extrabold text-slate-400 block">World-Class Facilities</span>
          <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
            Fasilitas Modern untuk<br>Gaya Hidup Tanpa Batas
          </h2>
        </div>
        <div>
          <p class="text-slate-500 text-sm leading-relaxed max-w-md md:ml-auto">
            Setiap detail dirancang untuk kenyamanan Anda, mulai dari koneksi internet super cepat hingga keamanan 24 jam.
          </p>
        </div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @php
        $facilities = [
          ['icon' => 'ac', 'title' => 'Air Conditioner', 'desc' => 'Pendingin ruangan pribadi.'],
          ['icon' => 'wifi', 'title' => 'High Speed WiFi', 'desc' => 'Fiber up to 100Mbps.'],
          ['icon' => 'water', 'title' => 'Water Heater', 'desc' => 'Tersedia setiap saat.'],
          ['icon' => 'guard', 'title' => 'Security Guard', 'desc' => 'Keamanan terjamin 24/7.'],
        ];
        @endphp
        @foreach($facilities as $f)
        <div class="p-8 rounded-3xl bg-[#f8f9fa] border border-slate-100 flex flex-col items-start space-y-6 shadow-sm">
          <div class="w-12 h-12 rounded-xl bg-emerald-50 text-arcadia flex items-center justify-center shadow-sm">
            @if($f['icon'] === 'ac')
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.26a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
              </svg>
            @elseif($f['icon'] === 'wifi')
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10.5 10.5 0 0114.14 0M1.414 6.586a17 17 0 0121.172 0" />
              </svg>
            @elseif($f['icon'] === 'water')
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            @else
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            @endif
          </div>
          <div class="space-y-1">
            <h3 class="font-bold text-base text-slate-800">{{ $f['title'] }}</h3>
            <p class="text-xs text-slate-400">{{ $f['desc'] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Gallery Section — using RoomType images -->
  @if($roomTypes->whereNotNull('image')->isNotEmpty())
  <section id="gallery" class="py-24 bg-[#f8f9fa] border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="text-center space-y-3 mb-16">
        <span class="text-[10px] uppercase tracking-widest font-extrabold text-slate-400 block">Photo Gallery</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
          Sudut Keindahan Arcadia
        </h2>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($roomTypes as $type)
          @if($type->image)
          <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white group shadow-sm hover:shadow-md transition-all relative aspect-square">
            <img src="{{ asset('storage/' . $type->image) }}" alt="{{ $type->name }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
              <div>
                <span class="text-[8px] uppercase font-bold text-[#a7f3cf] tracking-wider block mb-1">
                  Rp {{ number_format($type->price, 0, ',', '.') }}/bln
                </span>
                <p class="text-white text-xs font-semibold leading-snug">{{ $type->name }}</p>
              </div>
            </div>
          </div>
          @endif
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- Location Section -->
  <section id="location" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-16 items-center">
        <div class="space-y-8">
          <div class="space-y-3">
            <span class="text-[10px] uppercase tracking-widest font-extrabold text-slate-400 block">Perfectly Positioned</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
              Lokasi Paling Strategis<br>di Mataram
            </h2>
          </div>

          <div class="space-y-6">
            <div class="flex items-start gap-4">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-arcadia shrink-0 font-bold">🏢</div>
              <div class="space-y-1">
                <h4 class="font-extrabold text-slate-800 text-sm">Pusat Kota Mataram</h4>
                <p class="text-xs text-slate-500">Hanya 5 menit ke kawasan bisnis dan pusat perbelanjaan terbesar.</p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-arcadia shrink-0 font-bold">🍴</div>
              <div class="space-y-1">
                <h4 class="font-extrabold text-slate-800 text-sm">Destinasi Kuliner</h4>
                <p class="text-xs text-slate-500">Dikelilingi oleh berbagai kafe dan restoran trendi favorit.</p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-arcadia shrink-0 font-bold">✈️</div>
              <div class="space-y-1">
                <h4 class="font-extrabold text-slate-800 text-sm">Akses Transportasi</h4>
                <p class="text-xs text-slate-500">30 menit berkendara menuju Bandara Internasional Lombok.</p>
              </div>
            </div>
          </div>

          <div class="pt-4 border-t border-slate-100">
            <a href="https://maps.google.com" target="_blank"
              class="inline-flex items-center gap-2 font-bold text-xs uppercase tracking-widest text-arcadia hover:underline">
              Petunjuk Lokasi Google Maps →
            </a>
          </div>
        </div>

        <div class="relative">
          <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-emerald-500/25 to-arcadia/25 opacity-20 blur-lg"></div>
          <div class="relative rounded-3xl overflow-hidden border border-slate-200 aspect-[4/3] shadow-xl">
            <img src="{{ asset('images/location_map.png') }}" alt="Location Map" class="w-full h-full object-cover">
            <div class="absolute bottom-6 left-6 right-6 p-5 bg-white/90 backdrop-blur-md border border-slate-100 rounded-2xl shadow-lg space-y-1">
              <span class="text-[9px] uppercase tracking-wider font-extrabold text-slate-400 block">Alamat Kami</span>
              <span class="font-bold text-xs text-slate-800 block">Jl. Arcadia Residence No. 18</span>
              <span class="text-[10px] text-slate-500 block">Mataram, Nusa Tenggara Barat</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="bg-arcadia py-24 text-white text-center relative overflow-hidden">
    <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl"></div>
    <div class="absolute -left-20 -top-20 w-80 h-80 rounded-full bg-[#a7f3cf]/10 blur-3xl"></div>

    <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10 space-y-8">
      <h2 class="text-4xl font-extrabold tracking-tight">Jadikan Kamar Ini Milik Anda</h2>
      <p class="text-slate-200 text-sm max-w-xl mx-auto leading-relaxed">
        Unit terbatas hanya untuk {{ $availableRooms }} kamar tersedia. Jangan lewatkan kesempatan memiliki hunian premium dengan standar resort di Lombok.
      </p>
      <div class="flex flex-wrap justify-center gap-4 pt-4">
        <a href="#rooms"
          class="px-8 py-4 bg-white hover:bg-slate-100 text-arcadia font-bold rounded-lg text-xs uppercase tracking-widest transition-all">
          Lihat Katalog Kamar
        </a>
        <a href="https://wa.me/6281234567890" target="_blank"
          class="px-8 py-4 border-2 border-white/60 hover:bg-white/10 text-white font-bold rounded-lg text-xs uppercase tracking-widest flex items-center gap-2 transition-all">
          💬 Whatsapp Admin
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[#f8f9fa] border-t border-slate-100 pt-16 pb-8 text-slate-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-12 mb-16">
        <div class="space-y-4 col-span-2 md:col-span-1">
          <span class="text-2xl font-bold tracking-tight text-slate-800 block">Kos Arcadia</span>
          <p class="text-xs text-slate-400 leading-relaxed">
            Pelopor hunian eksklusif terpadu di Lombok. Memadukan kenyamanan kos modern bagi profesional muda dan pelajar.
          </p>
          <div class="flex gap-3">
            <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-xs cursor-pointer hover:bg-arcadia hover:text-white transition-colors">FB</span>
            <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-xs cursor-pointer hover:bg-arcadia hover:text-white transition-colors">IG</span>
          </div>
        </div>

        <div class="space-y-4">
          <h4 class="text-slate-800 font-extrabold text-xs uppercase tracking-widest">Navigasi</h4>
          <ul class="space-y-2 text-xs">
            <li><a href="#home" class="hover:text-arcadia">Dashboard</a></li>
            <li><a href="#rooms" class="hover:text-arcadia">Pilihan Kamar</a></li>
            <li><a href="#facilities" class="hover:text-arcadia">Fasilitas</a></li>
            <li><a href="#location" class="hover:text-arcadia">Lokasi</a></li>
          </ul>
        </div>

        <div class="space-y-4">
          <h4 class="text-slate-800 font-extrabold text-xs uppercase tracking-widest">Menu</h4>
          <ul class="space-y-2 text-xs">
            <li><a href="{{ route('my-bookings') }}" class="hover:text-arcadia">My Bookings</a></li>
            <li><a href="#" class="hover:text-arcadia">Panduan (FAQ)</a></li>
            <li><a href="#" class="hover:text-arcadia">Kebijakan Privasi</a></li>
            <li><a href="#" class="hover:text-arcadia">Syarat & Ketentuan</a></li>
          </ul>
        </div>

        <div class="space-y-4">
          <h4 class="text-slate-800 font-extrabold text-xs uppercase tracking-widest">Hubungi Kami</h4>
          <ul class="space-y-2 text-xs">
            <li class="flex items-center gap-2">📍 <span>Mataram, Lombok, NTB</span></li>
            <li class="flex items-center gap-2">📞 <span>+62 812-3456-7890</span></li>
            <li class="flex items-center gap-2">✉️ <span>hello@kosarcadia.com</span></li>
          </ul>
        </div>
      </div>

      <div class="pt-8 border-t border-slate-100 text-center text-[10px] text-slate-400">
        © {{ date('Y') }} Kos Arcadia Lombok. Hak Cipta Dilindungi. All Rights Reserved.
      </div>
    </div>
  </footer>

  <!-- Chat Widget -->
  <x-chat-widget />

  @livewireScripts
  @filamentScripts

  <script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn && menu) {
      btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
      });
    }
  </script>
</body>
</html>

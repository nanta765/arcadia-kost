@extends('layouts.app')

@section('content')

{{-- HERO --}}
<section class="relative min-h-screen flex items-center overflow-hidden">

    <div class="absolute inset-0">

        <img
            src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1600"
            class="w-full h-full object-cover"
        >

        <div class="absolute inset-0 bg-black/60"></div>

    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-24 w-full">

        <div class="max-w-3xl">

            <p class="uppercase tracking-[0.3em] text-white/70 mb-6">
                Modern Tropical Boutique Residence
            </p>

            <h1 class="text-5xl md:text-7xl text-white font-display leading-tight mb-8">
                Tinggal Lebih Nyaman
                di Tengah Hangatnya Lombok
            </h1>

            <p class="text-white/80 text-lg leading-relaxed mb-10 max-w-2xl">
                Kost Arca menghadirkan hunian modern tropical
                dengan fasilitas lengkap, desain elegan,
                dan suasana tenang untuk mahasiswa,
                pekerja, maupun digital nomad.
            </p>

            <div class="flex flex-wrap gap-4">

                <a href="/rooms"
                   class="bg-primary text-white px-8 py-4 rounded-full hover:opacity-90 transition">

                    Lihat Kamar

                </a>

                <a href="https://wa.me/628123456789"
                   class="bg-white text-dark px-8 py-4 rounded-full hover:bg-cream transition">

                    Tanya via WhatsApp

                </a>

            </div>

        </div>

    </div>

</section>

{{-- STATS --}}
<section class="py-12 bg-dark text-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-10 text-center">

            <div>
                <h3 class="text-4xl font-bold mb-2">50+</h3>
                <p class="text-white/70">Penghuni Aktif</p>
            </div>

            <div>
                <h3 class="text-4xl font-bold mb-2">24/7</h3>
                <p class="text-white/70">Keamanan CCTV</p>
            </div>

            <div>
                <h3 class="text-4xl font-bold mb-2">100 Mbps</h3>
                <p class="text-white/70">Internet Cepat</p>
            </div>

            <div>
                <h3 class="text-4xl font-bold mb-2">4.9★</h3>
                <p class="text-white/70">Rating Penghuni</p>
            </div>

        </div>

    </div>

</section>

{{-- ABOUT --}}
<section class="py-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-16 items-center">

            <div>

                <p class="uppercase tracking-[0.2em] text-primary mb-4">
                    Tentang Kost Arca
                </p>

                <h2 class="text-4xl md:text-5xl font-display text-primary mb-8 leading-tight">
                    Hunian Modern
                    dengan Sentuhan
                    Lokal Lombok
                </h2>

                <p class="text-gray-600 leading-relaxed mb-6">
                    Kost Arca dirancang untuk menghadirkan
                    pengalaman tinggal yang lebih nyaman,
                    tenang, dan modern dengan nuansa tropical.
                </p>

                <p class="text-gray-600 leading-relaxed mb-8">
                    Menggabungkan interior modern,
                    pencahayaan alami, dan sentuhan hangat lokal,
                    Kost Arca cocok untuk Anda yang mencari
                    tempat tinggal berkualitas di Lombok.
                </p>

                <a href="/about"
                   class="inline-block bg-dark text-white px-6 py-3 rounded-full">

                    Pelajari Lebih Lanjut

                </a>

            </div>

            <div>

                <img
                    src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1200"
                    class="rounded-[40px] shadow-2xl"
                >

            </div>

        </div>

    </div>

</section>

{{-- ROOM --}}
<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-end mb-14">

            <div>

                <p class="uppercase tracking-[0.2em] text-primary mb-3">
                    Pilihan Kamar
                </p>

                <h2 class="text-4xl md:text-5xl font-display text-primary">
                    Tipe Kamar
                </h2>

            </div>

            <a href="/rooms" class="hidden md:block text-primary">
                Lihat Semua →
            </a>

        </div>

        <div class="grid md:grid-cols-2 gap-10">

            {{-- CARD --}}
            <div class="bg-cream rounded-[32px] overflow-hidden">

                <img
                    src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1200"
                    class="h-[320px] w-full object-cover"
                >

                <div class="p-8">

                    <div class="flex justify-between items-center mb-4">

                        <h3 class="text-3xl font-display">
                            Superior Room
                        </h3>

                        <span class="text-primary font-semibold">
                            Rp 2.5jt
                        </span>

                    </div>

                    <ul class="space-y-3 text-gray-600 mb-8">

                        <li>✔ Queen Size Bed</li>
                        <li>✔ AC & Smart TV</li>
                        <li>✔ Kamar mandi dalam</li>
                        <li>✔ WiFi High-Speed</li>

                    </ul>

                    <a href="/rooms"
                       class="inline-block bg-dark text-white px-6 py-3 rounded-full">

                        Detail Kamar

                    </a>

                </div>

            </div>

            {{-- CARD --}}
            <div class="bg-cream rounded-[32px] overflow-hidden">

                <img
                    src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1200"
                    class="h-[320px] w-full object-cover"
                >

                <div class="p-8">

                    <div class="flex justify-between items-center mb-4">

                        <h3 class="text-3xl font-display">
                            Exclusive Room
                        </h3>

                        <span class="text-primary font-semibold">
                            Rp 3.5jt
                        </span>

                    </div>

                    <ul class="space-y-3 text-gray-600 mb-8">

                        <li>✔ King Size Bed</li>
                        <li>✔ Balkon pribadi</li>
                        <li>✔ Mini Fridge</li>
                        <li>✔ Smart Lock Access</li>

                    </ul>

                    <a href="/rooms"
                       class="inline-block bg-dark text-white px-6 py-3 rounded-full">

                        Detail Kamar

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- FACILITIES --}}
<section class="py-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">

            <p class="uppercase tracking-[0.2em] text-primary mb-4">
                Fasilitas
            </p>

            <h2 class="text-4xl md:text-5xl font-display text-primary">
                Fasilitas Bersama
            </h2>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            <div class="bg-white p-8 rounded-[32px] text-center shadow-sm">
                <div class="text-5xl mb-5">🍳</div>
                <h3 class="font-semibold">Dapur Bersama</h3>
            </div>

            <div class="bg-white p-8 rounded-[32px] text-center shadow-sm">
                <div class="text-5xl mb-5">🛵</div>
                <h3 class="font-semibold">Parkiran Luas</h3>
            </div>

            <div class="bg-white p-8 rounded-[32px] text-center shadow-sm">
                <div class="text-5xl mb-5">🧺</div>
                <h3 class="font-semibold">Laundry Area</h3>
            </div>

            <div class="bg-white p-8 rounded-[32px] text-center shadow-sm">
                <div class="text-5xl mb-5">🌐</div>
                <h3 class="font-semibold">WiFi Area</h3>
            </div>

        </div>

    </div>

</section>

{{-- LOCATION --}}
<section class="py-24 bg-dark text-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-16 items-center">

            <div>

                <p class="uppercase tracking-[0.2em] text-white/60 mb-4">
                    Lokasi Strategis
                </p>

                <h2 class="text-5xl font-display mb-8">
                    Dekat dengan
                    Berbagai
                    Akses Penting
                </h2>

                <div class="space-y-6">

                    <div>
                        <h4 class="text-xl mb-2">
                            📍 5 Menit ke Minimarket
                        </h4>

                        <p class="text-white/70">
                            Mudah untuk kebutuhan sehari-hari.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-xl mb-2">
                            📍 Dekat Kampus & Perkantoran
                        </h4>

                        <p class="text-white/70">
                            Cocok untuk mahasiswa dan pekerja.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-xl mb-2">
                            📍 Akses Wisata Lombok
                        </h4>

                        <p class="text-white/70">
                            Dekat pantai dan area wisata populer.
                        </p>
                    </div>

                </div>

            </div>

            <div>

                <img
                    src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?q=80&w=1200"
                    class="rounded-[40px]"
                >

            </div>

        </div>

    </div>

</section>

{{-- TESTIMONI --}}
<section class="py-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">

            <p class="uppercase tracking-[0.2em] text-primary mb-4">
                Testimoni
            </p>

            <h2 class="text-4xl md:text-5xl font-display text-primary">
                Apa Kata Penghuni?
            </h2>

        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="bg-white p-8 rounded-[32px] shadow-sm">

                <p class="text-gray-600 leading-relaxed mb-6">
                    “Tempatnya nyaman banget,
                    bersih, dan internetnya cepat.”
                </p>

                <h4 class="font-semibold">
                    Alvin — Mahasiswa
                </h4>

            </div>

            <div class="bg-white p-8 rounded-[32px] shadow-sm">

                <p class="text-gray-600 leading-relaxed mb-6">
                    “Nuansa tropical-nya bikin betah
                    buat kerja remote.”
                </p>

                <h4 class="font-semibold">
                    Naufal — Freelancer
                </h4>

            </div>

            <div class="bg-white p-8 rounded-[32px] shadow-sm">

                <p class="text-gray-600 leading-relaxed mb-6">
                    “Lokasinya strategis dan aman.”
                </p>

                <h4 class="font-semibold">
                    Dinda — Karyawan
                </h4>

            </div>

        </div>

    </div>

</section>

{{-- FAQ --}}
<section class="py-24 bg-white">

    <div class="max-w-4xl mx-auto px-6">

        <div class="text-center mb-16">

            <h2 class="text-4xl md:text-5xl font-display text-primary">
                Frequently Asked Questions
            </h2>

        </div>

        <div class="space-y-6">

            <div class="bg-cream p-8 rounded-[32px]">
                <h3 class="text-xl font-semibold mb-3">
                    Apakah listrik sudah termasuk?
                </h3>

                <p class="text-gray-600">
                    Belum termasuk, menggunakan token listrik pribadi.
                </p>
            </div>

            <div class="bg-cream p-8 rounded-[32px]">
                <h3 class="text-xl font-semibold mb-3">
                    Apakah bisa booking online?
                </h3>

                <p class="text-gray-600">
                    Bisa melalui WhatsApp admin Kost Arca.
                </p>
            </div>

            <div class="bg-cream p-8 rounded-[32px]">
                <h3 class="text-xl font-semibold mb-3">
                    Apakah ada parkiran?
                </h3>

                <p class="text-gray-600">
                    Tersedia area parkir motor dan mobil.
                </p>
            </div>

        </div>

    </div>

</section>

{{-- CTA --}}
<section class="py-24 bg-primary text-white">

    <div class="max-w-5xl mx-auto px-6 text-center">

        <h2 class="text-5xl font-display mb-6">
            Cari Hunian Nyaman di Lombok?
        </h2>

        <p class="text-white/80 text-lg mb-10">
            Hubungi kami sekarang dan cek ketersediaan kamar terbaru.
        </p>

        <a href="https://wa.me/628123456789"
           class="bg-white text-dark px-8 py-4 rounded-full inline-block">

            Hubungi via WhatsApp

        </a>

    </div>

</section>

@endsection
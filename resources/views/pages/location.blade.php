{{-- resources/views/pages/location.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="pt-40 pb-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-16">

            <h1 class="text-5xl font-display text-primary mb-6">
                Lokasi Kost Arca
            </h1>

            <p class="text-gray-600 max-w-2xl">
                Lokasi strategis dekat kampus,
                pusat kota, dan area wisata Lombok.
            </p>

        </div>

        <div class="grid md:grid-cols-2 gap-12">

            <div>

                <div class="space-y-8">

                    <div class="bg-white p-8 rounded-[32px] shadow-sm">

                        <h3 class="text-2xl font-semibold mb-3">
                            📍 Dekat Kampus
                        </h3>

                        <p class="text-gray-600">
                            Cocok untuk mahasiswa dan pekerja.
                        </p>

                    </div>

                    <div class="bg-white p-8 rounded-[32px] shadow-sm">

                        <h3 class="text-2xl font-semibold mb-3">
                            🛵 Akses Mudah
                        </h3>

                        <p class="text-gray-600">
                            Mudah dijangkau kendaraan umum.
                        </p>

                    </div>

                </div>

            </div>

            <div>

                <div class="bg-gray-300 rounded-[40px] h-[500px] flex items-center justify-center">
                    Google Maps Here
                </div>

            </div>

        </div>

    </div>

</section>

@endsection
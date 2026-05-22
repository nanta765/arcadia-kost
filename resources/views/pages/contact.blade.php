{{-- resources/views/pages/contact.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="pt-40 pb-24">

    <div class="max-w-4xl mx-auto px-6 text-center">

        <h1 class="text-5xl font-display text-primary mb-6">
            Hubungi Kami
        </h1>

        <p class="text-gray-600 mb-12">
            Untuk booking dan informasi lebih lanjut.
        </p>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="bg-white p-8 rounded-[32px] shadow-sm">

                <div class="text-5xl mb-5">
                    📞
                </div>

                <h3 class="text-2xl font-semibold mb-3">
                    Telepon
                </h3>

                <p class="text-gray-600">
                    +62 812 3456 7890
                </p>

            </div>

            <div class="bg-white p-8 rounded-[32px] shadow-sm">

                <div class="text-5xl mb-5">
                    📍
                </div>

                <h3 class="text-2xl font-semibold mb-3">
                    Lokasi
                </h3>

                <p class="text-gray-600">
                    Lombok, Indonesia
                </p>

            </div>

            <div class="bg-white p-8 rounded-[32px] shadow-sm">

                <div class="text-5xl mb-5">
                    ✉️
                </div>

                <h3 class="text-2xl font-semibold mb-3">
                    Email
                </h3>

                <p class="text-gray-600">
                    hello@kostarca.com
                </p>

            </div>

        </div>

    </div>

</section>

@endsection
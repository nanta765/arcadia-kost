{{-- resources/views/pages/about.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="pt-40 pb-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-16 items-center">

            <div>

                <p class="uppercase tracking-[0.2em] text-primary mb-4">
                    About Us
                </p>

                <h1 class="text-5xl font-display text-primary mb-8">
                    Tentang Kost Arca
                </h1>

                <p class="text-gray-600 leading-relaxed mb-6">
                    Kost Arca hadir sebagai hunian modern tropical
                    yang mengutamakan kenyamanan, keamanan,
                    dan suasana tinggal yang tenang.
                </p>

                <p class="text-gray-600 leading-relaxed">
                    Dengan sentuhan lokal Lombok,
                    kami menghadirkan tempat tinggal
                    yang tidak hanya nyaman,
                    tetapi juga terasa hangat dan homey.
                </p>

            </div>

            <div>

                <img
                    src="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=1200"
                    class="rounded-[40px]"
                >

            </div>

        </div>

    </div>

</section>

@endsection
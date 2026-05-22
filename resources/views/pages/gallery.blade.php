{{-- resources/views/pages/gallery.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="pt-40 pb-24">

    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-16 text-center">

            <h1 class="text-5xl font-display text-primary mb-6">
                Gallery Kost Arca
            </h1>

            <p class="text-gray-600">
                Lihat suasana dan fasilitas Kost Arca.
            </p>

        </div>

        <div class="grid md:grid-cols-3 gap-6">

            @for($i = 1; $i <= 9; $i++)

                <img
                    src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1200"
                    class="rounded-[32px] h-80 w-full object-cover"
                >

            @endfor

        </div>

    </div>

</section>

@endsection
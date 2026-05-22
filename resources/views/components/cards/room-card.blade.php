@props([
    'title',
    'price',
    'image',
])

<div class="group bg-white border border-border rounded-[32px] overflow-hidden">

    {{-- IMAGE --}}
    <div class="overflow-hidden">

        <img
            src="{{ $image }}"
            class="w-full h-80 object-cover group-hover:scale-105 transition duration-700"
            alt="{{ $title }}"
        >

    </div>

    {{-- CONTENT --}}
    <div class="p-8">

        <div class="flex items-start justify-between mb-4">

            <div>

                <h3 class="font-serif text-3xl text-primary mb-1">
                    {{ $title }}
                </h3>

                <p class="text-text-secondary">
                    Elegant modern living
                </p>

            </div>

            <span class="text-primary font-medium">
                {{ $price }}
            </span>

        </div>

        <p class="text-text-secondary leading-relaxed mb-8">
            Spacious premium room with minimalist warm interiors,
            natural lighting, and modern facilities.
        </p>

        {{-- FEATURES --}}
        <div class="flex flex-wrap gap-3 mb-8">

            <span class="px-4 py-2 rounded-full border border-border text-sm text-text-secondary">
                WiFi
            </span>

            <span class="px-4 py-2 rounded-full border border-border text-sm text-text-secondary">
                AC
            </span>

            <span class="px-4 py-2 rounded-full border border-border text-sm text-text-secondary">
                Smart TV
            </span>

        </div>

        {{-- BUTTON --}}
        <button
            class="w-full border border-primary text-primary hover:bg-primary hover:text-white rounded-full py-3 transition duration-300"
        >
            View Details
        </button>

    </div>

</div>
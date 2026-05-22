<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Tipe Kamar Kost Arca') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi Sukses atau Error (Tambahkan ini) -->
            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
                    <span class="font-bold">Gagal!</span> {{ session('error') }}
                </div>
            @endif
            <!-- Akhir Notifikasi -->
            
            <!-- Grid Layout: 1 kolom di HP, 3 kolom di Laptop -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach ($roomTypes as $type)
                <!-- Card Container -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    
                    <!-- Gambar Kamar -->
                    <div class="aspect-video w-full bg-gray-200">
                        @if ($type->image)
                            <img src="{{ asset('storage/' . $type->image) }}" alt="{{ $type->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span>Tidak ada foto</span>
                            </div>
                        @endif
                    </div>

                    <!-- Konten Card -->
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-900">{{ $type->name }}</h3>
                            <!-- Harga dengan warna aksen yang kontras -->
                            <span class="bg-blue-50 text-blue-700 text-sm font-semibold px-2.5 py-1 rounded-md">
                                Rp {{ number_format($type->price, 0, ',', '.') }}<span class="text-xs font-normal">/bln</span>
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-5 line-clamp-3">
                            {{ $type->description }}
                        </p>

                        <!-- Tombol CTA -->
                        <a href="{{ route('booking.create', $type->id) }}" class="block text-center w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-2.5 rounded-lg transition-colors text-sm">
                            Pilih Kamar Ini
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="route('logout')" 
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </a>
            </form>
        </div>
    </div>
</x-app-layout>
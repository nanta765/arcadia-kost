<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Checkout Pemesanan') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          
          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
              <div class="grid grid-cols-1 md:grid-cols-2">
                  
                  <!-- Sisi Kiri: Detail Tipe Kamar -->
                  <div class="p-8 bg-gray-50 border-r border-gray-100">
                      <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                      
                      @if ($roomType->image)
                          <img src="{{ asset('storage/' . $roomType->image) }}" alt="{{ $roomType->name }}" class="w-full rounded-lg object-cover aspect-video mb-5 shadow-sm">
                      @else
                          <div class="w-full aspect-video bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 mb-5 shadow-sm">
                              <span>Tidak ada foto</span>
                          </div>
                      @endif

                      <h4 class="text-xl font-bold text-gray-900">{{ $roomType->name }}</h4>
                      <p class="text-blue-600 font-semibold text-xl mb-3 mt-1">
                          Rp {{ number_format($roomType->price, 0, ',', '.') }} 
                          <span class="text-sm text-gray-500 font-normal">/ bulan</span>
                      </p>
                      <p class="text-gray-600 text-sm leading-relaxed border-t border-gray-200 pt-3">
                          {{ $roomType->description }}
                      </p>
                  </div>

                  <!-- Sisi Kanan: Form Input User -->
                  <div class="p-8">
                      <h3 class="text-lg font-bold text-gray-900 mb-6">Lengkapi Data Sewa</h3>

                      <!-- Peringatan jika ada Error Validasi -->
                      @if ($errors->any())
                          <div class="mb-5 p-4 bg-red-50 text-red-600 rounded-lg text-sm border border-red-200">
                              <ul class="list-disc list-inside">
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif

                      <!-- Form Action mengarah ke Route store -->
                      <form action="{{ route('booking.store', $roomType->id) }}" method="POST">
                          @csrf <!-- Token Keamanan Wajib Laravel -->

                          <!-- Input Tanggal Masuk -->
                          <div class="mb-5">
                              <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Masuk (Check-in)</label>
                              <input type="date" id="start_date" name="start_date" min="{{ date('Y-m-d') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-900 focus:border-gray-900 block w-full p-2.5">
                              <p class="text-xs text-gray-500 mt-1">Pilih tanggal kapan Anda akan mulai menempati kamar.</p>
                          </div>

                          <input type="hidden" name="duration" value="1">

                          <!-- Tombol Submit -->
                          <button type="submit" class="w-full text-white bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-3.5 text-center transition-colors">
                              Konfirmasi & Pesan Kamar
                          </button>
                          <p class="text-xs text-gray-500 mt-4 text-center">
                              Anda belum ditagih pembayaran pada tahap ini. Admin akan menghubungi Anda untuk proses selanjutnya.
                          </p>
                      </form>
                  </div>

              </div>
          </div>

      </div>
  </div>
</x-app-layout>
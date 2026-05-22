<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Pesanan Saya') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          
          @if($bookings->isEmpty())
              <!-- Tampilan jika belum punya pesanan -->
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center">
                  <div class="text-gray-400 mb-4">
                      <svg class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                      </svg>
                  </div>
                  <h3 class="text-lg font-medium text-gray-900">Belum ada kamar yang dipesan</h3>
                  <p class="mt-1 text-sm text-gray-500">Mulai pilih kamar yang nyaman untuk Anda tempati.</p>
                  <div class="mt-6">
                      <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800">
                          Lihat Katalog Kamar
                      </a>
                  </div>
              </div>
          @else
              <!-- Daftar Pesanan (Card Style) -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  @foreach($bookings as $booking)
                      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
                          
                          <!-- Header Card: Status -->
                          <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                              <span class="text-sm font-medium text-gray-500">
                                  Dipesan pada {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                              </span>
                              
                              <!-- Label Status Warna Warni -->
                              @if($booking->status == 'pending')
                                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                      Menunggu Pembayaran
                                  </span>
                              @elseif($booking->status == 'active')
                                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                      Aktif Ditempati
                                  </span>
                              @else
                                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                      {{ ucfirst($booking->status) }}
                                  </span>
                              @endif
                          </div>

                          <!-- Body Card: Detail Kamar & Harga -->
                          <div class="p-6 flex-grow">
                              <div class="flex items-start justify-between mb-4">
                                  <div>
                                      <!-- Akses data relasi: Booking -> Room -> RoomType -->
                                      <h3 class="text-xl font-bold text-gray-900">{{ $booking->room->roomType->name }}</h3>
                                      <p class="text-sm text-gray-500 mt-1">Nomor Kamar: <span class="font-bold text-gray-800">{{ $booking->room->room_number }}</span></p>
                                  </div>
                                  <div class="text-right">
                                      <p class="text-sm text-gray-500">Total Tagihan</p>
                                      <p class="text-lg font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                  </div>
                              </div>

                              <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                  <div class="grid grid-cols-2 gap-4 text-sm">
                                      <div>
                                          <p class="text-gray-500">Tanggal Masuk</p>
                                          <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                                      </div>
                                      <div>
                                          <p class="text-gray-500">Jatuh Tempo ({{ $booking->duration_months }} Bulan)</p>
                                          <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Footer Card: Aksi -->
                          @if($booking->status == 'pending')
<div class="px-6 py-4 bg-white border-t border-gray-100">
    <a href="{{ route('booking.pay', $booking->id) }}" class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-sm transition-colors">
        Bayar Sekarang via Midtrans
    </a>
</div>
@endif

                      </div>
                  @endforeach
              </div>
          @endif

      </div>
  </div>
</x-app-layout>
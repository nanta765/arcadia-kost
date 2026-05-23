<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Kost Arca</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <div class="max-w-md mx-auto my-10 p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
        <div class="text-center pb-5 border-b border-slate-100">
            <h1 class="text-xl font-bold text-slate-900">Pembayaran Kamar Kost</h1>
            <p class="text-xs text-slate-400 mt-1">Selesaikan pembayaran untuk mengamankan kamarmu</p>
        </div>

        @if(session('success'))
            <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl text-center font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-500">Total yang harus ditransfer (Pembayaran Bulan Pertama):</p>
            <h2 class="text-3xl font-black text-indigo-600 mt-1">
                Rp {{ number_format($booking->total_price / max($booking->duration_months, 1), 0, ',', '.') }}
            </h2>
            @if($booking->duration_months > 1)
            <div class="mt-2 text-xs text-slate-400">
                Total keseluruhan pesanan untuk {{ $booking->duration_months }} bulan adalah Rp {{ number_format($booking->total_price, 0, ',', '.') }}
            </div>
            @endif
            <div class="inline-block mt-2 px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold">
                Status: {{ $booking->status == 'review' ? 'Menunggu Konfirmasi' : 'Belum Dibayar' }}
            </div>
        </div>

        <div class="mt-6 flex flex-col items-center justify-center p-4 bg-slate-100 rounded-2xl">
            <p class="text-xs font-medium text-slate-500 mb-3 text-center">Scan QR ini untuk melihat info transfer di HP:</p>
            <div class="bg-white p-3 rounded-xl shadow-xs">
                {!! $qrCode !!}
            </div>
        </div>

        <div class="mt-6 p-4 border border-slate-100 rounded-xl bg-slate-50/50">
            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Detail Rekening Tujuan</p>
            <div class="mt-2 text-sm">
                <p class="flex justify-between"><span class="text-slate-500">Bank:</span> <strong class="text-slate-900">{{ $namaBank }}</strong></p>
                <p class="flex justify-between mt-1"><span class="text-slate-500">No. Rekening:</span> <strong class="text-slate-900 tracking-wide">{{ $noRekening }}</strong></p>
                <p class="flex justify-between mt-1"><span class="text-slate-500">Atas Nama:</span> <strong class="text-slate-900">{{ $atasNama }}</strong></p>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100">
            <form action="{{ route('booking.upload_proof', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="proof_of_payment" class="block text-sm font-semibold text-slate-700 mb-2">
                        Unggah Bukti Transfer Resmi (.png, .jpg)
                    </label>
                    <input type="file" name="proof_of_payment" id="proof_of_payment" accept="image/*" required
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-200 rounded-xl p-2 bg-white">
                </div>

                <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-sm transition duration-150 text-sm">
                    Kirim Bukti Pembayaran
                </button>
            </form>
        </div>
        
        <div class="mt-4 text-center">
            <a href="/my-bookings" class="text-xs text-slate-400 hover:text-slate-600 underline">Kembali ke Pesanan Saya</a>
        </div>
    </div>

</body>
</html>
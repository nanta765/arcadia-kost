<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Layanan - Kost Arca</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 pb-10">

    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
        
        <div class="text-center pb-5 border-b border-slate-100">
            <h1 class="text-xl font-bold text-slate-900">Permintaan Layanan</h1>
            <p class="text-xs text-slate-500 mt-1">Staf kami siap membantu kendala di kamar Anda</p>
        </div>

        <div class="mt-6 p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl flex items-center justify-between">
            <div>
                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider">Kamar Anda</p>
                <p class="text-lg font-black text-indigo-700">{{ $booking->room->room_number ?? '-' }}</p>
            </div>
            <div class="px-3 py-1 bg-white rounded-lg shadow-sm border border-indigo-50">
                <span class="text-xs font-bold text-indigo-600">Aktif</span>
            </div>
        </div>

        <div class="mt-6">
            <form action="{{ route('service.store', $booking->id) }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-3">Apa yang bisa kami bantu?</label>
                    <div class="grid grid-cols-2 gap-3">
                        
                        <label class="cursor-pointer group">
                            <input type="radio" name="type" value="cleaning" class="sr-only peer" required>
                            <div class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 text-center peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                <div class="text-2xl mb-1 group-hover:scale-110 transition-transform">🧹</div>
                                <div class="text-sm font-bold text-slate-600 peer-checked:text-indigo-700">Bersihkan Kamar</div>
                            </div>
                        </label>

                        <label class="cursor-pointer group">
                            <input type="radio" name="type" value="repair" class="sr-only peer" required>
                            <div class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                <div class="text-2xl mb-1 group-hover:scale-110 transition-transform">🛠️</div>
                                <div class="text-sm font-bold text-slate-600 peer-checked:text-red-700">Perbaikan Fasilitas</div>
                            </div>
                        </label>

                    </div>
                </div>

                <div class="mb-6 border-t border-slate-100 pt-6">
                    <label for="notes" class="block text-sm font-bold text-slate-700 mb-2">
                        Catatan Tambahan
                    </label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Contoh: Tolong bersihkan jam 2 siang, atau lampu kamar mandi mati..." 
                        class="w-full text-sm text-slate-700 border border-slate-200 rounded-xl p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none resize-none"></textarea>
                </div>

                <button type="submit" 
                    class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-sm transition duration-150 text-sm">
                    Kirim Permintaan
                </button>
            </form>
        </div>
        
        <div class="mt-6 text-center">
            <a href="/my-bookings" class="text-xs text-slate-400 hover:text-slate-600 font-medium">← Batal dan Kembali</a>
        </div>

    </div>

</body>
</html>
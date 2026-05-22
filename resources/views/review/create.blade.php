<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Ulasan Kamar - Kost Arca</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 pb-10">

    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
        
        <div class="text-center pb-5 border-b border-slate-100">
            <h1 class="text-xl font-bold text-slate-900">Ulas Pengalamanmu</h1>
            <p class="text-xs text-slate-500 mt-1">Bantu calon penghuni lain dengan ulasan jujurmu</p>
        </div>

        <div class="mt-6 p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl flex items-center justify-between">
            <div>
                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider">Kamar</p>
                <p class="text-lg font-black text-indigo-700">{{ $booking->room->room_number ?? 'Kamar Tidak Diketahui' }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-indigo-400 font-semibold uppercase tracking-wider">Tipe</p>
                <p class="text-sm font-bold text-indigo-700">{{ $booking->room->roomType->name ?? '-' }}</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl font-medium">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl text-center font-medium">
                {{ session('error') }}
            </div>
        @endif

        <div class="mt-6">
            <form action="{{ route('review.store', $booking->id) }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-3 text-center">Berapa bintang untuk kamar ini?</label>
                    <div class="flex justify-between px-2">
                        @for($i=1; $i<=5; $i++)
                        <label class="flex flex-col items-center cursor-pointer group">
                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                            
                            <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-100 border-2 border-transparent peer-checked:bg-amber-400 peer-checked:border-amber-500 peer-checked:text-white peer-checked:shadow-md text-slate-400 font-bold text-lg transition-all duration-200 group-hover:bg-slate-200">
                                {{ $i }}
                            </div>
                            <span class="text-[10px] mt-1 text-slate-400 peer-checked:text-amber-600 font-bold uppercase tracking-wide">Bintang {{ $i }}</span>
                        </label>
                        @endfor
                    </div>
                </div>

                <div class="mb-6 border-t border-slate-100 pt-6">
                    <label for="comment" class="block text-sm font-bold text-slate-700 mb-2">
                        Ceritakan pengalamanmu (Opsional)
                    </label>
                    <textarea name="comment" id="comment" rows="4" placeholder="Kamar bersih, fasilitas lengkap, air lancar..." 
                        class="w-full text-sm text-slate-700 border border-slate-200 rounded-xl p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors outline-none resize-none"></textarea>
                </div>

                <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-sm transition duration-150 text-sm">
                    Kirim Ulasan
                </button>
            </form>
        </div>
        
        <div class="mt-6 text-center">
            <a href="/my-bookings" class="text-xs text-slate-400 hover:text-slate-600 font-medium">← Batal dan Kembali</a>
        </div>

    </div>

</body>
</html>
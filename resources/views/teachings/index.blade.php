<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>የትምህርቶች ማዕከል | Wengel for World</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',
                        secondary: '#D97706',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-800 font-sans min-h-screen flex flex-col justify-between">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center font-black">W</div>
                <span class="font-extrabold text-primary tracking-wide">WENGEL <span class="text-secondary">FOR WORLD</span></span>
            </a>
            <div class="flex items-center space-x-5 text-sm font-medium">
                <a href="/" class="text-gray-600 hover:text-primary transition">መነሻ</a>
                <a href="/teachings" class="text-primary font-bold">ትምህርቶች</a>
                <a href="/pastors" class="text-gray-600 hover:text-primary transition">አገልጋዮች</a>
                <a href="/prayer-requests" class="text-gray-600 hover:text-primary transition">የፀሎት ጥያቄዎች</a>
            </div>
        </div>
    </header>

    <!-- Banner -->
    <section class="bg-gradient-to-r from-blue-950 via-primary to-indigo-900 text-white py-12 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">የእግዚአብሔር ቃል ትምህርቶች</h1>
            <p class="text-blue-200 text-sm sm:text-base">
                መንፈሳዊ ህይወትዎን የሚያንጹ፣ ለዕለት ተዕለት ኑሮዎ ብርታት የሚሆኑ የስብከትና የጥናት መልእክቶች
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-10 w-full flex-1">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($teachings as $teaching)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="p-6 pb-2">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $teaching->type == 'audio' ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700' }}">
                                    <i class="fas {{ $teaching->type == 'audio' ? 'fa-headphones' : 'fa-video' }} mr-1"></i>
                                    {{ $teaching->type == 'audio' ? 'የድምፅ ትምህርት' : 'የቪዲዮ ስብከት' }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    <i class="fas fa-eye text-[10px] mr-1"></i> {{ $teaching->views_count }}
                                </span>
                            </div>

                            <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 hover:text-primary transition">
                                {{ $teaching->title }}
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed mb-4">
                                {{ $teaching->content }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 text-primary flex items-center justify-center text-xs font-bold">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">{{ $teaching->pastor->name ?? 'አገልጋይ' }}</span>
                        </div>
                        <a href="/teachings/{{ $teaching->id }}" class="text-xs font-bold text-secondary hover:text-amber-600 flex items-center space-x-1">
                            <span>ተከታተል</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-200">
                    <i class="fas fa-book-reader text-gray-300 text-4xl mb-3"></i>
                    <h4 class="font-bold text-gray-700 mb-1">እስካሁን የተጫነ ትምህርት የለም</h4>
                    <p class="text-xs text-gray-500">አዳዲስ ትምህርቶች በቅርቡ ይጫናሉ።</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 px-4 text-center text-xs text-gray-500">
        &copy; 2024 Wengel for World. Powered by <span class="text-primary font-bold">Mela Solution</span> (📞 0913064239 / 0703064239)
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>የፀሎት ጥያቄዎች | Wengel for World</title>
    <!-- Tailwind CSS CDN -->
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
<body class="bg-slate-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Navbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center font-black">W</div>
                <span class="font-extrabold text-primary tracking-wide">WENGEL <span class="text-secondary">FOR WORLD</span></span>
            </a>
            <div class="flex items-center space-x-4 text-sm font-medium">
                <a href="/" class="text-gray-600 hover:text-primary transition">መነሻ ገጽ</a>
                <a href="/teachings" class="text-gray-600 hover:text-primary transition">ትምህርቶች</a>
                <a href="/prayer-requests" class="text-primary font-bold">የፀሎት ጥያቄዎች</a>
            </div>
        </div>
    </header>

    <!-- Header Banner -->
    <section class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white py-12 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-white/10 rounded-full mb-4">
                <i class="fas fa-praying-hands text-amber-400 text-xl"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">የፀሎት ጥያቄዎች መድረክ</h1>
            <p class="text-blue-200 text-sm sm:text-base">
                "አንዳች አትጨነቁ፤ ነገር ግን በነገር ሁሉ በጸሎትና በምልጃ ከምስጋና ጋር በእግዚአብሔር ዘንድ ልመናችሁን አስታውቁ።" (ፊልጵስዩስ 4:6)
            </p>
        </div>
    </section>

    <!-- Main Content Grid -->
    <main class="max-w-6xl mx-auto px-4 py-10 w-full flex-1">
        
        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-300 rounded-xl text-emerald-800 flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Prayer Submit Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center space-x-2">
                        <i class="fas fa-edit text-secondary"></i>
                        <span>የፀሎት ጥያቄዎን ይላኩ</span>
                    </h2>
                    <p class="text-xs text-gray-500 mb-6">የፀሎት አገልጋዮቻችን በልዩ ትጋት በፀሎት ያስቡዎታል</p>

                    <form action="{{ route('prayer.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">ስምዎ (አማራጭ)</label>
                            <input type="text" name="requester_name" placeholder="ሙሉ ስምዎ (ካልፈለጉ ክፍት ይተዉት)" class="w-full text-sm px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">የፀሎቱ ርዕስ *</label>
                            <input type="text" name="title" required placeholder="ለምሳሌ፡ ስለ ፈውስ፣ ስለ ትዳር፣ ስለ ስራ..." class="w-full text-sm px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">የፀሎቱ ዝርዝር *</label>
                            <textarea name="request_body" rows="4" required placeholder="የፀሎት ፍላጎትዎን እዚህ በዝርዝር ያጋሩን..." class="w-full text-sm px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        <div class="flex items-center space-x-2 pt-1">
                            <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" class="rounded text-primary focus:ring-primary h-4 w-4">
                            <label for="is_anonymous" class="text-xs text-gray-600 font-medium select-none cursor-pointer">ስሜ እንዳይታይ (ማንነቴ እንዳይገለጽ) እፈልጋለሁ</label>
                        </div>

                        <button type="submit" class="w-full py-3 bg-primary hover:bg-blue-900 text-white font-bold rounded-xl shadow transition flex items-center justify-center space-x-2 mt-4">
                            <i class="fas fa-paper-plane text-xs"></i>
                            <span>ጥያቄውን ላክ</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Prayer Requests List -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-gray-800 text-lg">የቀረቡ የፀሎት ርዕሶች</h3>
                    <span class="text-xs text-gray-500 bg-gray-200/80 px-2.5 py-1 rounded-full font-semibold">{{ count($prayers) }} ጥያቄዎች</span>
                </div>

                @forelse($prayers as $prayer)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-gray-300 transition">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-blue-50 text-primary flex items-center justify-center font-bold text-sm">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $prayer->requester_name }}</h4>
                                    <span class="text-xs text-gray-400">ከአፍታ በፊት የቀረበ</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60 flex items-center space-x-1">
                                <i class="fas fa-hands-helping text-[10px]"></i>
                                <span>በፀሎት ላይ</span>
                            </span>
                        </div>
                        <h5 class="font-bold text-gray-800 mb-2">{{ $prayer->title }}</h5>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4 whitespace-pre-line">{{ $prayer->request }}</p>
                        
                        <div class="border-t border-gray-100 pt-3 flex items-center justify-between text-xs text-gray-500">
                            <span class="text-primary font-medium flex items-center space-x-1">
                                <i class="fas fa-heart text-rose-500"></i>
                                <span>አብረን እየጸለይን ነው</span>
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-200">
                        <i class="fas fa-praying-hands text-gray-300 text-4xl mb-3"></i>
                        <h4 class="font-bold text-gray-700 mb-1">እስካሁን የቀረበ የፀሎት ጥያቄ የለም</h4>
                        <p class="text-xs text-gray-500">የመጀመሪያው ሰው ሆነው የፀሎት ፍላጎትዎን ያጋሩ።</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500">
        &copy; 2024 Wengel for World. All rights reserved. Powered by Mela Solution.
    </footer>

</body>
</html>

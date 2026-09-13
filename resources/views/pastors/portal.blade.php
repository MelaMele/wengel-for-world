<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pastor->name }} | የወንጌል ፖርታል</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#1E3A8A', secondary: '#D97706' }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-800 font-sans min-h-screen flex flex-col justify-between">

    <!-- Header Banner -->
    <header class="bg-gradient-to-r from-blue-950 via-primary to-slate-900 text-white py-14 px-4 shadow-lg">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-white/10 backdrop-blur border-4 border-white/20 flex items-center justify-center text-4xl shadow-inner">
                <i class="fas fa-user-tie text-amber-300"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black mb-2">{{ $pastor->name }}</h1>
            <span class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-secondary text-white inline-block mb-4 shadow">
                {{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልግሎት' }}
            </span>
            <p class="text-sm text-blue-100 max-w-xl mx-auto leading-relaxed">
                {{ $pastor->pastorProfile->bio ?? 'የእግዚአብሔርን ቃል ለዓለም ሁሉ ለማድረስ የተዘጋጀ መንፈሳዊ መድረክ።' }}
            </p>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10 w-full flex-1">
        
        <!-- Counseling Alert -->
        @if(session('counseling_success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-800 flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-2xl"></i>
                <div>
                    <h4 class="font-bold">መልእክትዎ ደርሷል!</h4>
                    <p class="text-xs">{{ session('counseling_success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Counseling Box -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-200">
                <div class="flex items-center space-x-2 text-primary font-bold mb-1">
                    <i class="fas fa-lock text-secondary"></i>
                    <h3 class="text-lg">ለፓስተሩ ሚስጥራዊ ጥያቄ ይላኩ</h3>
                </div>
                <p class="text-xs text-gray-500 mb-6">መልእክትዎን ፓስተሩ በግል ተመልክተው ምላሽ ይሰጡዎታል</p>

                <form action="/pastors/{{ $pastor->id }}/counseling" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ስምዎ *</label>
                        <input type="text" name="sender_name" required placeholder="ሙሉ ስምዎ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ስልክ ወይም ኢሜይል *</label>
                        <input type="text" name="sender_phone_or_email" required placeholder="መልስ የሚቀበሉበት አድራሻ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የጉዳዩ ርዕስ *</label>
                        <input type="text" name="subject" required placeholder="ለምሳሌ፡ ስለ ትዳር፣ ስለ ስራ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ዝርዝር መልእክት *</label>
                        <textarea name="message" rows="4" required placeholder="የምክር ጥያቄዎን እዚህ ያጋሩ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-secondary hover:bg-amber-600 text-white font-bold rounded-xl shadow transition">
                        መልእክቱን ላክ
                    </button>
                </form>
            </div>

            <!-- Pastor's Teachings / Audios / Videos -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-gray-900 text-base flex items-center space-x-2">
                    <i class="fas fa-play-circle text-primary"></i>
                    <span>የፓስተሩ ትምህርቶችና ስብከቶች</span>
                </h3>

                @forelse($pastor->teachings as $t)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200">
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-blue-50 text-primary mb-2 inline-block">
                            {{ $t->type }}
                        </span>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $t->title }}</h4>
                        <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $t->content }}</p>
                        
                        @if($t->media_url)
                            @if($t->type == 'audio')
                                <audio controls class="w-full h-8 my-2">
                                    <source src="{{ $t->media_url }}">
                                </audio>
                            @else
                                <a href="/teachings/{{ $t->id }}" class="text-xs font-bold text-secondary hover:underline flex items-center space-x-1">
                                    <span>ተከታተል / ተመልከት</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                @empty
                    <div class="bg-white p-8 rounded-2xl text-center border border-gray-200">
                        <p class="text-xs text-gray-400">እስካሁን የተጫነ ትምህርት የለም።</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500">
        &copy; 2024 Wengel for World. Powered by Mela Solution.
    </footer>

</body>
</html>

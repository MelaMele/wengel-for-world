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
    <header class="bg-gradient-to-r from-blue-950 via-primary to-slate-900 text-white py-12 px-4 shadow-lg">
        <div class="max-w-5xl mx-auto text-center">
            <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-white/10 backdrop-blur border-4 border-white/20 flex items-center justify-center text-3xl shadow-inner">
                <i class="fas fa-user-tie text-amber-300"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black mb-1">{{ $pastor->name }}</h1>
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-secondary text-white inline-block mb-3 shadow">
                {{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልግሎት' }}
            </span>
            <p class="text-xs sm:text-sm text-blue-100 max-w-lg mx-auto leading-relaxed">
                {{ $pastor->pastorProfile->bio ?? 'የእግዚአብሔርን ቃል ለዓለም ሁሉ ለማድረስ የተዘጋጀ መንፈሳዊ መድረክ።' }}
            </p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 w-full flex-1">
        
        <!-- Counseling Alert -->
        @if(session('counseling_success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-800 flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <span class="text-xs sm:text-sm font-bold">{{ session('counseling_success') }}</span>
            </div>
        @endif

        <!-- 🔴 ክፍል 1፡ የቀጥታ ስርጭት መመልከቻ ስክሪን (LIVE VIDEO SCREEN) -->
        <div class="bg-slate-900 text-white rounded-3xl p-6 mb-8 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500 animate-ping"></span>
                    <h3 class="text-base font-black text-white">የቀጥታ ስርጭት አገልግሎት (Live Stream)</h3>
                </div>
                <span class="text-[11px] bg-rose-600/30 text-rose-300 border border-rose-500/40 px-3 py-1 rounded-full font-bold">
                    🔴 የቀጥታ ቪዲዮና ድምፅ
                </span>
            </div>

            <!-- Live Video Frame -->
            <div class="w-full bg-black rounded-2xl overflow-hidden aspect-video relative flex items-center justify-center border border-slate-700 shadow-inner">
                <video id="remoteVideo" autoplay playsinline class="w-full h-full object-cover hidden"></video>

                <!-- Waiting Screen when Pastor is not live yet -->
                <div id="liveWaitingBox" class="text-center p-8">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center text-amber-400 text-2xl mx-auto mb-3 animate-pulse">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-200 mb-1">የቀጥታ ስርጭት መድረክ</h4>
                    <p class="text-xs text-slate-400 max-w-md mx-auto">ፓስተሩ ከዳሽቦርዳቸው የቀጥታ ስርጭት ሲጀምሩ እዚህ ስክሪን ላይ በቀጥታ ፊት ለፊት ይታዩዎታል እና ይደመጣሉ።</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- 💬 ክፍል 2፡ ሚስጥራዊ የምክር ጥያቄ መላኪያ -->
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
                        <input type="text" name="subject" required placeholder="ለምሳሌ፡ ስለ ትዳር፣ ስለ ፈውስ፣ ስለ ስራ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ዝርዝር መልእክት *</label>
                        <textarea name="message" rows="4" required placeholder="የምክር ጥያቄዎን ወይም ሸክምዎን እዚህ ያጋሩ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-secondary hover:bg-amber-600 text-white font-bold rounded-xl shadow transition">
                        መልእክቱን ላክ
                    </button>
                </form>
            </div>

            <!-- 📖 ክፍል 3፡ የጽሁፍ ትምህርቶች፣ ጥናቶችና የሚዲያ ፋይሎች -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-gray-900 text-base flex items-center space-x-2">
                    <i class="fas fa-book-open text-primary"></i>
                    <span>የትምህርቶች፣ የጽሁፍ ጥናቶችና ሚዲያ ማዕከል</span>
                </h3>

                @forelse($pastor->teachings as $t)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $t->type == 'article' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($t->type == 'audio' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-primary border border-blue-200') }}">
                                <i class="fas {{ $t->type == 'article' ? 'fa-file-alt' : ($t->type == 'audio' ? 'fa-headphones' : 'fa-video') }} mr-1"></i>
                                {{ $t->type == 'article' ? 'የጽሁፍ ትምህርት / ጥናት' : ($t->type == 'audio' ? 'የድምፅ ትምህርት' : 'ቪዲዮ ስብከት') }}
                            </span>
                            <span class="text-[11px] text-gray-400">{{ $t->created_at }}</span>
                        </div>

                        <h4 class="font-bold text-gray-900 text-base mb-2">{{ $t->title }}</h4>

                        <!-- የጽሁፍ ትምህርት ከሆነ ሙሉ ጽሁፉን እዚህ ማንበብ ይችላሉ -->
                        @if($t->type == 'article')
                            <div class="bg-slate-50 p-4 rounded-2xl text-xs text-gray-700 leading-relaxed whitespace-pre-line border border-gray-100">
                                {{ $t->content }}
                            </div>
                        @else
                            <p class="text-xs text-gray-500 mb-3">{{ $t->content }}</p>
                            @if($t->media_url)
                                @if($t->type == 'audio')
                                    <audio controls class="w-full my-2">
                                        <source src="{{ $t->media_url }}">
                                    </audio>
                                @elseif($t->type == 'video')
                                    <video controls class="w-full rounded-xl my-2 max-h-48 bg-black">
                                        <source src="{{ $t->media_url }}">
                                    </video>
                                @endif
                            @endif
                        @endif
                    </div>
                @empty
                    <div class="bg-white p-8 rounded-3xl text-center border border-gray-200">
                        <i class="fas fa-book-reader text-gray-300 text-3xl mb-2"></i>
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

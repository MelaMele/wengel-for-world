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
    <header class="bg-gradient-to-r from-blue-950 via-primary to-slate-900 text-white py-10 px-4 shadow-lg">
        <div class="max-w-5xl mx-auto text-center">
            <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-white/10 backdrop-blur border-4 border-white/20 flex items-center justify-center text-3xl shadow-inner">
                <i class="fas fa-user-tie text-amber-300"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black mb-1">{{ $pastor->name }}</h1>
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-secondary text-white inline-block mb-2 shadow">
                {{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልግሎት' }}
            </span>
            <p class="text-xs sm:text-sm text-blue-100 max-w-lg mx-auto leading-relaxed">
                {{ $pastor->pastorProfile->bio ?? 'የእግዚአብሔርን ቃል ለዓለም ሁሉ ለማድረስ የተዘጋጀ መንፈሳዊ መድረክ።' }}
            </p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 w-full flex-1">
        
        <!-- Live Video Screen -->
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

            <div class="w-full bg-black rounded-2xl overflow-hidden aspect-video relative flex items-center justify-center border border-slate-700 shadow-inner">
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center text-amber-400 text-2xl mx-auto mb-3 animate-pulse">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-200 mb-1">የቀጥታ ስርጭት መድረክ</h4>
                    <p class="text-xs text-slate-400 max-w-md mx-auto">ፓስተሩ ከዳሽቦርዳቸው የቀጥታ ስርጭት ሲጀምሩ እዚህ ስክሪን ላይ በቀጥታ ፊት ለፊት ይታዩዎታል እና ይደመጣሉ።</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- 💬 ክፍል 1፡ ዘመናዊ የውይይት መስኮት (TWO-WAY CHAT BOX) -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[600px]">
                
                <!-- Chat Header -->
                <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">ከ {{ $pastor->name }} ጋር ውይይት</h4>
                            <span class="text-[10px] text-emerald-400 flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1 animate-pulse"></span>
                                ሚስጥራዊ የሁለትዮሽ መስመር
                            </span>
                        </div>
                    </div>

                    @if($believerName)
                        <div class="flex items-center space-x-2 text-xs">
                            <span class="text-gray-300 font-medium">{{ $believerName }}</span>
                            <a href="/p/{{ $pastor->email }}/logout" class="text-rose-400 hover:underline text-[11px]" title="ስም ቀይር">(ውጣ)</a>
                        </div>
                    @endif
                </div>

                <!-- Chat Messages Area (የጥያቄና መልስ መመልከቻ) -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-slate-50/50">
                    @if(count($chatMessages) > 0)
                        @foreach($chatMessages as $msg)
                            <!-- 1. የምዕመኑ ጥያቄ (Right Side - Green/Blue) -->
                            <div class="flex flex-col items-end">
                                <div class="bg-primary text-white p-3.5 rounded-2xl rounded-tr-none max-w-[85%] text-xs leading-relaxed shadow-sm">
                                    {{ $msg->message }}
                                </div>
                                <span class="text-[9px] text-gray-400 mt-1">የእርስዎ ጥያቄ</span>
                            </div>

                            <!-- 2. የፓስተሩ መልስ (Left Side - White/Gold) -->
                            @if($msg->reply)
                                <div class="flex flex-col items-start">
                                    <div class="bg-white border-2 border-secondary/30 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] text-xs leading-relaxed shadow-sm text-gray-800">
                                        <div class="flex items-center space-x-1 text-secondary font-bold mb-1 text-[11px]">
                                            <i class="fas fa-check-circle"></i>
                                            <span>የፓስተሩ መልስ፡</span>
                                        </div>
                                        {{ $msg->reply }}
                                    </div>
                                    <span class="text-[9px] text-secondary font-bold mt-1">ከአገልጋዩ የተሰጠ መልስ ✓</span>
                                </div>
                            @else
                                <div class="flex items-center space-x-1.5 text-[10px] text-amber-600 bg-amber-50 px-3 py-1 rounded-full w-fit">
                                    <i class="fas fa-clock animate-spin"></i>
                                    <span>ፓስተሩ መልእክትዎን አይተው መልስ እየጻፉ ነው...</span>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-16 text-gray-400">
                            <i class="fas fa-comment-dots text-4xl mb-2 text-gray-300"></i>
                            <p class="text-xs font-medium">የሚያስጨንቅዎትን ጥያቄ ወይም የምክር ፍላጎት ከስር ይጻፉ።</p>
                            <p class="text-[10px] text-gray-400 mt-1">ፓስተሩ መልስ ሲሰጡዎት እዚህ ቦክስ ውስጥ ያዩታል!</p>
                        </div>
                    @endif
                </div>

                <!-- Chat Input Form -->
                <form action="/p/{{ $pastor->email }}/send-chat" method="POST" class="p-4 bg-white border-t border-gray-200">
                    @csrf
                    
                    @if(!$believerName)
                        <!-- ስም እና ስልክ ካልተመዘገበ ለመጀመሪያ ጊዜ ይጠይቃል -->
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <input type="text" name="sender_name" required placeholder="ሙሉ ስምዎ *" class="text-xs px-3 py-2 rounded-xl border border-gray-300 focus:border-primary outline-none">
                            <input type="text" name="sender_phone" required placeholder="ስልክ ቁጥርዎ *" class="text-xs px-3 py-2 rounded-xl border border-gray-300 focus:border-primary outline-none">
                        </div>
                    @else
                        <input type="hidden" name="sender_name" value="{{ $believerName }}">
                        <input type="hidden" name="sender_phone" value="{{ $believerPhone }}">
                    @endif

                    <div class="flex items-center space-x-2">
                        <input type="text" name="message" required placeholder="ጥያቄዎን ወይም ሸክምዎን እዚህ ይጻፉ..." class="flex-1 text-xs px-4 py-3 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        <button type="submit" class="px-5 py-3 bg-secondary hover:bg-amber-600 text-white font-bold text-xs rounded-2xl shadow transition flex items-center space-x-1">
                            <span>ላክ</span>
                            <i class="fas fa-paper-plane text-[10px]"></i>
                        </button>
                    </div>
                </form>

            </div>

            <!-- 📖 ክፍል 2፡ የጽሁፍ ትምህርቶች፣ ጥናቶችና ሚዲያዎች -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-gray-900 text-base flex items-center space-x-2">
                    <i class="fas fa-book-open text-primary"></i>
                    <span>የትምህርቶችና የጽሁፍ ጥናቶች ማዕከል</span>
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

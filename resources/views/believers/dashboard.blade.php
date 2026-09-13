<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $believerName }} | የወንጌል ዳሽቦርድ</title>
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

    <!-- Topbar -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 border-b border-slate-800">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-secondary text-white flex items-center justify-center font-black">
                    <i class="fas fa-cross"></i>
                </div>
                <div>
                    <h2 class="font-bold text-sm text-white leading-tight">{{ $pastor->name }}</h2>
                    <span class="text-[10px] text-amber-300 block">{{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልግሎት' }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Believer Profile & Logout -->
                <div class="flex items-center space-x-2 bg-slate-800 px-3 py-1.5 rounded-xl border border-slate-700 text-xs">
                    <i class="fas fa-user-circle text-secondary"></i>
                    <span class="font-bold">{{ $believerName }}</span>
                    <a href="/p/{{ $pastor->email }}/believer-logout" class="text-rose-400 hover:underline ml-1" title="ውጣ">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 w-full flex-1">

        <!-- 🔴 የቀጥታ ስርጭት ስክሪን -->
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
            
            <!-- 💬 ዘመናዊ የውይይት መስኮት (TWO-WAY CHAT) -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[550px]">
                
                <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">ከ {{ $pastor->name }} ጋር ውይይት</h4>
                            <span class="text-[10px] text-emerald-400">ሚስጥራዊ የሁለትዮሽ መስመር</span>
                        </div>
                    </div>
                    <span class="text-xs text-slate-400 font-mono">{{ $believerPhone }}</span>
                </div>

                <!-- Messages Area -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-slate-50/50" id="chatArea">
                    @forelse($chatMessages as $msg)
                        <!-- የምዕመኑ ጥያቄ (Right) -->
                        <div class="flex flex-col items-end">
                            <div class="bg-primary text-white p-3.5 rounded-2xl rounded-tr-none max-w-[85%] text-xs leading-relaxed shadow-sm">
                                {{ $msg->message }}
                            </div>
                            <span class="text-[9px] text-gray-400 mt-1">{{ $msg->created_at }}</span>
                        </div>

                        <!-- የፓስተሩ መልስ (Left) -->
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
                                <span>ፓስተሩ መልእክትዎን እያዩ ነው...</span>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-16 text-gray-400">
                            <i class="fas fa-comment-dots text-4xl mb-2 text-gray-300"></i>
                            <p class="text-xs font-medium">የሚያስጨንቅዎትን ጥያቄ ወይም የምክር ፍላጎት ከስር ይጻፉ።</p>
                            <p class="text-[10px] text-gray-400 mt-1">ፓስተሩ መልስ ሲሰጡዎት እዚህ ቦክስ ውስጥ ያዩታል!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Chat Input Form (ስምና ስልክ ድጋሚ አይጠየቅም!) -->
                <form action="/p/{{ $pastor->email }}/send-message" method="POST" class="p-3 bg-white border-t border-gray-200 flex items-center space-x-2">
                    @csrf
                    <input type="text" name="message" required placeholder="ጥያቄዎን ወይም ሸክምዎን እዚህ ይጻፉ..." class="flex-1 text-xs px-4 py-3 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    <button type="submit" class="px-5 py-3 bg-secondary hover:bg-amber-600 text-white font-bold text-xs rounded-2xl shadow transition flex items-center space-x-1">
                        <span>ላክ</span>
                        <i class="fas fa-paper-plane text-[10px]"></i>
                    </button>
                </form>

            </div>

            <!-- 📖 የጽሁፍ ትምህርቶች፣ ጥናቶችና ሚዲያዎች -->
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

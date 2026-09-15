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
    <style>
        @keyframes floatUp {
            0% { transform: translateY(0) scale(0.8); opacity: 1; }
            100% { transform: translateY(-120px) scale(1.4); opacity: 0; }
        }
        .animate-float {
            animation: floatUp 1.8s ease-out forwards;
        }
    </style>
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
                <!-- Giving / Tithe Button -->
                <button onclick="document.getElementById('givingModal').showModal()" class="px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-black rounded-xl shadow-md transition flex items-center space-x-1.5 animate-pulse">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span>አስራት / ስጦታ ስጥ</span>
                </button>

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

        <!-- 🔴 GLOBAL LIVE VIDEO SCREEN -->
        <div class="bg-slate-900 text-white rounded-3xl p-6 mb-8 border border-slate-800 shadow-xl relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500 animate-ping"></span>
                    <h3 class="text-base font-black text-white">የቀጥታ ስርጭት አገልግሎት (Global Live Stream)</h3>
                </div>
                <span class="text-[11px] bg-rose-600/30 text-rose-300 border border-rose-500/40 px-3 py-1 rounded-full font-bold">
                    🔴 የቀጥታ ቪዲዮና ድምፅ
                </span>
            </div>

            <div class="w-full bg-black rounded-2xl overflow-hidden aspect-video relative flex items-center justify-center border border-slate-700 shadow-inner" id="videoContainer">
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center text-amber-400 text-2xl mx-auto mb-3 animate-pulse">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-200 mb-1">ዓለም አቀፍ የቀጥታ ስርጭት መድረክ</h4>
                    <p class="text-xs text-slate-400 max-w-md mx-auto">ፓስተሩ የቀጥታ ስርጭት ሲጀምሩ እዚህ ስክሪን ላይ በቀጥታ ይታያሉ። በስርጭቱ ወቅት ከስር ባሉት አዝራሮች አሜን ይበሉ!</p>
                </div>

                <div id="reactionsOverlay" class="absolute inset-0 pointer-events-none overflow-hidden"></div>

                <div class="absolute bottom-4 right-4 flex items-center space-x-2 bg-black/60 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10 z-20">
                    <button onclick="sendReaction('🙏')" class="hover:scale-125 transition text-lg" title="አሜን">🙏</button>
                    <button onclick="sendReaction('❤️')" class="hover:scale-125 transition text-lg" title="ተባረኩ">❤️</button>
                    <button onclick="sendReaction('🔥')" class="hover:scale-125 transition text-lg" title="እሳት">🔥</button>
                    <button onclick="sendReaction('🙌')" class="hover:scale-125 transition text-lg" title="ሀሌሉያ">🙌</button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- 💬 TWO-WAY VOICE & TEXT CHAT -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[550px]">
                
                <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">ከ {{ $pastor->name }} ጋር ውይይት</h4>
                            <span class="text-[10px] text-emerald-400">ሚስጥራዊ የሁለትዮሽ መስመር (በድምፅና በጽሁፍ)</span>
                        </div>
                    </div>
                    <span class="text-xs text-slate-400 font-mono">{{ $believerPhone }}</span>
                </div>

                <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-slate-50/50" id="chatArea">
                    @forelse($chatMessages as $msg)
                        <div class="flex flex-col items-end">
                            <div class="bg-primary text-white p-3.5 rounded-2xl rounded-tr-none max-w-[85%] text-xs leading-relaxed shadow-sm">
                                @if(str_starts_with($msg->message, 'AUDIO_VOICE:'))
                                    <div class="flex items-center space-x-2 py-1">
                                        <i class="fas fa-microphone text-amber-300 text-sm"></i>
                                        <audio controls class="h-8 max-w-[200px]">
                                            <source src="{{ str_replace('AUDIO_VOICE:', '', $msg->message) }}" type="audio/webm">
                                        </audio>
                                    </div>
                                @else
                                    {{ $msg->message }}
                                @endif
                            </div>
                            <span class="text-[9px] text-gray-400 mt-1">{{ $msg->created_at }}</span>
                        </div>

                        @if($msg->reply)
                            <div class="flex flex-col items-start">
                                <div class="bg-white border-2 border-secondary/30 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] text-xs leading-relaxed shadow-sm text-gray-800">
                                    <div class="flex items-center space-x-1 text-secondary font-bold mb-1 text-[11px]">
                                        <i class="fas fa-check-circle"></i>
                                        <span>የፓስተሩ መልስ፡</span>
                                    </div>
                                    @if(str_starts_with($msg->reply, 'AUDIO_VOICE:'))
                                        <div class="flex items-center space-x-2 py-1">
                                            <i class="fas fa-microphone-alt text-secondary text-sm"></i>
                                            <audio controls class="h-8 max-w-[200px]">
                                                <source src="{{ str_replace('AUDIO_VOICE:', '', $msg->reply) }}" type="audio/webm">
                                            </audio>
                                        </div>
                                    @else
                                        {{ $msg->reply }}
                                    @endif
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
                            <p class="text-xs font-medium">ጥያቄዎን ወይም የምክር ፍላጎትዎን በጽሁፍ ወይም በድምፅ ይላኩ።</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-3 bg-white border-t border-gray-200">
                    <form id="msgForm" action="/p/{{ $pastor->email }}/send-message" method="POST" class="flex items-center space-x-2">
                        @csrf
                        <input type="hidden" name="voice_data" id="voiceDataInput">
                        <input type="text" name="message" id="textInput" placeholder="ጥያቄዎን እዚህ ይጻፉ..." class="flex-1 text-xs px-4 py-3 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        
                        <button type="button" id="recordBtn" onclick="toggleRecording()" class="p-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl transition" title="ድምፅ ለመቅረጽ">
                            <i class="fas fa-microphone text-sm" id="micIcon"></i>
                        </button>

                        <button type="submit" id="sendBtn" class="px-5 py-3 bg-secondary hover:bg-amber-600 text-white font-bold text-xs rounded-2xl shadow transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <span id="recordStatus" class="text-[10px] text-rose-600 hidden font-bold mt-1 animate-pulse">● ድምፅ እየተቀረጸ ነው... ለማቆምና ለመላክ ድጋሚ ማይኩን ይጫኑ</span>
                </div>

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
                        <p class="text-xs text-gray-400">እስካሁን የተጫነ ትምህርት የለም።</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <!-- 🌟 DYNAMIC GIVING MODAL (የፓስተሩ የራሱ ቴሌብርና ባንክ ማሳያ) -->
    <dialog id="givingModal" class="rounded-3xl p-0 w-full max-w-md shadow-2xl backdrop:bg-slate-900/60 backdrop:backdrop-blur-sm">
        
        <div class="bg-gradient-to-r from-amber-600 via-secondary to-amber-700 text-white p-6 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-xl">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h3 class="font-black text-base">አስራትና ስጦታ መስጫ</h3>
                    <span class="text-xs text-amber-100">ለ {{ $pastor->name }} አገልግሎት</span>
                </div>
            </div>
            <button onclick="document.getElementById('givingModal').close()" class="text-white hover:text-amber-200 text-2xl font-bold">
                &times;
            </button>
        </div>

        <div class="p-6 space-y-4 bg-white">
            <p class="text-xs text-gray-500 leading-relaxed text-center">
                የሚመችዎትን የክፍያ አማራጭ በመምረጥ የሂሳብ ቁጥሩን ኮፒ አድርገው በባንክ ወይም በቴሌብር መተግበሪያዎ ክፍያውን መፈጸም ይችላሉ።
            </p>

            <!-- Option 1: Telebirr (የዚህ ፓስተር የራሱ ቴሌብር) -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-gray-200 hover:border-secondary transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-black text-secondary flex items-center space-x-1.5">
                        <i class="fas fa-mobile-alt"></i>
                        <span>ቴሌብር (Telebirr)</span>
                    </span>
                    <span class="text-[10px] text-gray-400 font-medium">በስልክ ቁጥር</span>
                </div>
                <div class="flex items-center justify-between bg-white p-2.5 rounded-xl border border-gray-200">
                    <span class="font-mono font-bold text-sm text-gray-800" id="telebirrNum">{{ $pastor->pastorProfile->telebirr_no ?? $pastor->phone }}</span>
                    <button onclick="copyToClipboard('telebirrNum', this)" class="px-3 py-1.5 bg-secondary text-white text-[11px] font-bold rounded-lg hover:bg-amber-600 transition flex items-center space-x-1">
                        <i class="fas fa-copy text-[10px]"></i>
                        <span>ኮፒ</span>
                    </button>
                </div>
                <span class="text-[11px] text-gray-500 mt-1 block">የሂሳቡ ስም፡ <strong class="text-gray-700">{{ $pastor->pastorProfile->account_holder_name ?? $pastor->name }}</strong></span>
            </div>

            <!-- Option 2: CBE (የዚህ ፓስተር የራሱ CBE) -->
            @if(!empty($pastor->pastorProfile->cbe_account))
            <div class="p-4 rounded-2xl bg-slate-50 border border-gray-200 hover:border-primary transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-black text-primary flex items-center space-x-1.5">
                        <i class="fas fa-university"></i>
                        <span>የኢትዮጵያ ንግድ ባንክ (CBE)</span>
                    </span>
                    <span class="text-[10px] text-gray-400 font-medium">የባንክ ሂሳብ</span>
                </div>
                <div class="flex items-center justify-between bg-white p-2.5 rounded-xl border border-gray-200">
                    <span class="font-mono font-bold text-sm text-gray-800" id="cbeNum">{{ $pastor->pastorProfile->cbe_account }}</span>
                    <button onclick="copyToClipboard('cbeNum', this)" class="px-3 py-1.5 bg-primary text-white text-[11px] font-bold rounded-lg hover:bg-blue-900 transition flex items-center space-x-1">
                        <i class="fas fa-copy text-[10px]"></i>
                        <span>ኮፒ</span>
                    </button>
                </div>
                <span class="text-[11px] text-gray-500 mt-1 block">የሂሳቡ ስም፡ <strong class="text-gray-700">{{ $pastor->pastorProfile->account_holder_name ?? $pastor->name }}</strong></span>
            </div>
            @endif

            <!-- Option 3: Awash (የዚህ ፓስተር የራሱ Awash) -->
            @if(!empty($pastor->pastorProfile->awash_account))
            <div class="p-4 rounded-2xl bg-slate-50 border border-gray-200 hover:border-blue-500 transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-black text-blue-800 flex items-center space-x-1.5">
                        <i class="fas fa-landmark"></i>
                        <span>አዋሽ ባንክ (Awash Bank)</span>
                    </span>
                    <span class="text-[10px] text-gray-400 font-medium">የባንክ ሂሳብ</span>
                </div>
                <div class="flex items-center justify-between bg-white p-2.5 rounded-xl border border-gray-200">
                    <span class="font-mono font-bold text-sm text-gray-800" id="awashNum">{{ $pastor->pastorProfile->awash_account }}</span>
                    <button onclick="copyToClipboard('awashNum', this)" class="px-3 py-1.5 bg-blue-800 text-white text-[11px] font-bold rounded-lg hover:bg-blue-900 transition flex items-center space-x-1">
                        <i class="fas fa-copy text-[10px]"></i>
                        <span>ኮፒ</span>
                    </button>
                </div>
                <span class="text-[11px] text-gray-500 mt-1 block">የሂሳቡ ስም፡ <strong class="text-gray-700">{{ $pastor->pastorProfile->account_holder_name ?? $pastor->name }}</strong></span>
            </div>
            @endif

            <div class="bg-amber-50 rounded-2xl p-4 text-center border border-amber-200/60">
                <p class="text-xs text-amber-900 italic">
                    "እግዚአብሔር በደስታ የሚሰጠውን ይወዳልና እያንዳንዱ በልቡ እንዳሰበ ይስጥ።" (2ኛ ቆሮንቶስ 9:7)
                </p>
            </div>

            <button onclick="document.getElementById('givingModal').close()" class="w-full py-3 bg-slate-200 hover:bg-slate-300 text-gray-800 font-bold text-xs rounded-xl transition">
                ዝጋ
            </button>
        </div>
    </dialog>

    <!-- 🌟 Footer with Mela Solution Branding -->
    <footer class="bg-white border-t border-gray-200 py-6 px-4 mt-8">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
            <span class="text-xs text-gray-500">&copy; 2024 Wengel for World. All rights reserved.</span>
            <div class="text-xs text-gray-600 font-medium">
                Developed by <span class="text-primary font-black">Mela Solution</span> | 
                <span class="font-mono font-bold text-gray-800">📞 0913064239 / 0703064239</span>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function copyToClipboard(elementId, btn) {
            const text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check text-[10px]"></i> <span>ኮፒ ሆኗል!</span>';
                btn.classList.add('bg-emerald-600');
                setTimeout(() => { btn.innerHTML = originalHtml; btn.classList.remove('bg-emerald-600'); }, 2500);
            });
        }

        function sendReaction(emoji) {
            const overlay = document.getElementById('reactionsOverlay');
            const el = document.createElement('div');
            el.className = 'absolute text-3xl animate-float select-none';
            el.style.left = (Math.random() * 80 + 10) + '%';
            el.style.bottom = '20px';
            el.innerHTML = emoji;
            overlay.appendChild(el);
            setTimeout(() => { el.remove(); }, 1800);
        }

        let mediaRecorder;
        let audioChunks = [];
        let isRecording = false;

        async function toggleRecording() {
            const btn = document.getElementById('recordBtn');
            const icon = document.getElementById('micIcon');
            const status = document.getElementById('recordStatus');
            const form = document.getElementById('msgForm');

            if (!isRecording) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];
                    mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
                    mediaRecorder.onstop = () => {
                        const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                        const reader = new FileReader();
                        reader.readAsDataURL(audioBlob);
                        reader.onloadend = () => {
                            document.getElementById('voiceDataInput').value = reader.result;
                            document.getElementById('textInput').removeAttribute('required');
                            form.submit();
                        };
                    };
                    mediaRecorder.start();
                    isRecording = true;
                    btn.classList.add('bg-rose-600', 'text-white');
                    icon.className = 'fas fa-stop text-sm';
                    status.classList.remove('hidden');
                } catch (err) {
                    alert('ማይክሮፎን መክፈት አልተቻለም');
                }
            } else {
                mediaRecorder.stop();
                isRecording = false;
                btn.classList.remove('bg-rose-600', 'text-white');
                icon.className = 'fas fa-microphone text-sm';
                status.classList.add('hidden');
            }
        }
    </script>
</body>
</html>

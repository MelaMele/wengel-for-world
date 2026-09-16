<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pastor->name }} | የአገልጋይ ዳሽቦርድ</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1E3A8A">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
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
<body class="bg-slate-100 text-gray-800 font-sans min-h-screen">

    <!-- Topbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center font-black">
                    <i class="fas fa-cross"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-gray-900 text-sm sm:text-base leading-tight">{{ $pastor->name }}</h1>
                    <span class="text-xs text-secondary font-bold">{{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልግሎት' }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <a href="/p/{{ $pastor->email }}" target="_blank" class="px-3.5 py-1.5 bg-blue-50 text-primary hover:bg-blue-100 text-xs font-bold rounded-xl border border-blue-200 transition flex items-center space-x-1.5">
                    <i class="fas fa-globe text-[10px]"></i>
                    <span>የምዕመናን ገጽ</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-800 flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- 🚀 የፓስተሩ ቋሚ ሊንክ ለምዕመናን -->
        <div class="bg-gradient-to-r from-blue-950 via-primary to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 border border-blue-900">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center space-x-2 bg-amber-400/20 text-amber-300 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 border border-amber-400/30">
                        <i class="fas fa-link text-[10px]"></i>
                        <span>ለምዕመናን የሚያጋሩት የእርስዎ ቋሚ ሊንክ</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black mb-1">ይህንን 1 ሊንክ ለምዕመናን በሙሉ ይላኩ!</h2>
                    <p class="text-xs text-blue-200 max-w-xl leading-relaxed">
                        ምዕመናን ይህንን ሊንክ ተጭነው ስማቸውን በማስገባት በቀጥታ ይማራሉ፣ በድምፅና በጽሁፍ ሚስጥራዊ ጥያቄ ይጠይቁዎታል።
                    </p>
                </div>

                <div class="w-full lg:w-auto flex flex-col sm:flex-row items-center gap-3">
                    <div class="bg-white/10 backdrop-blur border border-white/20 px-4 py-3 rounded-2xl text-xs font-mono text-amber-300 w-full sm:w-auto text-center select-all">
                        https://wengel-for-world.vercel.app/p/{{ $pastor->email }}
                    </div>

                    <button onclick="copyLink()" class="w-full sm:w-auto px-5 py-3 bg-secondary hover:bg-amber-600 text-white font-bold text-xs rounded-2xl shadow-lg transition flex items-center justify-center space-x-2 whitespace-nowrap">
                        <i class="fas fa-copy"></i>
                        <span id="copyBtnText">ሊንኩን ኮፒ አድርግ</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 💳 የፓስተሩ የአስራትና ስጦታ መቀበያ መረጃዎች -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-200 mb-8">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-secondary flex items-center justify-center text-lg">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-gray-900">የአስራት እና ስጦታ መቀበያ የባንክ መረጃዎች</h3>
                    <p class="text-xs text-gray-500">ምዕመናን ስጦታ ሲልኩ የሚመለከቱትን የቴሌብር እና የባንክ ቁጥሮች እዚህ ያስገቡ</p>
                </div>
            </div>

            <form action="/pastor-desk/{{ $pastor->id }}/update-accounts" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ቴሌብር ቁጥር</label>
                    <input type="text" name="telebirr_no" value="{{ $pastor->pastorProfile->telebirr_no ?? $pastor->phone }}" placeholder="0911..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-gray-300 focus:border-secondary outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ንግድ ባንክ (CBE) ቁጥር</label>
                    <input type="text" name="cbe_account" value="{{ $pastor->pastorProfile->cbe_account ?? '' }}" placeholder="1000..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-gray-300 focus:border-secondary outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">አዋሽ ባንክ ቁጥር</label>
                    <input type="text" name="awash_account" value="{{ $pastor->pastorProfile->awash_account ?? '' }}" placeholder="0132..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-gray-300 focus:border-secondary outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የአካውንቱ ስም</label>
                    <div class="flex gap-2">
                        <input type="text" name="account_holder_name" value="{{ $pastor->pastorProfile->account_holder_name ?? $pastor->name }}" placeholder="ሙሉ ስም" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-gray-300 focus:border-secondary outline-none">
                        <button type="submit" class="px-4 py-2.5 bg-secondary hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow transition whitespace-nowrap">
                            መዝግብ
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- SECTION 1: LIVE BROADCAST SCREEN -->
        <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 border border-slate-800">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <div class="w-full md:w-2/3 bg-black rounded-2xl overflow-hidden aspect-video relative flex items-center justify-center border-2 border-slate-700 shadow-inner" id="pastorVideoBox">
                    <video id="localVideo" autoplay playsinline muted class="w-full h-full object-cover hidden"></video>
                    
                    <div id="videoPlaceholder" class="text-center p-6">
                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center text-secondary text-2xl mx-auto mb-3">
                            <i class="fas fa-video-slash"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-300 mb-1">የቀጥታ ስርጭት ስክሪን (Live Screen)</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">ካሜራዎንና ማይክሮፎንዎን ከፍተው ለምዕመናን በቀጥታ ፊት ለፊት ያስተምሩ እና ይጸልዩ።</p>
                    </div>

                    <button onclick="togglePastorFullscreen()" class="absolute top-4 right-4 bg-black/60 hover:bg-black/80 text-white text-xs px-3 py-1.5 rounded-xl border border-white/20 flex items-center space-x-1.5 transition z-20 backdrop-blur">
                        <i class="fas fa-expand text-amber-400" id="pastorFsIcon"></i>
                        <span id="pastorFsText">ሙሉ ስክሪን</span>
                    </button>

                    <div id="liveBadge" class="absolute top-4 left-4 bg-rose-600 text-white text-[11px] font-black uppercase px-3 py-1 rounded-full hidden items-center space-x-1 animate-pulse z-20">
                        <span class="w-2 h-2 rounded-full bg-white"></span>
                        <span>🔴 በቀጥታ ስርጭት ላይ (LIVE)</span>
                    </div>
                </div>

                <div class="w-full md:w-1/3 flex flex-col justify-between space-y-4">
                    <div>
                        <span class="text-xs font-bold text-amber-400 uppercase tracking-wider block mb-1">ቀጥታ አገልግሎት</span>
                        <h3 class="text-xl font-black mb-2">የቪዲዮና ድምፅ ስርጭት ይጀምሩ</h3>
                        <p class="text-xs text-slate-400 leading-relaxed mb-6">
                            አዝራሩን ሲጫኑ ካሜራዎ ይከፈታል፤ ምዕመናን በስልካቸውና በኮምፒውተራቸው በቀጥታ ፊት ለፊት ያዩዎታል።
                        </p>
                    </div>

                    <button id="startLiveBtn" onclick="toggleCamera()" class="w-full py-3.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg transition flex items-center justify-center space-x-2">
                        <i class="fas fa-video"></i>
                        <span id="btnText">ካሜራና ማይክሮፎን ክፈት (Start Live)</span>
                    </button>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- SECTION 2: FROM GALLERY UPLOAD -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-200">
                <h3 class="text-lg font-black text-gray-900 mb-1 flex items-center space-x-2">
                    <i class="fas fa-photo-video text-secondary"></i>
                    <span>ከጋለሪ ይጫኑ ወይም በጽሁፍ ያስተምሩ</span>
                </h3>
                <p class="text-xs text-gray-500 mb-6">ቪዲዮ፣ ኦዲዮ ከስልክዎ/ኮምፒውተርዎ ይምረጡ ወይም ጥናት ያዘጋጁ</p>

                <form action="/pastor-desk/{{ $pastor->id }}/upload-content" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የትምህርቱ ርዕስ *</label>
                        <input type="text" name="title" required placeholder="ለምሳሌ፡ የጠዋት ፀሎት" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የይዘቱ ዓይነት *</label>
                        <select name="content_type" id="contentTypeSelect" onchange="toggleUploadType()" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                            <option value="video">ቪዲዮ ከጋለሪ (Video from Gallery)</option>
                            <option value="audio">ኦዲዮ/ድምፅ ከጋለሪ (Audio File)</option>
                            <option value="article">የጽሁፍ ትምህርት / ጥናት (Article / Text)</option>
                        </select>
                    </div>

                    <div id="fileUploadBox">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ፋይሉን ከጋለሪ ይምረጡ *</label>
                        <input type="file" name="media_file" accept="video/*,audio/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 border border-gray-300 rounded-xl p-2">
                    </div>

                    <div id="articleBox" class="hidden">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የትምህርቱ ጽሁፍ / ጥናት *</label>
                        <textarea name="article_body" rows="6" placeholder="የእግዚአብሔርን ቃል እዚህ ይጻፉ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-primary hover:bg-blue-900 text-white font-bold rounded-xl shadow transition">
                        ይዘቱን አትም (Publish)
                    </button>
                </form>
            </div>

            <!-- SECTION 3: TWO-WAY VOICE & TEXT COMMUNICATION -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-black text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-comments text-primary"></i>
                            <span>የሁለትዮሽ ጥያቄና መልስ (ድምፅ + ጽሁፍ)</span>
                        </h3>
                        <span class="text-xs font-bold bg-amber-50 text-secondary px-3 py-1 rounded-full border border-amber-200">
                            {{ count($messages) }} ጥያቄዎች
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mb-6">ከምዕመናን የቀረቡትን በድምፅ ወይም በጽሁፍ ያዳምጡ፤ መልስ ይስጡ</p>

                    <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                        @forelse($messages as $msg)
                            <div class="bg-slate-50 p-4 rounded-2xl border border-gray-100">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-primary">{{ $msg->subject }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $msg->created_at }}</span>
                                </div>

                                <div class="mb-3 bg-white p-3 rounded-xl border border-gray-100">
                                    @if(str_starts_with($msg->message, 'AUDIO_VOICE:'))
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-microphone text-rose-500"></i>
                                            <span class="text-xs font-bold text-gray-700">የምዕመኑ የድምፅ መልእክት፡</span>
                                        </div>
                                        <audio controls class="w-full mt-2 h-8">
                                            <source src="{{ str_replace('AUDIO_VOICE:', '', $msg->message) }}" type="audio/webm">
                                        </audio>
                                    @else
                                        <p class="text-xs text-gray-700">{{ $msg->message }}</p>
                                    @endif
                                </div>

                                @if($msg->reply)
                                    <div class="bg-blue-50 p-3 rounded-xl text-xs text-primary mb-3">
                                        <span class="font-bold block text-[10px] mb-1">የእርስዎ መልስ፡</span>
                                        @if(str_starts_with($msg->reply, 'AUDIO_VOICE:'))
                                            <audio controls class="w-full h-8">
                                                <source src="{{ str_replace('AUDIO_VOICE:', '', $msg->reply) }}" type="audio/webm">
                                            </audio>
                                        @else
                                            {{ $msg->reply }}
                                        @endif
                                    </div>
                                @endif

                                <form action="/pastor-desk/{{ $pastor->id }}/reply" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="message_id" value="{{ $msg->id }}">
                                    <input type="text" name="reply" placeholder="የምክር መልስዎን እዚህ ይጻፉ..." class="flex-1 text-xs px-3 py-2 rounded-xl border border-gray-300 outline-none">
                                    <button type="submit" class="px-4 py-2 bg-secondary text-white text-xs font-bold rounded-xl hover:bg-amber-600 transition">ላክ</button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-12 text-gray-400">
                                <p class="text-xs">እስካሁን ምንም ጥያቄ አልቀረበም።</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- 🌟 Footer with Mela Solution Branding -->
    <footer class="bg-white border-t border-gray-200 py-6 px-4 mt-12">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
            <span class="text-xs text-gray-500">Wengel for World — የአገልጋዮች የስራ ማዕከል</span>
            <div class="text-xs text-gray-600 font-medium">
                የሲስተም አጋር፡ <span class="text-primary font-black">Mela Solution</span> | 
                <span class="font-mono font-bold text-gray-800">📞 0913064239 / 0703064239</span>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        const pastorRoomId = "wengel-live-pastor-{{ $pastor->id }}";
        let peer = null;
        let localStream = null;
        let isStreaming = false;

        async function toggleCamera() {
            const video = document.getElementById('localVideo');
            const placeholder = document.getElementById('videoPlaceholder');
            const badge = document.getElementById('liveBadge');
            const btnText = document.getElementById('btnText');

            if (!isStreaming) {
                try {
                    localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                    video.srcObject = localStream;
                    video.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    badge.classList.remove('hidden');
                    badge.classList.add('flex');
                    btnText.innerText = "ስርጭቱን አቁም (Stop Live)";
                    isStreaming = true;

                    // PeerJS ስርጭት መክፈት
                    if (peer) peer.destroy();
                    peer = new Peer(pastorRoomId);

                    peer.on('call', (call) => {
                        call.answer(localStream);
                    });

                } catch (err) {
                    alert("ካሜራውን መክፈት አልተቻለም: እባክዎ ፈቃድ ይስጡ።");
                }
            } else {
                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                }
                if (peer) {
                    peer.destroy();
                }
                video.classList.add('hidden');
                placeholder.classList.remove('hidden');
                badge.classList.add('hidden');
                badge.classList.remove('flex');
                btnText.innerText = "ካሜራና ማይክሮፎን ክፈት (Start Live)";
                isStreaming = false;
            }
        }

        function togglePastorFullscreen() {
            const videoBox = document.getElementById('pastorVideoBox');
            const fsText = document.getElementById('pastorFsText');
            const fsIcon = document.getElementById('pastorFsIcon');

            if (!document.fullscreenElement) {
                if (videoBox.requestFullscreen) {
                    videoBox.requestFullscreen();
                }
                fsText.innerText = "አሳንስ";
                fsIcon.className = "fas fa-compress text-amber-400";
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                fsText.innerText = "ሙሉ ስክሪን";
                fsIcon.className = "fas fa-expand text-amber-400";
            }
        }

        function copyLink() {
            navigator.clipboard.writeText("https://wengel-for-world.vercel.app/p/{{ $pastor->email }}").then(() => {
                document.getElementById('copyBtnText').innerText = "ኮፒ ተደርጓል! ✓";
                setTimeout(() => { document.getElementById('copyBtnText').innerText = "ሊንኩን ኮፒ አድርግ"; }, 3000);
            });
        }

        function toggleUploadType() {
            const type = document.getElementById('contentTypeSelect').value;
            const fileBox = document.getElementById('fileUploadBox');
            const articleBox = document.getElementById('articleBox');
            if (type === 'article') {
                fileBox.classList.add('hidden');
                articleBox.classList.remove('hidden');
            } else {
                fileBox.classList.remove('hidden');
                articleBox.classList.add('hidden');
            }
        }
    </script>
</body>
</html>

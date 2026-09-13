<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pastor->name }} | የአገልጋይ ዳሽቦርድ</title>
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
<body class="bg-slate-100 text-gray-800 font-sans min-h-screen">

    <!-- Topbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center font-black">
                    <i class="fas fa-cross"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-gray-900 text-sm sm:text-base leading-tight">{{ $pastor->name }}</h1>
                    <span class="text-xs text-secondary font-bold">{{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልግሎት' }}</span>
                </div>
            </div>

            <!-- Public Link Button -->
            <div class="flex items-center space-x-2">
                <a href="/p/{{ $pastor->email }}" target="_blank" class="px-3.5 py-1.5 bg-blue-50 text-primary hover:bg-blue-100 text-xs font-bold rounded-xl border border-blue-200 transition flex items-center space-x-1.5">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    <span>የእርስዎን ፖርታል ይመልከቱ</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        <!-- Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-800 flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Portal Link Sharing Box -->
        <div class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white rounded-2xl p-6 mb-8 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xs text-amber-300 font-bold uppercase tracking-wider block mb-1">ለምዕመናን የሚያጋሩት የእርስዎ ቋሚ ሊንክ</span>
                <p class="text-sm text-blue-100">ይህንን ሊንክ በ Telegram፣ Facebook ወይም YouTube በማጋራት ተከታዮችዎን ያስተምሩ እና ምክር ይስጡ።</p>
            </div>
            <div class="flex items-center bg-white/10 backdrop-blur border border-white/20 px-3.5 py-2 rounded-xl text-xs font-mono">
                <span class="text-amber-200 mr-2">https://wengel-for-world.vercel.app/p/{{ $pastor->email }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Content Upload Form (Audio, Video, LIVE) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-base font-extrabold text-gray-900 mb-1 flex items-center space-x-2">
                        <i class="fas fa-cloud-upload-alt text-secondary"></i>
                        <span>አዲስ ይዘት ወይም LIVE ይልቀቁ</span>
                    </h3>
                    <p class="text-xs text-gray-500 mb-6">ለምዕመናን የሚደርስ ኦዲዮ፣ ቪዲዮ ወይም የቀጥታ ስርጭት</p>

                    <form action="/pastor-desk/{{ $pastor->id }}/upload-content" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የትምህርቱ / የስርጭቱ ርዕስ *</label>
                            <input type="text" name="title" required placeholder="ምሳሌ፡ የዕለት ቃል / የፀሎት ጊዜ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የይዘቱ ዓይነት *</label>
                            <select name="type" required class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                <option value="video">ቪዲዮ ስብከት (Video Sermon)</option>
                                <option value="audio">የድምፅ ትምህርት (Audio MP3)</option>
                                <option value="live">🔴 የቀጥታ ስርጭት (LIVE Stream)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የሊንኩ አድራሻ (Media / Live URL) *</label>
                            <input type="url" name="media_url" required placeholder="https://youtube.com/... ወይም የድምፅ ሊንክ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            <span class="text-[10px] text-gray-400 mt-1 block">የ YouTube ቪዲዮ፣ የፌስቡክ ሊንክ ወይም የኦዲዮ ፋይል አድራሻ</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">አጭር ማብራሪያ (አማራጭ)</label>
                            <textarea name="content" rows="3" placeholder="የትምህርቱ ማጠቃለያ ወይም የመጽሐፍ ቅዱስ ጥቅስ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3 bg-primary hover:bg-blue-900 text-white font-bold rounded-xl shadow transition flex items-center justify-center space-x-2">
                            <i class="fas fa-paper-plane text-xs"></i>
                            <span>ወዲያውኑ ልቀቅ</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Two-Way Communication (Counseling Inbox & Replies) -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="flex items-center justify-between">
                    <h3 class="font-extrabold text-gray-900 text-lg flex items-center space-x-2">
                        <i class="fas fa-inbox text-primary"></i>
                        <span>ከምዕመናን የቀረቡ የምክር ጥያቄዎች (Inbox)</span>
                    </h3>
                    <span class="text-xs font-bold bg-amber-100 text-amber-800 px-3 py-1 rounded-full">
                        {{ count($messages) }} መልዕክቶች
                    </span>
                </div>

                @forelse($messages as $msg)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-start justify-between border-b border-gray-100 pb-3 mb-3">
                            <div>
                                <span class="text-xs font-bold text-primary block">{{ $msg->subject }}</span>
                                <span class="text-[11px] text-gray-400">{{ $msg->created_at }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $msg->status == 'answered' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                {{ $msg->status == 'answered' ? '✓ መልስ ተሰጥቷል' : '● አዲስ ጥያቄ' }}
                            </span>
                        </div>

                        <!-- Believer's Message -->
                        <div class="bg-slate-50 p-4 rounded-xl text-sm text-gray-700 leading-relaxed mb-4 whitespace-pre-line">
                            {{ $msg->message }}
                        </div>

                        <!-- Previous Reply if exists -->
                        @if($msg->reply)
                            <div class="bg-blue-50/60 border-l-4 border-primary p-4 rounded-r-xl mb-4">
                                <span class="text-xs font-bold text-primary block mb-1">የእርስዎ መልስ:</span>
                                <p class="text-xs text-gray-700 leading-relaxed">{{ $msg->reply }}</p>
                            </div>
                        @endif

                        <!-- Reply Form -->
                        <form action="/pastor-desk/{{ $pastor->id }}/reply" method="POST" class="pt-2">
                            @csrf
                            <input type="hidden" name="message_id" value="{{ $msg->id }}">
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" name="reply" required placeholder="የምክር መልስዎን እዚህ ይጻፉ..." class="flex-1 text-xs px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                <button type="submit" class="px-4 py-2.5 bg-secondary hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow transition whitespace-nowrap">
                                    መልስ ላክ
                                </button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-200">
                        <i class="fas fa-envelope-open text-gray-300 text-4xl mb-3"></i>
                        <h4 class="font-bold text-gray-700 mb-1">እስካሁን የቀረበ የምክር ጥያቄ የለም</h4>
                        <p class="text-xs text-gray-500">ምዕመናን የእርስዎን ሊንክ ተጠቅመው ጥያቄ ሲልኩ እዚህ ይደርስዎታል።</p>
                    </div>
                @endforelse

            </div>

        </div>
    </main>

</body>
</html>

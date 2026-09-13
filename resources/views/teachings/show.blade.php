<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $teaching->title }} | Wengel for World</title>
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
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center font-black">W</div>
                <span class="font-extrabold text-primary tracking-wide">WENGEL <span class="text-secondary">FOR WORLD</span></span>
            </a>
            <a href="/teachings" class="text-primary font-bold text-sm flex items-center space-x-1 hover:underline">
                <i class="fas fa-chevron-left text-xs"></i>
                <span>ወደ ትምህርቶች ተመለስ</span>
            </a>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-4xl mx-auto px-4 py-10 w-full flex-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- Media Player Section -->
            <div class="bg-slate-900 p-6 sm:p-10 text-white flex flex-col items-center justify-center">
                @if($teaching->type == 'audio')
                    <div class="w-20 h-20 bg-amber-500/20 text-secondary rounded-full flex items-center justify-center text-3xl mb-6 shadow-inner animate-pulse">
                        <i class="fas fa-headphones"></i>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-center mb-6 max-w-xl">{{ $teaching->title }}</h2>
                    <!-- HTML5 Audio Player -->
                    <audio controls class="w-full max-w-md shadow-lg rounded-full">
                        <source src="{{ $teaching->media_url }}" type="audio/mpeg">
                        ብሮውዘርዎ ኦዲዮ ማጫወት አልደገፈም።
                    </audio>
                @elseif($teaching->type == 'video')
                    <div class="w-full aspect-video rounded-2xl overflow-hidden shadow-2xl border border-slate-700">
                        <iframe class="w-full h-full" src="{{ $teaching->media_url }}" title="{{ $teaching->title }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endif
            </div>

            <!-- Content & Pastor Details -->
            <div class="p-6 sm:p-10">
                <div class="flex flex-wrap items-center justify-between border-b border-gray-100 pb-6 mb-6 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-primary flex items-center justify-center text-lg font-bold">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $teaching->pastor->name ?? 'አገልጋይ' }}</h4>
                            <p class="text-xs text-secondary font-semibold">{{ $teaching->pastor->pastorProfile->church_name ?? 'የወንጌል አገልጋይ' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 text-xs text-gray-400">
                        <span><i class="fas fa-eye mr-1"></i> {{ $teaching->views_count }} ተመልክተውታል</span>
                        <span><i class="fas fa-calendar mr-1"></i> ዛሬ</span>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">የትምህርቱ ማጠቃለያ</h3>
                    <p class="text-base whitespace-pre-line">{{ $teaching->content }}</p>
                </div>

                <!-- Call to action: የምክር ጥያቄ -->
                <div class="mt-10 p-6 bg-blue-50/60 rounded-2xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h5 class="font-bold text-primary text-sm">ስለዚህ ትምህርት ተጨማሪ ጥያቄ ወይም ምክር ይፈልጋሉ?</h5>
                        <p class="text-xs text-gray-500 mt-0.5">ለአገልጋዩ በቀጥታ ሚስጥራዊ ጥያቄ ማቅረብ ይችላሉ።</p>
                    </div>
                    <a href="/pastors/{{ $teaching->pastor_id }}" class="px-5 py-2.5 bg-primary text-white text-xs font-bold rounded-xl shadow hover:bg-blue-900 transition whitespace-nowrap">
                        ምክር ጠይቅ
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500">
        &copy; 2024 Wengel for World. Powered by Mela Solution.
    </footer>

</body>
</html>

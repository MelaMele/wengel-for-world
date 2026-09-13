<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pastor->name }} | Wengel for World</title>
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
            <div class="flex items-center space-x-4 text-sm font-medium">
                <a href="/pastors" class="text-primary font-bold flex items-center space-x-1">
                    <i class="fas fa-chevron-left text-xs"></i>
                    <span>ወደ አገልጋዮች ተመለስ</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-5xl mx-auto px-4 py-10 w-full flex-1">
        
        <!-- Alert -->
        @if(session('counseling_success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-800 flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-2xl"></i>
                <div>
                    <h4 class="font-bold">መልእክትዎ ደርሷል!</h4>
                    <p class="text-sm">{{ session('counseling_success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Pastor Profile Info -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 text-center sticky top-24">
                    <div class="w-28 h-28 mx-auto mb-4 rounded-full bg-blue-100 border-4 border-blue-50 text-primary text-4xl flex items-center justify-center shadow-inner">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $pastor->name }}</h2>
                    <span class="text-xs font-semibold px-3 py-1 bg-amber-50 text-secondary border border-amber-200 rounded-full inline-block mb-4">
                        {{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልጋይ' }}
                    </span>
                    <p class="text-xs text-gray-600 leading-relaxed text-justify mb-6">
                        {{ $pastor->pastorProfile->bio ?? 'በክርስቶስ ፍቅር ሕዝቡን ለማገልገል፣ ለማስተማር እና በህይወት ፈተናዎች ውስጥ በመንፈሳዊ ምክር ለማበረታት የተዘጋጁ አገልጋይ።' }}
                    </p>

                    <div class="border-t border-gray-100 pt-4 text-left">
                        <div class="flex items-center space-x-2 text-xs text-gray-500 mb-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>የተረጋገጠ አገልጋይ (Verified)</span>
                        </div>
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            <i class="fas fa-shield-alt text-primary"></i>
                            <span>ሚስጥራዊ የምክር መስመር</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Counseling Box Form -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-200">
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <span class="text-xs font-bold text-secondary uppercase tracking-widest block mb-1">ሚስጥራዊ ግንኙነት</span>
                        <h3 class="text-2xl font-extrabold text-gray-900">ለ {{ $pastor->name }} ጥያቄ ወይም ምክር ይላኩ</h3>
                        <p class="text-xs text-gray-500 mt-1">የሚልኩት መልእክት በፓስተሩ ብቻ በጥብቅ ሚስጥር የሚታይ ይሆናል</p>
                    </div>

                    <form action="/pastors/{{ $pastor->id }}/counseling" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ስምዎ *</label>
                                <input type="text" name="sender_name" required placeholder="ሙሉ ስምዎ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ስልክ ቁጥር ወይም ኢሜይል *</label>
                                <input type="text" name="sender_phone_or_email" required placeholder="መልስ የሚቀበሉበት አድራሻ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የጉዳዩ ርዕስ *</label>
                            <input type="text" name="subject" required placeholder="ለምሳሌ፡ ስለ ትዳር ምክር፣ ስለ መንፈሳዊ ድካም..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የምክር ጥያቄዎ ዝርዝር *</label>
                            <textarea name="message" rows="6" required placeholder="የሚያስጨንቅዎትን ጉዳይ ወይም የፈለጉትን መንፈሳዊ ምክር በነፃነት ይጻፉ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"></textarea>
                        </div>

                        <div class="bg-amber-50 rounded-xl p-4 flex items-start space-x-3 text-amber-800 text-xs">
                            <i class="fas fa-lock text-secondary text-sm mt-0.5"></i>
                            <p>የእርስዎ መረጃ እና የሚልኩት መልእክት ሙሉ በሙሉ ሚስጥራዊ ነው። ለሌላ ለማንኛውም ሶስተኛ ወገን አይጋራም።</p>
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-primary hover:bg-blue-900 text-white font-bold rounded-xl shadow-md transition flex items-center justify-center space-x-2">
                            <i class="fas fa-paper-plane text-xs"></i>
                            <span>ሚስጥራዊ መልእክቱን ላክ</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500">
        &copy; 2024 Wengel for World. Developed by Mela Solution.
    </footer>

</body>
</html>

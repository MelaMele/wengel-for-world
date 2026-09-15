<!DOCTYPE html>
<html lang="am" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wengel for World | ወንጌል ለዓለም</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A', // Deep spiritual blue
                        secondary: '#D97706', // Warm gospel gold
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col justify-between min-h-screen">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20">
            <a href="/" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center font-black text-xl shadow-md">
                    W
                </div>
                <div>
                    <span class="text-xl font-black tracking-tight text-primary block leading-none">WENGEL</span>
                    <span class="text-xs font-semibold text-secondary tracking-widest uppercase">FOR WORLD</span>
                </div>
            </a>

            <nav class="hidden md:flex space-x-8 font-medium text-gray-600 text-sm">
                <a href="/" class="text-primary font-bold">መነሻ</a>
                <a href="/teachings" class="hover:text-primary transition">ትምህርቶች</a>
                <a href="/prayer-requests" class="text-secondary hover:text-amber-600 font-bold transition flex items-center space-x-1">
                    <i class="fas fa-praying-hands text-xs"></i>
                    <span>የፀሎት ጥያቄ</span>
                </a>
                <a href="#services" class="hover:text-primary transition">አገልግሎቶች</a>
                <a href="#about" class="hover:text-primary transition">ስለ እኛ</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="/prayer-requests" class="px-5 py-2.5 text-xs font-bold text-white bg-secondary hover:bg-amber-600 rounded-xl shadow-md transition flex items-center space-x-2">
                    <i class="fas fa-paper-plane text-[10px]"></i>
                    <span>ፀሎት ጠይቅ</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-950 via-primary to-slate-900 text-white py-24 px-4 overflow-hidden">
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <span class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide uppercase bg-blue-800/80 text-amber-300 border border-blue-700 mb-6 inline-block shadow-sm">
                የሕይወት ቃል ለዓለም ሁሉ
            </span>
            <h1 class="text-4xl sm:text-6xl font-extrabold leading-tight mb-6">
                የእግዚአብሔር ቃል በየትኛውም ስፍራ፣ በየትኛውም ሰዓት።
            </h1>
            <p class="text-base sm:text-xl text-blue-100 max-w-3xl mx-auto mb-10 leading-relaxed">
                በአገር ውስጥም ሆነ በውጭ የምትገኙ ምዕመናን ከታመኑ አገልጋዮች ጋር የምትገናኙበት፣ የቀጥታ ስርጭት የምትከታተሉበት፣ በድምፅና በጽሁፍ ምክር የምታገኙበት ዲጂታል የወንጌል መድረክ።
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="/teachings" class="w-full sm:w-auto px-8 py-4 bg-secondary text-white font-bold rounded-xl shadow-lg hover:bg-amber-600 transition flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-play-circle"></i>
                    <span>ትምህርቶችን ተከታተል</span>
                </a>
                <a href="/prayer-requests" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl backdrop-blur border border-white/20 transition flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-praying-hands"></i>
                    <span>የፀሎት ጥያቄ አቅርብ</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Core Services Overview -->
    <section id="services" class="py-20 px-4 max-w-7xl mx-auto w-full">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">የመድረኩ ዋና ዋና አገልግሎቶች</h2>
            <p class="mt-4 text-base text-gray-600">ምዕመናንን በመንፈሳዊ ህይወት ለማነጽ የተዘጋጁ ዘመናዊ አገልግሎቶች</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-blue-100 text-primary rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">የቀጥታ ስርጭት (Live Stream)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    ከፓስተሮች ጋር በቀጥታ በቪዲዮና በድምፅ እየተያዩ የሚማሩበትና አብረው የሚጸልዩበት ዓለም አቀፍ መድረክ።
                </p>
            </div>

            <!-- Service 2 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-amber-100 text-secondary rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                    <i class="fas fa-microphone-alt"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">የሁለትዮሽ ሚስጥራዊ ምክር</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    የሕይወትና የእምነት ጥያቄዎችዎን በድምፅ ወይም በጽሁፍ ለፓስተሩ በምስጢር ልከው የእግዚአብሔርን ቃል መልስ ያግኙ።
                </p>
            </div>

            <!-- Service 3 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">አስራትና ስጦታ (Giving)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    ከሀገር ውስጥ በቴሌብር፣ በሲቢኢ እንዲሁም ከውጭ ሀገር በካርድ ለአገልግሎት አስራትና ስጦታዎን በቀላሉ ይላኩ።
                </p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-blue-50/50 py-16 px-4 border-t border-gray-200 w-full">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl font-black text-gray-900 mb-4">ስለ "ወንጌል ለዓለም" (Wengel for World)</h2>
            <p class="text-gray-600 leading-relaxed text-sm sm:text-base mb-8">
                ይህ ፕላትፎርም በዓለም ዙሪያ ለሚገኙ ምዕመናን የእግዚአብሔርን ቃል ለማድረስ፣ ታማኝ አገልጋዮችን ከተከታዮቻቸው ጋር ለማስተሳሰር እና በመንፈሳዊ ምክርና ፀሎት ሰዎችን ለመደገፍ በ Mela Solution የተገነባ ዘመናዊ የወንጌል መድረክ ነው።
            </p>
            <div class="inline-flex items-center space-x-2 text-xs font-medium text-gray-600 bg-white px-5 py-2.5 rounded-full border border-gray-200 shadow-sm">
                <i class="fas fa-shield-alt text-primary text-sm"></i>
                <span>ሚስጥራዊነቱ እና ደህንነቱ 100% የተጠበቀ መድረክ</span>
            </div>
        </div>
    </section>

    <!-- 🌟 Footer with Mela Solution Branding -->
    <footer class="bg-slate-900 text-gray-400 py-12 px-4 border-t border-slate-800 w-full">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div>
                <h4 class="text-white font-extrabold text-xl tracking-wide">WENGEL FOR WORLD</h4>
                <p class="text-xs text-slate-400 mt-1">የወንጌል ቴክኖሎጂ መፍትሔ — ዓለም አቀፍ የመንፈሳዊ አገልግሎት መድረክ</p>
            </div>
            
            <div class="flex flex-col md:items-end text-xs">
                <span class="text-slate-300 font-bold">Developed & Maintained by <span class="text-amber-400 font-black">Mela Solution</span></span>
                <span class="text-slate-400 mt-1.5 flex items-center justify-center md:justify-end space-x-2">
                    <i class="fas fa-phone-alt text-amber-400 text-xs"></i>
                    <span class="font-mono text-white font-black text-sm">0913064239 / 0703064239</span>
                </span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-8 pt-6 border-t border-slate-800 text-center text-xs text-slate-500">
            &copy; 2024 Wengel for World. መብቱ በህግ የተጠበቀ ነው።
        </div>
    </footer>

</body>
</html>

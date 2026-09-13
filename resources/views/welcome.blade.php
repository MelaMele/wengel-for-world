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
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-md">
                    W
                </div>
                <div>
                    <span class="text-xl font-black tracking-tight text-primary block leading-none">WENGEL</span>
                    <span class="text-xs font-semibold text-secondary tracking-widest uppercase">FOR WORLD</span>
                </div>
            </div>

            <nav class="hidden md:flex space-x-8 font-medium text-gray-600">
                <a href="#" class="text-primary font-bold">መነሻ</a>
                <a href="#pastors" class="hover:text-primary transition">አገልጋዮች</a>
                <a href="#teachings" class="hover:text-primary transition">ትምህርቶች</a>
                <a href="#prayer" class="hover:text-primary transition">የፀሎት ጥያቄ</a>
                <a href="#about" class="hover:text-primary transition">ስለ እኛ</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="#" class="px-4 py-2 text-sm font-semibold text-primary hover:bg-blue-50 rounded-lg transition">ግባ / Sign In</a>
                <a href="#" class="px-4 py-2 text-sm font-semibold text-white bg-secondary hover:bg-amber-600 rounded-lg shadow transition">ተቀላቀል</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-900 via-primary to-slate-900 text-white py-24 px-4 overflow-hidden">
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <span class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide uppercase bg-blue-800/80 text-amber-300 border border-blue-700 mb-6 inline-block">
                የሕይወት ቃል ለዓለም ሁሉ
            </span>
            <h1 class="text-4xl sm:text-6xl font-extrabold leading-tight mb-6">
                የእግዚአብሔር ቃል በየትኛውም ስፍራ፣ በየትኛውም ሰዓት።
            </h1>
            <p class="text-lg sm:text-xl text-blue-100 max-w-3xl mx-auto mb-10 leading-relaxed">
                በአገር ውስጥም ሆነ በውጭ የምትገኙ ምዕመናን ከታመኑ አገልጋዮች ጋር የምትገናኙበት፣ የምትማሩበት፣ ምክርና ፀሎት የምታገኙበት ዲጂታል መንፈሳዊ መድረክ።
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="#teachings" class="w-full sm:w-auto px-8 py-4 bg-secondary text-white font-bold rounded-xl shadow-lg hover:bg-amber-600 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-play-circle"></i>
                    <span>ትምህርቶችን አዳምጥ</span>
                </a>
                <a href="#pastors" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl backdrop-blur border border-white/20 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-user-shield"></i>
                    <span>አገልጋዮችን ተመልከት</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Core Services Overview -->
    <section class="py-20 px-4 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">የመድረኩ ዋና ዋና አገልግሎቶች</h2>
            <p class="mt-4 text-lg text-gray-600">ምዕመናንን በመንፈሳዊ ህይወት ለማነጽ የተዘጋጁ አገልግሎቶች</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-blue-100 text-primary rounded-xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-bible"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">የተከታታይ ትምህርቶች</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    ከፓስተሮች የተዘጋጁ የድምፅ፣ የቪዲዮ እና የጽሁፍ ትምህርቶችን በቀላሉ በማንኛውም ሰዓት ያግኙ።
                </p>
            </div>

            <!-- Service 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-amber-100 text-secondary rounded-xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-comments"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">የግል መንፈሳዊ ምክር</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    የሕይወትና የእምነት ጥያቄዎችዎን በሚስጥራዊነት ለፓስተሮች አቅርበው መጽሐፍ ቅዱሳዊ መልስ ያግኙ።
                </p>
            </div>

            <!-- Service 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-praying-hands"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">የፀሎት ጥያቄ መስመር</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    የፀሎት ፍላጎትዎን በስም ወይም ማንነትዎን ሳይገልጹ (Anonymous) ለፀሎት አገልጋዮች ያጋሩ።
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-gray-400 py-12 px-4 border-t border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h4 class="text-white font-bold text-lg">Wengel for World</h4>
                <p class="text-sm mt-1">የወንጌል ቴክኖሎጂ መፍትሔ — Developed by Mela Solution</p>
            </div>
            <div class="text-sm">
                &copy; 2024 Wengel for World. መብቱ በህግ የተጠበቀ ነው።
            </div>
        </div>
    </footer>

</body>
</html>

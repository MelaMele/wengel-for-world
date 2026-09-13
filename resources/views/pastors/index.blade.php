<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>አገልጋዮች | Wengel for World</title>
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
            <div class="flex items-center space-x-5 text-sm font-medium">
                <a href="/" class="text-gray-600 hover:text-primary transition">መነሻ ገጽ</a>
                <a href="/pastors" class="text-primary font-bold">አገልጋዮች</a>
                <a href="/prayer-requests" class="text-gray-600 hover:text-primary transition">የፀሎት ጥያቄዎች</a>
            </div>
        </div>
    </header>

    <!-- Banner -->
    <section class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white py-12 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">የወንጌል አገልጋዮች</h1>
            <p class="text-blue-200 text-sm sm:text-base">
                ከእግዚአብሔር ቃል የሚያስተምሩዎትንና በፀሎት የሚያግዙዎትን ታማኝ አገልጋዮች ይምረጡ
            </p>
        </div>
    </section>

    <!-- Pastors Grid -->
    <main class="max-w-6xl mx-auto px-4 py-12 w-full flex-1">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @forelse($pastors as $pastor)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col justify-between">
                    <div class="p-6 text-center">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-blue-100 border-4 border-white shadow-md flex items-center justify-center text-primary text-3xl font-bold">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $pastor->name }}</h3>
                        <p class="text-xs font-semibold text-secondary uppercase tracking-wider mb-3">
                            {{ $pastor->pastorProfile->church_name ?? 'የክርስቶስ ወንጌል አገልግሎት' }}
                        </p>
                        <p class="text-gray-500 text-xs line-clamp-3 leading-relaxed">
                            {{ $pastor->pastorProfile->bio ?? 'የእግዚአብሔርን ቃል ለሕዝቡ ለማድረስ እና በፀሎት ለመደገፍ የተጠሩ አገልጋይ።' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <a href="/pastors/{{ $pastor->id }}" class="w-full text-center py-2.5 bg-primary hover:bg-blue-900 text-white text-xs font-bold rounded-xl shadow transition flex items-center justify-center space-x-2">
                            <span>ፕሮፋይልና ምክር ጠይቅ</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <!-- Demo Card (ፓስተሮች እስኪገቡ ድረስ የሚታይ) -->
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-church"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">አገልጋዮች በምዝገባ ላይ ናቸው</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">
                        የተለያዩ የወንጌል ፓስተሮችና አገልጋዮች ወደ መድረኩ በመቀላቀል ላይ ናቸው። በቅርቡ እዚህ ይገኛሉ!
                    </p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500">
        &copy; 2024 Wengel for World. Developed by Mela Solution.
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>አገልግሎቱ ለጊዜው ቆሟል</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4 font-sans text-center">
    <div class="bg-white max-w-md w-full p-8 rounded-3xl shadow-md border border-gray-200">
        <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
            ⚠️
        </div>
        <h2 class="text-xl font-bold text-gray-900 mb-2">ይህ አገልግሎት ለጊዜው ቆሟል</h2>
        <p class="text-xs text-gray-500 leading-relaxed mb-6">
            የ{{ $pastor->name }} ፖርታል ለጊዜው ከአገልግሎት ውጪ ሆኗል። እባክዎ ከጥቂት ጊዜ በኋላ እንደገና ይሞክሩ።
        </p>
        <a href="/" class="text-xs font-bold text-blue-900 bg-blue-50 px-4 py-2 rounded-xl">ወደ ዋናው ገጽ ተመለስ</a>
    </div>
</body>
</html>

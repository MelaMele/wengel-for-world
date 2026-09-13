<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ወደ {{ $pastor->name }} አገልግሎት እንኳን ደህና መጡ</title>
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
<body class="bg-gradient-to-br from-slate-900 via-primary to-blue-950 min-h-screen flex items-center justify-center p-4 font-sans text-gray-800">

    <div class="bg-white max-w-md w-full rounded-3xl shadow-2xl overflow-hidden border border-white/20">
        
        <!-- Pastor Header Header -->
        <div class="bg-slate-900 text-white p-8 text-center relative overflow-hidden">
            <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-blue-100 text-primary border-4 border-white/20 flex items-center justify-center text-3xl shadow-lg">
                <i class="fas fa-user-tie"></i>
            </div>
            <h2 class="text-xl font-black mb-1">{{ $pastor->name }}</h2>
            <span class="text-xs font-bold text-secondary uppercase tracking-wider bg-amber-400/10 px-3 py-1 rounded-full border border-amber-400/20 inline-block">
                {{ $pastor->pastorProfile->church_name ?? 'የወንጌል አገልግሎት' }}
            </span>
            <p class="text-xs text-blue-200 mt-3 max-w-xs mx-auto leading-relaxed">
                ትምህርቶችን ለመከታተል፣ የቀጥታ ስርጭት ለማየትና ከፓስተሩ ጋር በግል ለመወያየት ስምዎን ያስገቡ።
            </p>
        </div>

        <!-- Login / Join Form -->
        <div class="p-8">
            <form action="/p/{{ $pastor->email }}/believer-login" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ሙሉ ስምዎ *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <i class="fas fa-user text-xs"></i>
                        </span>
                        <input type="text" name="name" required placeholder="ለምሳሌ፡ ዮሐንስ አበበ" class="w-full text-sm pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ስልክ ቁጥርዎ *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <i class="fas fa-phone text-xs"></i>
                        </span>
                        <input type="tel" name="phone" required placeholder="09... ወይም +251..." class="w-full text-sm pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">የእርስዎ የቻት ታሪክ በዚህ ቁጥር ሚስጥራዊነቱ ተጠብቆ ይቀመጣል።</span>
                </div>

                <button type="submit" class="w-full py-3.5 bg-secondary hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg transition flex items-center justify-center space-x-2 mt-2">
                    <span>ወደ አገልግሎቱ ግባ</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="mt-6 text-center">
                <span class="text-[11px] text-gray-400 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-emerald-500 mr-1"></i> ሙሉ በሙሉ ደህንነቱ የተጠበቀ መድረክ
                </span>
            </div>
        </div>

    </div>

</body>
</html>

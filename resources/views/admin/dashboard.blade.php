<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard | Wengel for World</title>
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
<body class="bg-slate-100 text-gray-800 font-sans antialiased min-h-screen">

    <!-- Topbar -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-secondary text-white rounded-lg flex items-center justify-center font-black text-lg">W</div>
                <div>
                    <span class="font-extrabold tracking-wide text-white text-base">WENGEL <span class="text-secondary">ADMIN</span></span>
                    <span class="text-[10px] block text-slate-400 font-medium">Mela Solution SaaS Engine</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/" target="_blank" class="text-xs bg-slate-800 hover:bg-slate-700 text-slate-300 px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    <span>ዋናውን ዌብሳይት እይ</span>
                </a>
                <span class="text-xs bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full border border-emerald-500/30 font-bold">
                    ● Live System
                </span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        <!-- Top Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">የተመዘገቡ አገልጋዮች</span>
                        <h3 class="text-3xl font-black text-primary mt-1">{{ count($pastors) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
                <p class="text-xs text-emerald-600 font-semibold mt-3 flex items-center">
                    <i class="fas fa-check-circle mr-1"></i> ሁሉም በኪራይ ውል ላይ ያሉ
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">የቀረቡ የምክር ጥያቄዎች</span>
                        <h3 class="text-3xl font-black text-secondary mt-1">{{ $messagesCount }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 text-secondary rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">ሚስጥራዊ Two-Way ግንኙነቶች</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">የፀሎት ጥያቄዎች</span>
                        <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ $prayersCount }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-praying-hands"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">ከዓለም ዙሪያ የቀረቡ ርዕሶች</p>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-800 flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Generate Pastor Link Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <div class="flex items-center space-x-2 text-primary font-black mb-1">
                        <i class="fas fa-link text-secondary"></i>
                        <h3 class="text-base">ለአዲስ ፓስተር ሊንክ ማመንጫ</h3>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 leading-relaxed">
                        ፓስተሩን መዝግበው ለምዕመናን የሚያጋሩትን ልዩ ሊንክ (Dedicated Portal) ያመንጩ።
                    </p>

                    <form action="/super-admin/generate-pastor" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የፓስተሩ ሙሉ ስም *</label>
                            <input type="text" name="name" required placeholder="ምሳሌ፡ ፓስተር ዮሴፍ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የቤተክርስቲያን/አገልግሎት ስም *</label>
                            <input type="text" name="church_name" required placeholder="ምሳሌ፡ የብርሃን ወንጌል ቤተክርስቲያን" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ስልክ ቁጥር *</label>
                            <input type="text" name="phone" required placeholder="0911..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ልዩ የሊንክ መለያ (Slug) *</label>
                            <div class="flex items-center">
                                <span class="text-xs text-gray-400 bg-gray-100 px-3 py-2.5 rounded-l-xl border border-r-0 border-gray-300">/p/</span>
                                <input type="text" name="slug" required placeholder="yosef" class="w-full text-sm px-3 py-2.5 rounded-r-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none lowercase">
                            </div>
                            <span class="text-[10px] text-gray-400 mt-1 block">ምሳሌ፡ 'yosef' ብለው ቢጽፉ ሊንኩ '/p/yosef' ይሆናል።</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">አጭር ባዮግራፊ/ራዕይ</label>
                            <textarea name="bio" rows="3" placeholder="ስለ አገልጋዩ አጭር ማብራሪያ..." class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3 bg-secondary hover:bg-amber-600 text-white font-bold rounded-xl shadow transition flex items-center justify-center space-x-2 mt-4">
                            <i class="fas fa-magic text-xs"></i>
                            <span>ሊንኩን ጀነሬት አድርግ</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pastors Directory & Generated Links -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-extrabold text-gray-900 text-lg">የተመዘገቡ አገልጋዮች እና ሊንኮቻቸው</h3>
                    <span class="text-xs font-bold text-primary bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                        {{ count($pastors) }} አገልጋዮች
                    </span>
                </div>

                @forelse($pastors as $p)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:border-gray-300 transition">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4 mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-11 h-11 rounded-xl bg-blue-50 text-primary flex items-center justify-center font-black text-lg border border-blue-100">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-gray-900 text-base">{{ $p->name }}</h4>
                                    <p class="text-xs text-secondary font-bold">{{ $p->pastorProfile->church_name ?? 'የወንጌል አገልጋይ' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    ውል: ገቢር (Active)
                                </span>
                            </div>
                        </div>

                        <!-- Links Section -->
                        <div class="space-y-2 bg-slate-50 p-4 rounded-xl border border-gray-100">
                            <!-- Public Portal Link -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                                <span class="text-gray-500 font-bold flex items-center space-x-1.5">
                                    <i class="fas fa-globe text-blue-600"></i>
                                    <span>ለምዕመናን የሚሰጥ ሊንክ:</span>
                                </span>
                                <div class="flex items-center space-x-2">
                                    <code class="bg-white px-2.5 py-1 rounded border border-gray-200 text-primary font-mono text-xs">
                                        https://wengel-for-world.vercel.app/p/{{ $p->email }}
                                    </code>
                                    <a href="/p/{{ $p->email }}" target="_blank" class="p-1 text-gray-400 hover:text-primary transition" title="ይክፈቱት">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Pastor Desk Link -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs border-t border-gray-200/60 pt-2">
                                <span class="text-gray-500 font-bold flex items-center space-x-1.5">
                                    <i class="fas fa-laptop-code text-secondary"></i>
                                    <span>የፓስተሩ ዳሽቦርድ (መልስ መስጫ):</span>
                                </span>
                                <a href="/pastor-desk/{{ $p->id }}" target="_blank" class="text-secondary hover:text-amber-700 font-bold flex items-center space-x-1">
                                    <span>ወደ ዳሽቦርዱ ግባ</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-200">
                        <i class="fas fa-users-slash text-gray-300 text-4xl mb-3"></i>
                        <h4 class="font-bold text-gray-700 mb-1">እስካሁን የተመዘገበ ፓስተር የለም</h4>
                        <p class="text-xs text-gray-500">በስተግራ በኩል ያለውን ፎርም ተጠቅመው የመጀመሪያውን አገልጋይ ይመዝግቡ።</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

</body>
</html>

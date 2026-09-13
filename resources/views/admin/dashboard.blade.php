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
                    colors: { primary: '#1E3A8A', secondary: '#D97706' }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 text-gray-800 font-sans min-h-screen">

    <!-- Topbar -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-secondary text-white rounded-lg flex items-center justify-center font-black text-lg">W</div>
                <div>
                    <span class="font-extrabold tracking-wide text-white text-base">WENGEL <span class="text-secondary">SUPER ADMIN</span></span>
                    <span class="text-[10px] block text-slate-400 font-medium">የኪራይና ሊንክ መቆጣጠሪያ ማዕከል</span>
                </div>
            </div>
            <a href="/" target="_blank" class="text-xs bg-slate-800 hover:bg-slate-700 text-slate-300 px-3 py-1.5 rounded-lg transition">
                <i class="fas fa-globe mr-1"></i> ዋናውን ዌብሳይት እይ
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        <!-- Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">የፓስተሮች ብዛት</span>
                        <h3 class="text-3xl font-black text-primary mt-1">{{ count($pastors) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">የተከራዩ አገልጋዮች</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">ጠቅላላ የምዕመናን ብዛት</span>
                        <h3 class="text-3xl font-black text-secondary mt-1">{{ $totalBelievers }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 text-secondary rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <p class="text-xs text-emerald-600 font-bold mt-3">በሁሉም ፓስተሮች ስር ያሉ</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">የተጫኑ ትምህርቶች</span>
                        <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ $teachingsCount }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-play-circle"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">ኦዲዮ፣ ቪዲዮ እና Live ስርጭቶች</p>
            </div>
        </div>

        <!-- Pastors List with Believers Pop-up Modal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Link Generator -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-base font-black text-primary mb-1">ለአዲስ ፓስተር ሊንክ ማመንጫ</h3>
                    <p class="text-xs text-gray-500 mb-6">የፓስተሩን መረጃ አስገብተው በስማቸው ልዩ ሊንክ ይፍጠሩ።</p>

                    <form action="/super-admin/generate-pastor" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የፓስተሩ ሙሉ ስም *</label>
                            <input type="text" name="name" required placeholder="ምሳሌ፡ ፓስተር ዮሴፍ" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">የቤተክርስቲያን ስም *</label>
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
                                <input type="text" name="slug" required placeholder="yosef" class="w-full text-sm px-3.5 py-2.5 rounded-r-xl border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none lowercase">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 bg-secondary hover:bg-amber-600 text-white font-bold rounded-xl shadow transition">
                            ሊንኩን ጀነሬት አድርግ
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pastors Directory & Believers Count -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="font-extrabold text-gray-900 text-lg mb-2">የተመዘገቡ አገልጋዮች ቁጥጥር</h3>

                @forelse($pastors as $p)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4 mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-11 h-11 rounded-xl bg-blue-50 text-primary flex items-center justify-center font-black text-lg border border-blue-100">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-gray-900 text-base">{{ $p->name }}</h4>
                                    <p class="text-xs text-secondary font-bold">{{ $p->pastorProfile->church_name ?? 'የወንጌል አገልጋይ' }} ({{ $p->phone }})</p>
                                </div>
                            </div>
                            
                            <!-- Believers Count Button (Pop-up Trigger) -->
                            <button onclick="openBelieversModal('{{ $p->id }}', '{{ $p->name }}')" class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-50 hover:bg-amber-100 text-secondary border border-amber-200 transition flex items-center space-x-1.5 shadow-sm">
                                <i class="fas fa-users"></i>
                                <span>{{ $p->believers_count }} ምዕመናን (ዝርዝር እይ)</span>
                            </button>
                        </div>

                        <!-- Link Info -->
                        <div class="bg-slate-50 p-3 rounded-xl border border-gray-100 mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                            <span class="text-gray-500 font-bold">የምዕመናን ሊንክ:</span>
                            <div class="flex items-center space-x-2">
                                <code class="bg-white px-2.5 py-1 rounded border border-gray-200 text-primary font-mono font-bold">
                                    https://wengel-for-world.vercel.app/p/{{ $p->email }}
                                </code>
                                <a href="/p/{{ $p->email }}" target="_blank" class="text-primary hover:underline">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-gray-100 text-xs">
                            <a href="/pastor-desk/{{ $p->id }}" target="_blank" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-primary font-bold rounded-lg transition">
                                <i class="fas fa-desktop mr-1"></i> የፓስተሩን ዳሽቦርድ እይ
                            </a>

                            <div class="flex items-center space-x-2">
                                <form action="/super-admin/toggle-status/{{ $p->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 font-bold rounded-lg transition {{ $p->is_verified ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                        {{ $p->is_verified ? 'ሊንኩን እገድ' : 'ሊንኩን አድስ' }}
                                    </button>
                                </form>

                                <form action="/super-admin/delete-pastor/{{ $p->id }}" method="POST" onsubmit="return confirm('እርግጠኛ ነዎት ማጥፋት ይፈልጋሉ?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 font-bold rounded-lg transition">
                                        አጥፋ
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Hidden JSON Data for Modal -->
                        <script id="believers-data-{{ $p->id }}" type="application/json">
                            {!! json_encode($p->believers_list) !!}
                        </script>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-200">
                        <p class="text-xs text-gray-500">እስካሁን የተመዘገበ ፓስተር የለም።</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <!-- 🌟 BELIEVERS POP-UP MODAL (የምዕመናን ፖፕ-አፕ ዝርዝር መስኮት) -->
    <div id="believersModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white max-w-lg w-full rounded-3xl shadow-2xl overflow-hidden border border-gray-200 animate-in fade-in zoom-in duration-200">
            <div class="bg-slate-900 text-white p-5 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-base" id="modalPastorName">የምዕመናን ዝርዝር</h3>
                    <span class="text-xs text-amber-400 font-medium" id="modalBelieversCount">0 ምዕመናን</span>
                </div>
                <button onclick="closeBelieversModal()" class="text-gray-400 hover:text-white text-xl">
                    &times;
                </button>
            </div>

            <div class="p-6 max-h-96 overflow-y-auto" id="modalBelieversList">
                <!-- Dynamic Content Loads Here -->
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-100 text-right">
                <button onclick="closeBelieversModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-gray-800 font-bold text-xs rounded-xl transition">
                    ዝጋ
                </button>
            </div>
        </div>
    </div>

    <script>
        function openBelieversModal(pastorId, pastorName) {
            document.getElementById('modalPastorName').innerText = "በ " + pastorName + " ስር ያሉ ምዕመናን";
            const dataEl = document.getElementById('believers-data-' + pastorId);
            const list = JSON.parse(dataEl.textContent);

            document.getElementById('modalBelieversCount').innerText = list.length + " የተመዘገቡ ምዕመናን";

            const container = document.getElementById('modalBelieversList');
            container.innerHTML = '';

            if (list.length === 0) {
                container.innerHTML = '<div class="text-center py-8 text-gray-400 text-xs">እስካሁን በዚህ ፓስተር ስር የተመዘገበ ምዕመን የለም።</div>';
            } else {
                list.forEach((b, index) => {
                    container.innerHTML += `
                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-gray-100 mb-2.5">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-primary flex items-center justify-center text-xs font-bold">
                                    ${index + 1}
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-gray-900">${b.name}</h5>
                                    <span class="text-[11px] text-gray-500 font-mono">${b.phone}</span>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-400">${b.created_at}</span>
                        </div>
                    `;
                });
            }

            document.getElementById('believersModal').classList.remove('hidden');
            document.getElementById('believersModal').classList.add('flex');
        }

        function closeBelieversModal() {
            document.getElementById('believersModal').classList.add('hidden');
            document.getElementById('believersModal').classList.remove('flex');
        }
    </script>
</body>
</html>

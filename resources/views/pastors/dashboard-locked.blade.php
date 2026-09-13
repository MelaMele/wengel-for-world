<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ዳሽቦርዱ ተቆልፏል | Wengel for World</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 font-sans text-gray-800">
    <div class="bg-white max-w-md w-full p-8 rounded-3xl shadow-xl border border-gray-200 text-center">
        <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-4 border border-rose-100 shadow-inner">
            <i class="fas fa-lock"></i>
        </div>
        
        <h2 class="text-xl font-black text-gray-900 mb-1">{{ $pastor->name }}</h2>
        <span class="text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1 rounded-full uppercase tracking-wider mb-4 inline-block">
            አካውንትዎ ለጊዜው ታግዷል (Locked)
        </span>

        <p class="text-xs text-gray-600 leading-relaxed mb-6 bg-slate-50 p-4 rounded-2xl border border-gray-100 text-justify">
            የእርስዎ ወርሃዊ የአገልግሎት ኪራይ ጊዜ መጠናቀቁን ወይም በአስተዳዳሪው እገዳ መደረጉን እናሳውቃለን። በዚህ ምክንያት ይዘት መጫን፣ የቀጥታ ስርጭት መክፈት ወይም የምክር መልስ መስጠት አይቻልም።
        </p>

        <div class="space-y-3">
            <div class="text-xs text-slate-500">
                አገልግሎቱን ለማደስ እና ዳሽቦርድዎን ለማስከፈት፡
            </div>
            <div class="bg-blue-50 text-blue-900 font-bold p-3 rounded-2xl text-xs border border-blue-100">
                <i class="fas fa-phone-alt mr-1"></i> ዋና አስተዳዳሪውን (Mela Solution) ያነጋግሩ
            </div>
        </div>
    </div>
</body>
</html>

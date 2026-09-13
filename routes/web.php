<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PastorController;
use App\Models\Teaching;
use App\Models\Category;

// ዋና መነሻ ገጽ
Route::get('/', [HomeController::class, 'index'])->name('home');

// የፀሎት ጥያቄዎች
Route::get('/prayer-requests', [HomeController::class, 'prayerIndex'])->name('prayer.index');
Route::post('/prayer-requests', [HomeController::class, 'prayerStore'])->name('prayer.store');

// የፓስተሮች አገልግሎት እና ሚስጥራዊ ምክር
Route::get('/pastors', [PastorController::class, 'index'])->name('pastors.index');
Route::get('/pastors/{id}', [PastorController::class, 'show'])->name('pastors.show');
Route::post('/pastors/{id}/counseling', [PastorController::class, 'sendCounseling'])->name('pastors.counseling');

// የስብከት እና የትምህርት ገጾች
Route::get('/teachings', function () {
    $teachings = Teaching::with(['pastor', 'category'])->latest()->paginate(9);
    $categories = Category::all();
    return view('teachings.index', compact('teachings', 'categories'));
})->name('teachings.index');

Route::get('/teachings/{id}', function ($id) {
    $teaching = Teaching::with(['pastor', 'category'])->findOrFail($id);
    $teaching->increment('views_count');
    return view('teachings.show', compact('teaching'));
})->name('teachings.show');

// የሙከራ ትምህርቶችን ዳታቤዝ ውስጥ ማስገቢያ (1 ጊዜ ብቻ የሚነካ)
Route::get('/setup-teachings-data', function () {
    try {
        $pastor = DB::table('users')->where('role', 'pastor')->first();
        if (!$pastor) {
            return "እባክዎ መጀመሪያ /setup-seed-data ን ይጫኑ።";
        }

        DB::table('teachings')->delete();

        // 1. የስብከት ድምፅ (Audio Teaching)
        DB::table('teachings')->insert([
            'pastor_id' => $pastor->id,
            'category_id' => 1,
            'title' => 'የእምነት ጉዞ በፈተናዎች መካከል',
            'slug' => 'faith-through-trials',
            'type' => 'audio',
            'media_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', // የሙከራ ኦዲዮ
            'content' => 'በህይወታችን ውስጥ የሚያጋጥሙን ፈተናዎች እምነታችንን የሚያጠነክሩ እንጂ የሚያጠፉ አይደሉም። በዚህ ትምህርት ውስጥ ጳውሎስና ሲላስ በእስር ቤት ሆነው እንዴት እግዚአብሔርን እንዳመሰገኑ እንመለከታለን።',
            'views_count' => 124,
            'is_featured' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. የቪዲዮ ስብከት (Video Sermon)
        DB::table('teachings')->insert([
            'pastor_id' => $pastor->id,
            'category_id' => 2,
            'title' => 'የተባረከ ትዳርና የሰላም ቤተሰብ መሰረቶች',
            'slug' => 'foundations-of-blessed-marriage',
            'type' => 'video',
            'media_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'content' => 'ትዳር በእግዚአብሔር ቃል ላይ ሲመሰረት በየትኛውም ማዕበል አይናወጥም። የባልና የሚስት የጋራ ኃላፊነቶችና የይቅርታ ሚና በዚህ ትምህርት ተዳሷል።',
            'views_count' => 310,
            'is_featured' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return "<h2 style='color:green;font-family:sans-serif;'>✅ የትምህርቶች መረጃ በተሳካ ሁኔታ ገብቷል! <br><br> <a href='/teachings'>ወደ ትምህርቶች ገጽ ለመሄድ እዚህ ይጫኑ</a></h2>";
    } catch (\Exception $e) {
        return "<h2 style='color:red;'>ስህተት: " . $e->getMessage() . "</h2>";
    }
});

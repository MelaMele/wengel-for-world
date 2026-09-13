<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PastorController;

// ዋና መነሻ ገጽ
Route::get('/', [HomeController::class, 'index'])->name('home');

// የፀሎት ጥያቄዎች
Route::get('/prayer-requests', [HomeController::class, 'prayerIndex'])->name('prayer.index');
Route::post('/prayer-requests', [HomeController::class, 'prayerStore'])->name('prayer.store');

// የፓስተሮች አገልግሎት እና ሚስጥራዊ ምክር
Route::get('/pastors', [PastorController::class, 'index'])->name('pastors.index');
Route::get('/pastors/{id}', [PastorController::class, 'show'])->name('pastors.show');
Route::post('/pastors/{id}/counseling', [PastorController::class, 'sendCounseling'])->name('pastors.counseling');

// በኮድ የፓስተሮችን መረጃ በቀጥታ ዳታቤዝ ውስጥ ማስገቢያ (1 ጊዜ ብቻ የምንነካው ሊንክ)
Route::get('/setup-seed-data', function () {
    try {
        // የነበረ ካለ እንዳይደጋገም ማጽዳት
        DB::table('pastor_profiles')->delete();
        DB::table('users')->where('role', 'pastor')->delete();

        // 1. ፓስተር ዳዊት
        $pastor1 = DB::table('users')->insertGetId([
            'name' => 'ፓስተር ዳዊት (Pastor Dawit)',
            'email' => 'pastor.dawit@wengel.org',
            'phone' => '+251911223344',
            'role' => 'pastor',
            'country' => 'Ethiopia',
            'password' => bcrypt('password123'),
            'is_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pastor_profiles')->insert([
            'user_id' => $pastor1,
            'title' => 'Pastor',
            'church_name' => 'የሕይወት ቃል ቤተክርስቲያን',
            'bio' => 'በወንጌል እውነት የተመሰረተ ትውልድ ለማፍራት፣ በፀሎትና በመንፈሳዊ ምክር ሰዎችን ለማነጽ የሚተጉ አገልጋይ።',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. ወንጌላዊ ዮናስ
        $pastor2 = DB::table('users')->insertGetId([
            'name' => 'ወንጌላዊ ዮናስ (Evangelist Yonas)',
            'email' => 'yonas@wengel.org',
            'phone' => '+251922334455',
            'role' => 'pastor',
            'country' => 'Ethiopia',
            'password' => bcrypt('password123'),
            'is_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pastor_profiles')->insert([
            'user_id' => $pastor2,
            'title' => 'Evangelist',
            'church_name' => 'ዓለም አቀፍ የወንጌል ብርሃን አገልግሎት',
            'bio' => 'በሀገር ውስጥና በውጭ ላሉ ምዕመናን የመዳንን ወንጌል የሚያደርሱ፣ ለወጣቶችና ለቤተሰብ ምክር የሚሰጡ አገልጋይ።',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return "<h2 style='color:green;font-family:sans-serif;'>✅ የፓስተሮች መረጃ በተሳካ ሁኔታ ዳታቤዝ ውስጥ ገብቷል! <br><br> <a href='/pastors'>ወደ ፓስተሮች ገጽ ለመሄድ እዚህ ይጫኑ</a></h2>";
    } catch (\Exception $e) {
        return "<h2 style='color:red;'>ስህተት ተፈጥሯል: " . $e->getMessage() . "</h2>";
    }
});

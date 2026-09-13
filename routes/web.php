<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PastorController;
use App\Models\Teaching;
use App\Models\Category;
use App\Models\User;

// 1. ዋና ገጾች
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/prayer-requests', [HomeController::class, 'prayerIndex'])->name('prayer.index');
Route::post('/prayer-requests', [HomeController::class, 'prayerStore'])->name('prayer.store');

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

Route::get('/pastors', [PastorController::class, 'index'])->name('pastors.index');
Route::get('/pastors/{id}', [PastorController::class, 'show'])->name('pastors.show');
Route::post('/pastors/{id}/counseling', [PastorController::class, 'sendCounseling'])->name('pastors.counseling');

// 2. የፓስተሮች ልዩ ሊንክ (Dedicated Pastor Invitation Link)
// ምሳሌ፡ wengel-for-world.vercel.app/p/dawit
Route::get('/p/{slug}', function ($slug) {
    $pastor = User::where('role', 'pastor')
        ->where(function ($q) use ($slug) {
            $q->where('email', 'like', "%{$slug}%")
              ->orWhere('id', is_numeric($slug) ? $slug : 0);
        })
        ->with(['pastorProfile', 'teachings'])
        ->firstOrFail();

    return view('pastors.portal', compact('pastor'));
})->name('pastor.portal');

// 3. Super Admin ዳሽቦርድ - ለፓስተሮች ሊንክ ማመንጫ እና የኪራይ ቁጥጥር
Route::get('/super-admin', function () {
    $pastors = User::where('role', 'pastor')->with('pastorProfile')->get();
    $messagesCount = DB::table('counseling_messages')->count();
    $prayersCount = DB::table('prayer_requests')->count();
    return view('admin.dashboard', compact('pastors', 'messagesCount', 'prayersCount'));
})->name('admin.dashboard');

// Super Admin አዲስ ፓስተር መዝግቦ ሊንክ ጀነሬት ማድረጊያ
Route::post('/super-admin/generate-pastor', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'church_name' => 'required',
        'phone' => 'required',
        'slug' => 'required|unique:users,email'
    ]);

    $userId = DB::table('users')->insertGetId([
        'name' => $request->name,
        'email' => $request->slug, // ይህ እንደ Unique Identifier / Slug ያገለግላል
        'phone' => $request->phone,
        'role' => 'pastor',
        'password' => bcrypt('123456'),
        'is_verified' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('pastor_profiles')->insert([
        'user_id' => $userId,
        'church_name' => $request->church_name,
        'bio' => $request->bio ?? 'የእግዚአብሔር አገልጋይ',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'ለአገልጋዩ ልዩ ሊንክ በተሳካ ሁኔታ ተፈጥሯል!');
});

// 4. Pastor ዳሽቦርድ (Two-Way Communication መልስ መስጫ)
Route::get('/pastor-desk/{id}', function ($id) {
    $pastor = User::where('role', 'pastor')->findOrFail($id);
    $messages = DB::table('counseling_messages')
        ->where('pastor_id', $id)
        ->orderByDesc('created_at')
        ->get();
    return view('pastors.dashboard', compact('pastor', 'messages'));
})->name('pastor.dashboard');

// ፓስተሩ ለምዕመኑ መልስ መስጫ (Reply)
Route::post('/pastor-desk/{id}/reply', function (Request $request, $id) {
    DB::table('counseling_messages')
        ->where('id', $request->message_id)
        ->where('pastor_id', $id)
        ->update([
            'reply' => $request->reply,
            'status' => 'answered',
            'updated_at' => now(),
        ]);

    return back()->with('success', 'የምክር መልስዎ በተሳካ ሁኔታ ተልኳል!');
});

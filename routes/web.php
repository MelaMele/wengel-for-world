<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PastorController;
use App\Models\Teaching;
use App\Models\Category;
use App\Models\User;

// ዋና ገጾች
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

// የፓስተሩ ፖርታል ለምዕመናን (ከነ Live ቪዲዮውና ቻቱ ጋር)
Route::get('/p/{slug}', function ($slug) {
    $pastor = User::where('role', 'pastor')
        ->where(function ($q) use ($slug) {
            $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
        })
        ->with(['pastorProfile', 'teachings'])
        ->firstOrFail();

    if (!$pastor->is_verified) {
        return view('pastors.suspended', compact('pastor'));
    }

    $liveSession = DB::table('teachings')->where('pastor_id', $pastor->id)->where('type', 'live')->latest()->first();

    return view('pastors.portal', compact('pastor', 'liveSession'));
})->name('pastor.portal');

// ሱፐር አድሚን ዳሽቦርድ
Route::get('/super-admin', function () {
    $pastors = User::where('role', 'pastor')->with('pastorProfile')->get();
    $believersCount = DB::table('counseling_messages')->distinct('user_id')->count('user_id') + 45;
    $teachingsCount = DB::table('teachings')->count();
    return view('admin.dashboard', compact('pastors', 'believersCount', 'teachingsCount'));
})->name('admin.dashboard');

Route::post('/super-admin/generate-pastor', function (Request $request) {
    $request->validate(['name' => 'required', 'church_name' => 'required', 'phone' => 'required', 'slug' => 'required|unique:users,email']);
    $userId = DB::table('users')->insertGetId([
        'name' => $request->name, 'email' => strtolower(trim($request->slug)), 'phone' => $request->phone, 'role' => 'pastor', 'password' => bcrypt('123456'), 'is_verified' => 1, 'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('pastor_profiles')->insert([
        'user_id' => $userId, 'church_name' => $request->church_name, 'bio' => $request->bio ?? 'የእግዚአብሔር አገልጋይ', 'created_at' => now(), 'updated_at' => now(),
    ]);
    return back()->with('success', 'ለአገልጋዩ ልዩ ሊንክ በተሳካ ሁኔታ ተፈጥሯል!');
});

Route::post('/super-admin/toggle-status/{id}', function ($id) {
    $pastor = User::findOrFail($id);
    $pastor->is_verified = !$pastor->is_verified;
    $pastor->save();
    return back()->with('success', 'የአገልጋዩ ሁኔታ ተቀይሯል!');
});

Route::post('/super-admin/delete-pastor/{id}', function ($id) {
    DB::table('pastor_profiles')->where('user_id', $id)->delete();
    DB::table('teachings')->where('pastor_id', $id)->delete();
    DB::table('counseling_messages')->where('pastor_id', $id)->delete();
    DB::table('users')->where('id', $id)->delete();
    return back()->with('success', 'አገልጋዩ ተሰርዟል!');
});

// የፓስተሩ ዳሽቦርድ (ጋለሪ አፕሎድ እና Live Room)
Route::get('/pastor-desk/{id}', function ($id) {
    $pastor = User::where('role', 'pastor')->with('pastorProfile')->findOrFail($id);
    $messages = DB::table('counseling_messages')->where('pastor_id', $id)->orderByDesc('created_at')->get();
    $teachings = Teaching::where('pastor_id', $id)->latest()->get();
    return view('pastors.dashboard', compact('pastor', 'messages', 'teachings'));
})->name('pastor.dashboard');

// ከጋለሪ ፋይል (Audio/Video) መጫኛ እና ጽሁፍ ማቅረቢያ
Route::post('/pastor-desk/{id}/upload-content', function (Request $request, $id) {
    $request->validate([
        'title' => 'required',
        'content_type' => 'required|in:audio,video,article,live',
    ]);

    $mediaUrl = null;

    // ከጋለሪ ፋይል ከተመረጠ (Direct File Upload Handling)
    if ($request->hasFile('media_file')) {
        $file = $request->file('media_file');
        // ፋይሉን በጊዜያዊ ማከማቻ ማስቀመጥ (ወይም ወደ Data URI መቀየር ለቀላል አጫወት)
        $mediaUrl = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file));
    }

    DB::table('teachings')->insert([
        'pastor_id' => $id,
        'category_id' => 1,
        'title' => $request->title,
        'slug' => strtolower(str_replace(' ', '-', $request->title)) . '-' . rand(100, 999),
        'type' => $request->content_type == 'live' ? 'video' : $request->content_type,
        'media_url' => $mediaUrl,
        'content' => $request->article_body ?? $request->description,
        'views_count' => 0,
        'is_featured' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'ይዘቱ በተሳካ ሁኔታ ተጭኗል!');
});

// ፓስተሩ ለምዕመኑ ጥያቄ መልስ መስጫ
Route::post('/pastor-desk/{id}/reply', function (Request $request, $id) {
    DB::table('counseling_messages')->where('id', $request->message_id)->where('pastor_id', $id)->update([
        'reply' => $request->reply,
        'status' => 'answered',
        'updated_at' => now(),
    ]);
    return back()->with('success', 'መልስዎ ተልኳል!');
});

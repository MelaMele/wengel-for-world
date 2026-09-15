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

// 1. የምዕመናን ፖርታል (Live + Chat + Giving)
Route::get('/p/{slug}', function (Request $request, $slug) {
    $pastor = User::where('role', 'pastor')
        ->where(function ($q) use ($slug) {
            $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
        })
        ->with(['pastorProfile', 'teachings'])
        ->firstOrFail();

    if (!$pastor->is_verified) {
        return view('pastors.suspended', compact('pastor'));
    }

    $believerPhone = session('believer_phone_' . $pastor->id);
    $believerName = session('believer_name_' . $pastor->id);

    if (!$believerPhone) {
        return view('believers.login', compact('pastor'));
    }

    $chatMessages = DB::table('counseling_messages')
        ->where('pastor_id', $pastor->id)
        ->where('subject', 'like', "%{$believerPhone}%")
        ->orderBy('created_at', 'asc')
        ->get();

    $donationsTotal = DB::table('donations')->where('pastor_id', $pastor->id)->where('status', 'success')->sum('amount');

    return view('believers.dashboard', compact('pastor', 'chatMessages', 'believerName', 'believerPhone', 'donationsTotal'));
})->name('pastor.portal');

Route::post('/p/{slug}/believer-login', function (Request $request, $slug) {
    $request->validate(['name' => 'required|string|max:100', 'phone' => 'required|string|max:50']);
    $pastor = User::where('role', 'pastor')->where(function ($q) use ($slug) {
        $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
    })->firstOrFail();

    $name = trim($request->name);
    $phone = trim($request->phone);

    $existing = DB::table('believers')->where('pastor_id', $pastor->id)->where('phone', $phone)->first();
    if (!$existing) {
        DB::table('believers')->insert(['pastor_id' => $pastor->id, 'name' => $name, 'phone' => $phone, 'created_at' => now()]);
    }

    session(['believer_name_' . $pastor->id => $name, 'believer_phone_' . $pastor->id => $phone]);
    return redirect('/p/' . $slug);
});

Route::get('/p/{slug}/believer-logout', function ($slug) {
    $pastor = User::where('role', 'pastor')->where(function ($q) use ($slug) {
        $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
    })->firstOrFail();
    session()->forget(['believer_name_' . $pastor->id, 'believer_phone_' . $pastor->id]);
    return redirect('/p/' . $slug);
});

Route::post('/p/{slug}/send-message', function (Request $request, $slug) {
    $pastor = User::where('role', 'pastor')->where(function ($q) use ($slug) {
        $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
    })->firstOrFail();

    $believerPhone = session('believer_phone_' . $pastor->id);
    $believerName = session('believer_name_' . $pastor->id);
    if (!$believerPhone) return redirect('/p/' . $slug);

    $messageContent = $request->message;
    if ($request->filled('voice_data')) {
        $messageContent = 'AUDIO_VOICE:' . $request->voice_data;
    }

    DB::table('counseling_messages')->insert([
        'pastor_id' => $pastor->id,
        'user_id' => 1,
        'subject' => '[' . $believerPhone . '] ከ ' . $believerName,
        'message' => $messageContent,
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back();
});

// 2. አስራትና ስጦታ መላኪያ (Giving / Tithe Processing)
Route::post('/p/{slug}/give', function (Request $request, $slug) {
    $pastor = User::where('role', 'pastor')->where(function ($q) use ($slug) {
        $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
    })->firstOrFail();

    $request->validate([
        'amount' => 'required|numeric|min:10',
        'giving_type' => 'required',
        'payment_method' => 'required',
    ]);

    $believerName = session('believer_name_' . $pastor->id) ?? 'ስሙ ያልተጠቀሰ ምዕመን';

    DB::table('donations')->insert([
        'pastor_id' => $pastor->id,
        'user_id' => 1,
        'amount' => $request->amount,
        'currency' => $request->payment_method == 'stripe' ? 'USD' : 'ETB',
        'type' => $request->giving_type,
        'payment_method' => $request->payment_method,
        'transaction_reference' => 'WENGEL-' . strtoupper(uniqid()),
        'status' => 'success',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('giving_success', 'የ ' . number_format($request->amount) . ' ብር አስራት/ስጦታዎ በተሳካ ሁኔታ ተቀባይነት አግኝቷል። እግዚአብሔር አብዝቶ ይባርክዎት!');
});

// 3. ሱፐር አድሚን ዳሽቦርድ
Route::get('/super-admin', function () {
    $pastors = User::where('role', 'pastor')->with('pastorProfile')->get();
    foreach ($pastors as $p) {
        $p->believers_list = DB::table('believers')->where('pastor_id', $p->id)->orderByDesc('created_at')->get();
        $p->believers_count = count($p->believers_list);
        $p->total_given = DB::table('donations')->where('pastor_id', $p->id)->where('status', 'success')->sum('amount');
    }
    $totalBelievers = DB::table('believers')->count();
    $teachingsCount = DB::table('teachings')->count();
    $grandTotalGiving = DB::table('donations')->where('status', 'success')->sum('amount');

    return view('admin.dashboard', compact('pastors', 'totalBelievers', 'teachingsCount', 'grandTotalGiving'));
})->name('admin.dashboard');

Route::post('/super-admin/generate-pastor', function (Request $request) {
    $request->validate(['name' => 'required', 'church_name' => 'required', 'phone' => 'required', 'slug' => 'required|unique:users,email']);
    $userId = DB::table('users')->insertGetId([
        'name' => $request->name, 'email' => strtolower(trim($request->slug)), 'phone' => $request->phone, 'role' => 'pastor', 'password' => bcrypt('123456'), 'is_verified' => 1, 'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('pastor_profiles')->insert([
        'user_id' => $userId, 'church_name' => $request->church_name, 'bio' => $request->bio ?? 'የእግዚአብሔር አገልጋይ', 'created_at' => now(), 'updated_at' => now(),
    ]);
    return back()->with('success', 'አገልጋዩ ተመዝግቧል!');
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
    DB::table('believers')->where('pastor_id', $id)->delete();
    DB::table('donations')->where('pastor_id', $id)->delete();
    DB::table('users')->where('id', $id)->delete();
    return back()->with('success', 'አገልጋዩ ተሰርዟል!');
});

// 4. የፓስተሩ ዳሽቦርድ (ስጦታዎችና የተሰበሰበ አስራት ማሳያ)
Route::get('/pastor-desk/{id}', function ($id) {
    $pastor = User::where('role', 'pastor')->with('pastorProfile')->findOrFail($id);
    if (!$pastor->is_verified) return view('pastors.dashboard-locked', compact('pastor'));

    $messages = DB::table('counseling_messages')->where('pastor_id', $id)->orderByDesc('created_at')->get();
    $teachings = Teaching::where('pastor_id', $id)->latest()->get();
    $believers = DB::table('believers')->where('pastor_id', $id)->orderByDesc('created_at')->get();
    $donations = DB::table('donations')->where('pastor_id', $id)->orderByDesc('created_at')->get();
    $totalRaised = DB::table('donations')->where('pastor_id', $id)->where('status', 'success')->sum('amount');

    return view('pastors.dashboard', compact('pastor', 'messages', 'teachings', 'believers', 'donations', 'totalRaised'));
})->name('pastor.dashboard');

Route::post('/pastor-desk/{id}/upload-content', function (Request $request, $id) {
    $pastor = User::findOrFail($id);
    if (!$pastor->is_verified) return back()->with('error', 'አካውንትዎ ታግዷል');

    $request->validate(['title' => 'required', 'content_type' => 'required|in:audio,video,article,live']);
    $mediaUrl = null;
    if ($request->hasFile('media_file')) {
        $file = $request->file('media_file');
        $mediaUrl = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file));
    }
    DB::table('teachings')->insert([
        'pastor_id' => $id, 'category_id' => 1, 'title' => $request->title,
        'slug' => strtolower(str_replace(' ', '-', $request->title)) . '-' . rand(100, 999),
        'type' => $request->content_type == 'live' ? 'video' : $request->content_type,
        'media_url' => $mediaUrl,
        'content' => $request->article_body ?? $request->description,
        'views_count' => 0, 'is_featured' => 1, 'created_at' => now(), 'updated_at' => now(),
    ]);
    return back()->with('success', 'ይዘቱ ተጭኗል!');
});

Route::post('/pastor-desk/{id}/reply', function (Request $request, $id) {
    $pastor = User::findOrFail($id);
    if (!$pastor->is_verified) return back()->with('error', 'አካውንትዎ ታግዷል');

    $replyContent = $request->reply;
    if ($request->filled('pastor_voice_data')) {
        $replyContent = 'AUDIO_VOICE:' . $request->pastor_voice_data;
    }

    DB::table('counseling_messages')->where('id', $request->message_id)->where('pastor_id', $id)->update([
        'reply' => $replyContent, 'status' => 'answered', 'updated_at' => now(),
    ]);
    return back()->with('success', 'መልስዎ ተልኳል!');
});

// የ Donations ቴብል መፍጠሪያ (1 ጊዜ ብቻ የሚነካ)
Route::get('/setup-donations-table', function () {
    DB::statement("CREATE TABLE IF NOT EXISTS `donations` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `pastor_id` bigint(20) UNSIGNED NOT NULL,
      `user_id` bigint(20) UNSIGNED DEFAULT 1,
      `amount` decimal(10,2) NOT NULL,
      `currency` varchar(10) NOT NULL DEFAULT 'ETB',
      `type` varchar(50) NOT NULL DEFAULT 'offering',
      `payment_method` varchar(50) NOT NULL DEFAULT 'telebirr',
      `transaction_reference` varchar(100) NOT NULL,
      `status` enum('pending','success','failed') NOT NULL DEFAULT 'success',
      `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      FOREIGN KEY (`pastor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    return "<h2 style='color:green;'>✅ Donations Table Created! <a href='/super-admin'>ወደ ዳሽቦርድ ሂድ</a></h2>";
});

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

// 1. የፓስተሩ ሊንክ ለምዕመናን (ምዕመናን የሚገቡበት)
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

    return view('believers.dashboard', compact('pastor', 'chatMessages', 'believerName', 'believerPhone'));
})->name('pastor.portal');

// ምዕመኑ በስሙ መመዝገቢያ
Route::post('/p/{slug}/believer-login', function (Request $request, $slug) {
    $request->validate([
        'name' => 'required|string|max:100',
        'phone' => 'required|string|max:50',
    ]);

    $pastor = User::where('role', 'pastor')
        ->where(function ($q) use ($slug) {
            $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
        })
        ->firstOrFail();

    $name = trim($request->name);
    $phone = trim($request->phone);

    $existing = DB::table('believers')
        ->where('pastor_id', $pastor->id)
        ->where('phone', $phone)
        ->first();

    if (!$existing) {
        DB::table('believers')->insert([
            'pastor_id' => $pastor->id,
            'name' => $name,
            'phone' => $phone,
            'created_at' => now(),
        ]);
    }

    session([
        'believer_name_' . $pastor->id => $name,
        'believer_phone_' . $pastor->id => $phone,
    ]);

    return redirect('/p/' . $slug);
});

Route::get('/p/{slug}/believer-logout', function ($slug) {
    $pastor = User::where('role', 'pastor')
        ->where(function ($q) use ($slug) {
            $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
        })
        ->firstOrFail();

    session()->forget(['believer_name_' . $pastor->id, 'believer_phone_' . $pastor->id]);
    return redirect('/p/' . $slug);
});

Route::post('/p/{slug}/send-message', function (Request $request, $slug) {
    $pastor = User::where('role', 'pastor')
        ->where(function ($q) use ($slug) {
            $q->where('email', $slug)->orWhere('id', is_numeric($slug) ? $slug : 0);
        })
        ->firstOrFail();

    $believerPhone = session('believer_phone_' . $pastor->id);
    $believerName = session('believer_name_' . $pastor->id);

    if (!$believerPhone) {
        return redirect('/p/' . $slug);
    }

    $request->validate(['message' => 'required|string']);

    DB::table('counseling_messages')->insert([
        'pastor_id' => $pastor->id,
        'user_id' => 1,
        'subject' => '[' . $believerPhone . '] ከ ' . $believerName,
        'message' => $request->message,
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back();
});

// 2. ሱፐር አድሚን ዳሽቦርድ (ፓስተሮችን መመዝገብ፣ መቆጣጠርና የዳሽቦርድ ሊንካቸውን መስጠት ብቻ)
Route::get('/super-admin', function () {
    $pastors = User::where('role', 'pastor')->with('pastorProfile')->get();
    
    foreach ($pastors as $p) {
        $p->believers_list = DB::table('believers')->where('pastor_id', $p->id)->orderByDesc('created_at')->get();
        $p->believers_count = count($p->believers_list);
    }

    $totalBelievers = DB::table('believers')->count();
    $teachingsCount = DB::table('teachings')->count();

    return view('admin.dashboard', compact('pastors', 'totalBelievers', 'teachingsCount'));
})->name('admin.dashboard');

// አዲስ ፓስተር መዝግቦ የዳሽቦርድ ቁልፍ መስጠት
Route::post('/super-admin/generate-pastor', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'church_name' => 'required',
        'phone' => 'required',
        'slug' => 'required|unique:users,email'
    ]);

    $userId = DB::table('users')->insertGetId([
        'name' => $request->name,
        'email' => strtolower(trim($request->slug)),
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

    return back()->with('success', 'አገልጋዩ በተሳካ ሁኔታ ተመዝግቧል! የዳሽቦርድ ሊንኩን ለፓስተሩ ይስጡ።');
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
    DB::table('users')->where('id', $id)->delete();
    return back()->with('success', 'አገልጋዩ ተሰርዟል!');
});

// 3. የፓስተሩ ዳሽቦርድ (የምዕመናኑን ሊንክ ፓስተሩ ራሱ እዚህ ያገኘዋል)
Route::get('/pastor-desk/{id}', function ($id) {
    $pastor = User::where('role', 'pastor')->with('pastorProfile')->findOrFail($id);
    if (!$pastor->is_verified) {
        return view('pastors.dashboard-locked', compact('pastor'));
    }

    $messages = DB::table('counseling_messages')->where('pastor_id', $id)->orderByDesc('created_at')->get();
    $teachings = Teaching::where('pastor_id', $id)->latest()->get();
    $believers = DB::table('believers')->where('pastor_id', $id)->orderByDesc('created_at')->get();

    return view('pastors.dashboard', compact('pastor', 'messages', 'teachings', 'believers'));
})->name('pastor.dashboard');

Route::post('/pastor-desk/{id}/upload-content', function (Request $request, $id) {
    $pastor = User::findOrFail($id);
    if (!$pastor->is_verified) {
        return back()->with('error', 'አካውንትዎ ስለታገደ ይዘት መጫን አይችሉም።');
    }

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
    if (!$pastor->is_verified) {
        return back()->with('error', 'አካውንትዎ ስለታገደ መልስ መስጠት አይችሉም።');
    }

    DB::table('counseling_messages')->where('id', $request->message_id)->where('pastor_id', $id)->update([
        'reply' => $request->reply, 'status' => 'answered', 'updated_at' => now(),
    ]);
    return back()->with('success', 'መልስዎ ተልኳል!');
});

// ማጽጃ
Route::get('/clean-all-demo-data', function () {
    DB::table('counseling_messages')->truncate();
    DB::table('teachings')->truncate();
    DB::table('pastor_profiles')->truncate();
    DB::table('believers')->truncate();
    DB::table('users')->where('role', 'pastor')->delete();

    return "<h2 style='color:green;font-family:sans-serif;'>✅ ሁሉም ዳታዎች ተጠርገዋል! <br><br> <a href='/super-admin'>ወደ Super Admin ሂድ</a></h2>";
});

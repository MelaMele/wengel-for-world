<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teaching;
use App\Models\PrayerRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pastors = User::where('role', 'pastor')->take(4)->get();
        $recentTeachings = Teaching::latest()->take(6)->get();
        return view('welcome', compact('pastors', 'recentTeachings'));
    }

    public function prayerIndex()
    {
        $prayers = PrayerRequest::latest()->take(15)->get();
        return view('prayer.index', compact('prayers'));
    }

    public function prayerStore(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'request' => 'required',
        ]);

        PrayerRequest::create([
            'requester_name' => $request->is_anonymous ? 'ስሙ ያልተጠቀሰ (Anonymous)' : ($request->requester_name ?? 'የክርስቶስ ቤተሰብ'),
            'title' => $request->title,
            'request' => $request->request_body,
            'is_anonymous' => $request->has('is_anonymous') ? 1 : 0,
        ]);

        return back()->with('success', 'የፀሎት ጥያቄዎ በተሳካ ሁኔታ ደርሷል። አገልጋዮች በፀሎት ያስቡዎታል!');
    }
}

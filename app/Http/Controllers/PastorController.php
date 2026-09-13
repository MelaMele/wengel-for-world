<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PastorController extends Controller
{
    // ሁሉንም ፓስተሮች ማሳያ
    public function index()
    {
        $pastors = User::where('role', 'pastor')->with('pastorProfile')->get();
        return view('pastors.index', compact('pastors'));
    }

    // የአንድ ፓስተር ዝርዝር ገጽ እና የምክር መጠየቂያ
    public function show($id)
    {
        $pastor = User::where('role', 'pastor')->with(['pastorProfile', 'teachings'])->findOrFail($id);
        return view('pastors.show', compact('pastor'));
    }

    // የግል ሚስጥራዊ ምክር መቀበያ
    public function sendCounseling(Request $request, $pastor_id)
    {
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_phone_or_email' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // በዳታቤዝ ውስጥ ማስቀመጥ
        DB::table('counseling_messages')->insert([
            'pastor_id' => $pastor_id,
            'user_id' => 1, // ጊዜያዊ ለይተን እንድናውቀው
            'subject' => '[' . $request->sender_phone_or_email . '] ' . $request->subject . ' (ከ: ' . $request->sender_name . ')',
            'message' => $request->message,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('counseling_success', 'የምክር ጥያቄዎ ለፓስተሩ በሚስጥር ተልኳል። ፓስተሩ በቀረቡት አድራሻ ያገኝዎታል!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Show help/support page
     */
    public function index()
    {
        return view('help');
    }

    /**
     * Submit a complaint/support request
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $complaint = Complaint::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaduan berhasil dikirim! Kami akan merespons dalam waktu 1-3 hari kerja.',
            ]);
        }

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim!');
    }
}

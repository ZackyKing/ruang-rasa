<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Store a new report
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'reason' => 'required|string|in:spam,harassment,inappropriate,misinformation,other',
            'description' => 'nullable|string|max:500',
        ]);

        // Check if user already reported this post
        $existingReport = Report::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah melaporkan postingan ini sebelumnya',
            ], 400);
        }

        // Cannot report your own post
        if ($post->user_id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat melaporkan postingan sendiri',
            ], 400);
        }

        $report = Report::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim. Terima kasih atas laporanmu!',
        ]);
    }
}

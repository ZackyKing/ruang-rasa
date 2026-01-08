<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Show the notifications page
     */
    public function index()
    {
        $user = Auth::user();

        // Get real notifications from database
        $notificationsQuery = Notification::where('user_id', $user->id)
            ->latest()
            ->get();

        $notifications = $notificationsQuery->map(function ($notification) {
            $data = $notification->data;

            // Format notification based on type
            switch ($notification->type) {
                case 'like':
                    return [
                        'id' => $notification->id,
                        'category' => 'like',
                        'user' => $data['liker_name'] ?? 'Seseorang',
                        'action' => 'menyukai tulisanmu',
                        'ruang' => null,
                        'preview' => $data['post_preview'] ?? '',
                        'time' => $notification->created_at->diffForHumans(),
                        'avatar' => null,
                        'highlighted' => !$notification->isRead(),
                        'post_id' => $data['post_id'] ?? null,
                    ];
                case 'comment':
                    return [
                        'id' => $notification->id,
                        'category' => 'comment',
                        'user' => $data['commenter_name'] ?? 'Seseorang',
                        'action' => 'mengomentari tulisanmu',
                        'ruang' => null,
                        'preview' => $data['comment_preview'] ?? '',
                        'time' => $notification->created_at->diffForHumans(),
                        'avatar' => null,
                        'highlighted' => !$notification->isRead(),
                        'post_id' => $data['post_id'] ?? null,
                    ];
                case 'follow':
                    return [
                        'id' => $notification->id,
                        'category' => 'follow',
                        'user' => $data['follower_name'] ?? 'Seseorang',
                        'action' => 'mulai mengikutimu',
                        'ruang' => null,
                        'preview' => '',
                        'time' => $notification->created_at->diffForHumans(),
                        'avatar' => null,
                        'highlighted' => !$notification->isRead(),
                        'user_id' => $data['follower_id'] ?? null,
                    ];
                case 'reshare':
                    return [
                        'id' => $notification->id,
                        'category' => 'share',
                        'user' => $data['resharer_name'] ?? 'Seseorang',
                        'action' => 'membagikan tulisanmu',
                        'ruang' => null,
                        'preview' => $data['post_preview'] ?? '',
                        'time' => $notification->created_at->diffForHumans(),
                        'avatar' => null,
                        'highlighted' => !$notification->isRead(),
                        'post_id' => $data['post_id'] ?? null,
                    ];
                case 'answer':
                    return [
                        'id' => $notification->id,
                        'category' => 'comment',
                        'user' => $data['answerer_name'] ?? 'Seseorang',
                        'action' => 'Menjawab Pertanyaanmu',
                        'ruang' => null,
                        'preview' => $data['question_preview'] ?? '',
                        'time' => $notification->created_at->diffForHumans(),
                        'avatar' => null,
                        'highlighted' => !$notification->isRead(),
                        'question_id' => $data['question_id'] ?? null,
                    ];
                default:
                    return [
                        'id' => $notification->id,
                        'category' => 'other',
                        'user' => 'Sistem',
                        'action' => 'notifikasi',
                        'ruang' => null,
                        'preview' => '',
                        'time' => $notification->created_at->diffForHumans(),
                        'avatar' => null,
                        'highlighted' => !$notification->isRead(),
                    ];
            }
        });

        $unreadCount = $notificationsQuery->whereNull('read_at')->count();

        return view('notifikasi', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Notification $notification)
    {
        // Make sure user owns this notification
        if ($notification->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan',
            ], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca',
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca',
        ]);
    }
}

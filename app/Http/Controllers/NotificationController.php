<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    /**
     * menandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        if ($id === 'all') {
            Notification::where('user_id', $user->user_id)
                ->where('status', 'unread')
                ->update(['status' => 'read']);
            return response()->json(['success' => true]);
        } else {
            $notif = Notification::where('notification_id', $id)
                ->where('user_id', $user->user_id)
                ->firstOrFail();
            $notif->markAsRead();
            return back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
        }
    }
}

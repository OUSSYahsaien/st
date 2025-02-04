<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function getRevisionRequests()
    {
        $notifications = Auth::user()->unreadNotifications;
        return view('admin.revisions', compact('notifications'));
    }

    public function markAsRead($id)
    {
        Auth::user()
            ->notifications()
            ->where('id', $id)
            ->update(['read_at' => now()]);
            
        return back();
    }

    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones han sido marcadas como leídas.'
        ]);
    }
    
    
}

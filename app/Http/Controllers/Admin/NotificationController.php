<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
   public function index()
    {
        $notifications = Admin::find(Auth::guard('admin')->id())->notifications()->latest()->get();
        return view('admin.notifications', compact('notifications'));
    }

    public function markAsRead($notificationId)
    {
        $notification = Admin::find(Auth::guard('admin')->id())->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return redirect()->route('admin.notifications')->with('success', 'Notification marked as read.');
    }
}

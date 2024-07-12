<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    /**
     * Store a newly created notification in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'is_read' => $request->is_read ?? false,
        ]);

        return response()->json($notification, 201);
    }

    /**
     * Display a listing of the notifications by user ID.
     *
     * @param string $userId
     * @return \Illuminate\Http\Response
     */
    public function getByUserId($userId)
    {
        // Get all notifications for the given user ID
        $notifications = Notification::where('user_id', $userId)->with(['user', 'chapter', 'story'])->get();
        return  NotificationResource::collection($notifications);
    }

     /**
     * Mark a notification as read.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return response()->json(new NotificationResource($notification), 200);
    }
}

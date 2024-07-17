<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Log;

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
    public function storetoAdmin(Request $request)
    {
        // Tìm các người dùng có vai trò là admin
        $admins = User::where('role', 'admin')->get();
        Log::info($request->all());
        // Duyệt qua từng admin và tạo thông báo
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->user_id,
                'title' => $request->title,
                'message' => $request->message,
                'is_read' => $request->is_read ?? false,
                'chapter_id' => $request->chapter_id,
                'story_id' => $request->story_id,
            ]);
        }

        // Trả về phản hồi JSON
        return response()->json(['message' => 'Thông báo đã được gửi cho admin'], 201);
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
        $notifications = Notification::where('user_id', $userId)->with(['user',   'story' => function ($query) {
            $query->with([
                'chapters' => function ($query) {
                    $query->with(['chapterImages', 'comments', 'notifications']);
                },
                'categories',
                'author',
                'favouritedByUsers',
                'usersView'
            ]);
        },])->get();
        return  NotificationResource::collection($notifications);
    }
    public function getByAdminRole()
    {
        // Tìm các người dùng có vai trò là admin
        $admins = User::where('role', 'admin')->pluck('user_id');

        // Lấy danh sách các thông báo cho tất cả các người dùng admin
        $notifications = Notification::whereIn('user_id', $admins)
            ->with(['user', 'chapter', 'story'])
            ->get();

        return NotificationResource::collection($notifications);
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

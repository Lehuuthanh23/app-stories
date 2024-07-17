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
        $notifications = Notification::where('user_id', $userId)->with(['user', 'chapter', 'story'])->get();
        return  NotificationResource::collection($notifications);
    }
    public function getByAdminRole()
    {
        $admins = User::where('role', 'admin')->pluck('user_id');

        $notifications = Notification::whereIn('user_id', $admins)
            ->with(['user', 'chapter', 'story'])
            ->get();

        return NotificationResource::collection($notifications);
    }
    public function getNotificationsByAuthor($authorId)
    {
        // Kiểm tra xem người dùng có vai trò là tác giả hay không
        $author = User::where('user_id', $authorId)->where('role', 'author')->first();

        if (!$author) {
            return response()->json(["message" => "Người dùng không tồn tại hoặc không có vai trò là tác giả"], 404);
        }

        // Lấy tất cả các thông báo của tác giả này
        $notifications = Notification::where('user_id', $authorId)->with(['user', 'chapter', 'story'])->get();

        if ($notifications->isEmpty()) {
            return response()->json(["message" => "Không có thông báo nào"], 404);
        }

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
    public function destroy($notiID)
    {
        Notification::findOrFail($notiID)->delete();
        return response()->json(['message' => 'Xóa thành công'], 201);
        //return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('is_active')) {
            $query->where('is_active', $request->input('is_active'));
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        Log::info('Vao them');
        $user = new User();
        $user->user_id = $request->user_id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;
        $user->bio = $request->bio;
        $user->pen_name = $request->pen_name;
        $user->previous_works = $request->previous_works;
        $user->role = $request->role;
        if ($request->role == 'author') {
            $user->is_active = false;
        }
        $user->save();
        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'username' => 'sometimes|required|string|max:50|unique:users,username',
            'email' => 'sometimes|required|string|email|max:100|unique:users,email',
            'birth_date' => 'sometimes|required|date',
        ]);
        $user->update($validatedData);
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json(null, 204);
    }

    public function approveAuthor($id)
    {
        $user = User::where('user_id', $id)->first();
        if ($user) {
            $user->is_active = 1;
            $user->save();
            return response()->json(["message" => "Phê duyệt tác giả thành công"], 200);
        } else {
            return response()->json(["message" => "Tác giả không tồn tại"], 404);
        }
    }

    public function getNewUsers(Request $request)
    {
        $timePeriod = $request->input('time_period', 'week');
        $now = Carbon::now();

        if ($timePeriod === 'week') {
            $startDate = $now->subWeek();
        } elseif ($timePeriod === 'month') {
            $startDate = $now->subMonth();
        } else {
            return response()->json(['message' => 'Tham số time_period không hợp lệ. Chỉ chấp nhận "week" hoặc "month".'], 400);
        }

        $newUsersCount = User::where('created_at', '>=', $startDate)->count();
        return response()->json(['new_users_count' => $newUsersCount]);
    }
}

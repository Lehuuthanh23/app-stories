<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Story;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\StoryResource;

class FavouriteController extends Controller
{
    public function favouriteStory(Request $request)
    {
        $storyId = $request->story_id;
        $user = User::find($request->user_id);
        Log::info($user);
        if ($user->favouriteStories()->where('favourite_stories.story_id', $storyId)->exists()) {
            return response()->json(['message' => 'Bạn đã thích truyện này'], 400);
        }
        $user->favouriteStories()->attach($storyId);

        return response()->json(['message' => 'Thích truyện thành công'], 200);
    }
    public function getFavouriteStories(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], 404);
        }

        $favouriteStories = $user->favouriteStories()->with([
            'chapters' => function ($query) {
                $query->with(['chapterImages', 'comments', 'notifications']);
            },
            'categories',
            'author',
            'favouritedByUsers',
            'usersView'
        ])
        ->withCount('storyViews')
        ->get();

        return response()->json(['data' => StoryResource::collection($favouriteStories)], 200);
    }

    public function deleteFavourite(Request $request)
    {
        $storyId = $request->story_id;
        $user = User::find($request->user_id);
        if ($user->favouriteStories()->where('favourite_stories.story_id', $storyId)->exists()) {
            $user->favouriteStories()->detach($storyId);
            return response()->json(['message' => 'Bỏ thích truyện thành công'], 200);
        }

        return response()->json(['message' => 'Truyện này không có trong danh sách yêu thích của bạn'], 400);
    }
}

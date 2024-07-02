<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Story;
use Illuminate\Support\Facades\Log;

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
}

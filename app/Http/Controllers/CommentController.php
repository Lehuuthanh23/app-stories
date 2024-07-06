<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    //
    public function index(Request $request)
    {
        $commentsQuery = Comment::query();

        if ($request->has('chapter_id')) {
            $commentsQuery->where('chapter_id', $request->chapter_id);
        } elseif ($request->has('story_id')) {
            $commentsQuery->where('story_id', $request->story_id);
        }

        $comments = $commentsQuery->with('user')->with('chapter')->get();

        return CommentResource::collection($comments);
    }

    public function store(Request $request)
    {
        Log::info('Request Dâta', $request->all());
        $comment = new Comment();
        $comment->comment_id = $request->comment_id;
        $comment->story_id = $request->story_id;
        $comment->content = $request->content;
        $comment->user_id = $request->user_id;
        $comment->chapter_id = $request->chapter_id;
        $comment->save();

        return response()->json($comment, 201);
    }

    public function storeByStoryID(Request $request)
    {
        Log::info('Request Dâta', $request->all());
        $comment = new Comment();
        $comment->comment_id = $request->comment_id;
        $comment->story_id = $request->story_id;
        $comment->content = $request->content;
        $comment->user_id = $request->user_id;
        $comment->save();

        return response()->json($comment, 201);
    }
    public function destroy($comment_id)
    {
        Comment::findOrFail($comment_id)->delete();

        return response()->json(null, 204);
    }
}

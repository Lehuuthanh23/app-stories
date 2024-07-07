<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Story;
use App\Models\Image;
use App\Models\User;
use App\Models\Notification;
use App\Http\Resources\ChapterResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapters = Chapter::all();
        return ChapterResource::collection($chapters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $chapter = new Chapter();
        $chapter->story_id = $request->story_id;
        $chapter->title = $request->title;
        $chapter->content = '';
        $chapter->chapter_number = $request->chapter_number;
        $chapter->save();

        if ($request->hasFile('chapter_image')) {
            $files = $request->file('chapter_image');
            $mainFolder = $request->story_id;
            $storagePath = 'public/stories/' . $mainFolder . "/$request->chapter_number";

            // Đảm bảo thư mục tồn tại, nếu không sẽ tạo thư mục
            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }
            $count = 0;
            foreach ($files as $file) {
                $filename = $request->chapter_number . '_img_chapter_' . $count++ . '.' . 'jpg'; // Đổi tên file
                $path = $file->storeAs($storagePath, $filename);

                //Save image
                $image = new Image();
                $image->path = $path;
                $image->story_id = $request->story_id;
                $image->chapter_id = $chapter->chapter_id;
                $image->is_cover_image = false;
                $image->save();
                //

                Log::info('File stored at: ' . $path);
            }
        }


        $story = Story::find($chapter->story_id);
        $user = User::find($story->author_id);
        // Gửi thông báo cho người dùng yêu thích câu chuyện
        $favouriteUsers = DB::table('favourite_stories')
            ->where('story_id', $chapter->story_id)
            ->pluck('user_id');

        foreach ($favouriteUsers as $userId) {
            $notification = new Notification();
            $notification->user_id = $userId;
            $notification->title = $story->title;
            $notification->type = 'general';
            $notification->message = "$user->username đã cập nhật: Chapter $chapter->chapter_number";
            $notification->story_id = $chapter->story_id;
            $notification->chapter_id = $chapter->chapter_id;
            $notification->save();
        }
        return response()->json($chapter, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chapter = Chapter::find($id);
        if ($chapter) {
            return ChapterResource::collection($chapter->get());
        } else {
            return response()->json(['message' => 'Không có giá trị']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Chapter;
use Illuminate\Support\Facades\Log;


class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::all();
        return response()->json($stories);
    }

    public function store(Request $request)
    {
        $story = new Story();
        $story->title = $request->title;
        $story->author_id = $request->author_id;
        $story->summary = $request->summary;
        $story->active = 0;
        $story->save();

        // $chapter = new Chapter();
        // $chapter->



        if ($request->hasFile('chapter_image')) {
            $files = $request->file('chapter_image');
            $mainFolder = $story->story_id; 
            $storagePath = 'public/images/' . $mainFolder . '/1/';
        
            // Đảm bảo thư mục tồn tại, nếu không sẽ tạo thư mục
            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }
            $count = 0;
            foreach ($files as $file) {
                $filename = "1".'_img_chapter_' . $count++ . '.' . 'jpg'; // Đổi tên file
                $path = $file->storeAs($storagePath, $filename);
                Log::info('File stored at: ' . $path);
            }
        }

        if ($request->hasFile('license_image')) {
            $files = $request->file('license_image');
            $mainFolder = $story->story_id; 
            $storagePath = 'public/images/' . $mainFolder . '/license/';
        
            // Đảm bảo thư mục tồn tại, nếu không sẽ tạo thư mục
            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }
            $count = 0;
            foreach ($files as $file) {
                $filename = "$story->story_id".'_img_document_' . $count++ . '.' . 'jpg'; // Đổi tên file
                $path = $file->storeAs($storagePath, $filename);
                Log::info('File stored at: ' . $path);
            }
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $mainFolder = $story->story_id; 
            Log::info('Story id: ' . $mainFolder);
            $storagePath = 'public/images/'.$mainFolder . '/'; //. $mainFolder;
             // Đảm bảo thư mục tồn tại, nếu không sẽ tạo thư mục
            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }
            $path = $file->storeAs($storagePath, "$mainFolder"."_$story->title".'.jpg');
        }
        return response()->json($story, 201);
    }

    public function show($id)
    {
        return Story::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:users,user_id',
            'summary' => 'nullable|string',
        ]);

        $story->update($validatedData);

        return response()->json($story, 200);
    }

    public function destroy($id)
    {
        Story::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}

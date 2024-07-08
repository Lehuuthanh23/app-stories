<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\CommentController;

//user
Route::apiResource('users', UserController::class);

//stories
Route::apiResource('stories', StoryController::class);
Route::patch('/stories/approve/{id}', [StoryController::class, 'approveStory']);
Route::get('/total/storise', [StoryController::class, 'totalStories']);

//View story
Route::post('/story/view/{story_id}', [StoryController::class, 'addView']);
Route::get('/story/view/{story_id}', [StoryController::class, 'getTotalViews']);

//chapters
Route::apiResource('chapters', ChapterController::class);

//categories
Route::apiResource('categories', CategoryController::class);

//notification
Route::post('/notifications', [NotificationController::class, 'store']);
Route::get('/notifications/user/{userId}', [NotificationController::class, 'getByUserId']);
Route::patch('/notifications/read/{id}', [NotificationController::class, 'markAsRead']);

//favourite story
Route::post('/favourite-story', [FavouriteController::class, 'favouriteStory']);
Route::post('/delete-favourite-story', [FavouriteController::class, 'deleteFavourite']);

//comment
Route::apiResource('/comment', CommentController::class);
Route::post('/comments/bystory', [CommentController::class, 'storeByStoryID']);

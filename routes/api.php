<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FavouriteController;

//user
Route::apiResource('users', UserController::class);

//stories
Route::apiResource('stories', StoryController::class);
Route::patch('/stories/approve/{id}', [StoryController::class, 'approveStory']);

//chapters
Route::apiResource('chapters', ChapterController::class);

//categories
Route::apiResource('categories', CategoryController::class);

//notification
Route::post('/notifications', [NotificationController::class, 'store']);
Route::get('/notifications/user/{userId}', [NotificationController::class, 'getByUserId']);

//favourite story
Route::post('/favourite-story', [FavouriteController::class, 'favouriteStory']);


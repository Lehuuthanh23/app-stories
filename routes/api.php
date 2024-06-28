<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;

Route::apiResource('users', UserController::class);
Route::apiResource('stories', StoryController::class);
Route::apiResource('chapters', ChapterController::class);
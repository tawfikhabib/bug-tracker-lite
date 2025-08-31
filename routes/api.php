<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BugController;
use App\Http\Controllers\Api\ProjectController;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', function () {
    return User::all();
});

Route::apiResource('bugs', BugController::class);
Route::apiResource('projects', ProjectController::class);

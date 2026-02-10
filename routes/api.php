<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

Route::post('auth/login',[AuthController::class,'login']);
Route::post('auth/register',[AuthController::class,'register']);
Route::put('user/password',[UserController::class,'updatePassword']);


Route::middleware('auth:sanctum')->group(function (){
    Route::post('auth/logout',[AuthController::class,'logout']);
    Route::post('auth/refresh',[AuthController::class,'refresh']);

    Route::get('users',[UserController::class, 'index']);
    Route::get('user/profile',[UserController::class,'profile']);
    Route::put('user/profile',[UserController::class,'updateProfile']);
    Route::delete('user/profile',[UserController::class,'deleteProfile']);

    Route::post('posts',[PostController::class,'store']);
    Route::put('posts/{post}/edit',[PostController::class,'update']);
    Route::delete('posts/{post}/delete',[PostController::class,'delete']);

    Route::post('categories',[CategoryController::class,'store']);
    Route::put('categories/{category}/edit',[CategoryController::class,'update']);
    Route::delete('categories/{category}/delete',[CategoryController::class,'delete']);
});

Route::get('posts',[PostController::class,'index']);
Route::get('posts/{post}', [PostController::class,'show']);

Route::get('categories',[CategoryController::class,'index']);
Route::get('categories/{category}',[CategoryController::class,'show']);

<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::controller(PostController::class)->group(function(){
    Route::get('/posts','index');
    Route::get('/posts/{post}','show'); 
    Route::middleware('auth')->group(function(){
        Route::put('/posts/{post}','update');
        Route::post('/posts','store');
        Route::delete('/posts/{post}', 'destroy');
    });
});
Route::controller(CategoryController::Class)->group(function(){
    Route::get('/categories','index');
    Route::get('/categories/{category}','show');
    Route::middleware('auth')->group(function (){
        Route::post('/categories','store');
        Route::put('/categories/{category}','update');
        Route::delete('/categories/{category}','destroy');
        
    }); 
});
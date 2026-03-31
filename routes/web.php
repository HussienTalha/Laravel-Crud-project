<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index']);
Route::get('/users/{user}', [ProfileController::class, 'show']);

Route::controller(AdminController::class)->middleware(['auth', 'checkRole'])->group(function () {

    Route::get('/admin/dashboard', 'index')->name('dashboard');
    Route::put('/admin/{user}/makeAdmin', 'makeAdmin');
    Route::post('/admin/addUser', 'addUser');
    Route::delete('/admin/{user}/deleteAdmin', 'deleteAdmin');
    Route::delete('/admin/{user}/deleteUser', 'deleteUser');
});
// Route::get('/profile/{user}','show');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::controller(PostController::class)->group(function () {
    Route::get('/posts', 'index');
    Route::get('/posts/{post}', 'show');
    Route::middleware('auth')->group(function () {
        Route::put('/posts/{post}/edit', 'update');
        Route::post('/posts', 'store');
        Route::delete('/posts/{post}/delete', 'delete');
    });
});
Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
    Route::get('/categories/{category}', 'show');
    Route::middleware('auth')->group(function () {
        Route::post('/categories', 'store');
        Route::put('/categories/{category}/edit', 'update');
        Route::delete('/categories/{category}/delete', 'destroy');

    });
});
// Authentication Routes (BS5 Starter Kit)
Route::middleware('guest')->group(function () {
    Route::get('register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('register', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/');
    });

    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });

    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::get('reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile.edit');

    Route::post('logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

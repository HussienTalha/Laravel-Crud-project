<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index():RedirectResponse|View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $roles = ['admin', 'superAdmin'];
        if (in_array($user->role, $roles)) {
            $users = User::all();
            $users_count = $users->count();
            $categories = Category::all();
            $categories_count = $categories->count();

            return view('dashboard', compact('categories', 'categories_count', 'users', 'users_count'));
        }
        abort(  403,'not authorized');
    }

    public function makeAdmin(Request $request, User $user):RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->role == 'admin') {
            $user->update(['role' => 'admin']);

            return redirect('/admin/dashboard')->with('success', "user $user->name is now $user->role!");
        }
        abort(  403,'not authorized');
    }

    public function deleteAdmin(Request $request, User $user):mixed
    {
        /** @var \App\Models\User $AuthUser */
        $AuthUser = auth()->user();
        
        if ($AuthUser->role == 'admin') {
            $user->update(['role' => 'user']);
        return redirect('/admin/dashboard')->with('success', "user $user->name is now $user->role!");
        }

        abort(  403,'not authorized');
    }

    public function deleteUser(Request $request, User $user):RedirectResponse
    {
        /** @var \App\Models\User $AuthUser */
        $AuthUser = auth()->user();

        $roles = ['admin', 'superAdmin'];

        if (in_array($AuthUser->role, $roles) && $user->role == 'user') {
            $user->delete();
        return redirect('/admin/dashboard')->with('success', "user $user->name is now $user->role!");
        }
        abort(  403,'not authorized');
    }

    public function addUser(Request $request):RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $roles = ['admin', 'superAdmin'];
        if (in_array($user->role, $roles)) {

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['string', 'in:admin,user'],
            ]);
            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);

            return redirect('/admin/dashboard');

        }
        abort(  403,'not authorized');
    }
}

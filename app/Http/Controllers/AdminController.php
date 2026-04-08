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
            $usersCount = $users->count();
            $categories = Category::all();
            $categoriesCount = $categories->count();

            return view('dashboard', compact('categories', 'categoriesCount', 'users', 'usersCount'));
        }
        abort(  403,'not authorized');
    }

    public function makeAdmin(User $user):RedirectResponse
    {
        /** @var \App\Models\User $user */
        $authUser = auth()->user();

        if ($authUser?->role == 'admin') {
            $user->update(['role' => 'admin']);

            return redirect('/admin/dashboard')->with('success', "user $user->name is now $user->role!");
        }
        abort(  403,'not authorized');
    }

    public function deleteAdmin( User $user):mixed
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();
        
        if ($authUser->role == 'admin') {
            $user->update(['role' => 'user']);
        return redirect('/admin/dashboard')->with('success', "user $user->name is now $user->role!");
        }

        abort(  403,'not authorized');
    }

    public function deleteUser(User $user):RedirectResponse
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();

        $roles = ['admin', 'superAdmin'];

        if (in_array($authUser->role, $roles) && $user->role == 'user') {
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

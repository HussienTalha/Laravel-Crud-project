<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user):View
    {

        $posts = Post::where('user_id', $user->id)->latest()->paginate(9);
        $categories = Category::all();

        return view('user', compact('user', 'posts', 'categories'));
    }

    public function edit(Request $request) :View
    {
        $user =  $request->user();
        return view('profile', compact('user'));
        
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        // Set values - keep original if not provided
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            // Validate email uniqueness excluding current user
            $request->validate([
                'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            ]);
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        }

        // Check if any changes were made
        if ($user->isDirty()) {
            $user->save();

            return back()->with('success', 'Profile updated successfully');
        }

        return back()->with('info', 'No changes were made');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);


        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

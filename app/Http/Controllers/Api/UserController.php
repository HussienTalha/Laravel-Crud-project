<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index():JsonResponse
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        if ($user->role == 'admin') {
            $users = User::all();

            return response()->json([
                'users' => $users,
            ], 200);
        } else {
            return response()->json([
                'message' => 'unathorized',
            ], 403);
        }
    }

    public function profile(Request $request):JsonResponse
    {
        // $user = Auth::user->load(['posts.category:category_name']);
        /**
         * @var User $user
         */
        $user = $request->user();
        $posts = $user->posts()->with(['category:id,category_name'])->get();

        return response()->json(
            [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'abilities' => $user->currentAccessToken()->abilities,
                ],
                'posts' => $posts->map(function (Post $post , int $key) {
                   return [
                        'id' => $post->id,
                        'title' => $post->title,
                        'content' => $post->post,
                        'category' => $post->category ?[
                            'id' => $post->category->id,
                            'category name' => $post->category->category_name
                        ]:null,
                    ];
                }),
            ]);
    }

    public function updateProfile(Request $request):JsonResponse
    {

        /**
         * @var User $user
         * 
         */
        $user = Auth::user();
        $validated = $request->validate([
            'email' => 'email|unique:users|max:255|string',
            'name' => 'string|max:255',
            'password' => 'string|min:8|confirmed',
        ]);

        if (! Hash::check($validated['old_password'], $user->password)) {

            return response()->json([
                'message' => 'wrong password',
            ], 404);
        }

        User::where('id', '=', $user->id)->update($validated);

        return response()->json([
            'message' => 'profile updated!',
        ], 204);

    }


    public function deleteProfile(User $user):JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id == $user->id || $user->role == 'admin') {
            $user->delete();

            return response()->json([
                'message' => 'user deleted!',
            ], 204);
        }

        return response()->json([
            'message' => 'unauthorized',
        ], 403);
    }
}

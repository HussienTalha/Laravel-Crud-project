<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(){
        if (Auth::user()->role == 'admin'){
            $users = User::all();
            return response()->json([
                'users' => $users
            ],200);
        }
        else{
            return response()->json([
                'message' => 'unathorized'
            ],403);
        }
    }
    public function profile(Request $request){
        //$user = Auth::user->load(['posts.category:category_name']);
        $user = $request->user();
        $posts = $user->posts()->with(['category:id,category_name'])->get();
            return response()->json(
                [
                'user' => [
                  'name' => $user->name,
                  'email' => $user->email,
                  'role' => $user->role,
                  'abilities' => $user->currentAccessToken()->abilities
                ],
                'posts'=>$posts->map(function($post){[
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content,
                    'category' =>[
                    'id' => $post->category->id,
                    'category name' => $post->category->category_name
                    ]
                ];})
            ]);
      }
    public function updateProfile(Request $request){

        $validated = $request->validate([
            'email' => 'email|unique:users|max:255|string',
            'name' => 'string|max:255',
            'password' => 'string|min:8|confirmed'
        ]);

        if (!Hash::check($validated['old_password'],Auth::user()->password)){
                
                return response()->json([
                    'message' => 'wrong password',
                ],404);
        }

       User::where('id', '=', $request->user()->id)->update($validated);

       return response()->json([
        'message' => 'profile updated!'
       ], 204); 
    
       }

    public function updatePassword(Request $request){
        //review password reset from docs
    $validated = $request->validate([
            'password' => 'string|required|mix:6|confirmed',
            
        ]);
    }
    public function deleteProfile(User $user){
        if (Auth::user()->id == $user->id || Auth::user()->role == 'admin')
            {
                $user->delete();
                return response()->json([
                    'message' => 'user deleted!'
                ],204);
            }
            return response()->json([
                'message' => 'unauthorized'
            ],403);
    }
        
}

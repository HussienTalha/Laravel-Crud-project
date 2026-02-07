<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminte\validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
           'email' => 'required|string|exists', 
        ]);
         $user = User::where('id','=',$validated['email'])->first();
         if ($user){
         if(Hash::check($request->password, $user->password)){
            $token = $request->user()->createToken('login_token');
            return response()->json([
                'token' => $token->plainTextToken
            ],200);
         }
         }
         else {
            return response()->json([
                   'message'=> 'wrong email!'
            ],400);
         }

        
    }
    public function register(Request $request){
        $validated = $request->validate(
            [
                'email' => 'required|email|unique:users|string|max:255',
                'name' => 'required|string|max:255',
                'password' =>'string|require|min:6|confirmed'
            ]
        );
        $user = User::create([
            'email' => $validated->email,
            'name' => $validated->name,
            'password' => Hash::make($validated->password)
        ]
        );
        $token = $user->createToken('user_token');
        return response()->json([
            'token' => $user->plainTextToken
        ],201);
        
        

    }
    public function logout(Request $request){
        $token = $request->user()->currentAccesstoken()->delete();
        return response()->json([
            'message' => 'user logged out'
        ], 204);
    }
}

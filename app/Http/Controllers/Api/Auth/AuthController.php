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
        $credintials = $request->validate([
           'email' => 'required|email',
           'password' => 'required|min:8' 
        ]);
        
        if(!Auth::attempt($credintials)) {
            return response()->json([
                   'message'=> 'wrong credintials!'
            ],404);
        }
        $user = Auth::user();
        if ($user->role == 'admin')
            {
                $token = $user->createToken("$user->name token", ['actions on category']);
                return response()->json([
                    'user' => $user,
                    'token' => $token->plainTextToken
                ],200);
            }
        $token = $user->createToken("$user->name token");
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ],200);

        
    }
    public function register(Request $request){
        $validated = $request->validate(
            [
                'email' => 'required|email|unique:users|string|max:255',
                'name' => 'required|string|max:255',
                'password' =>'string|required|min:6|confirmed'
            ]
        );
        $user = User::create([
            'email' => $validated['email'],
            'name' => $validated['name'],
            'password' => Hash::make($validated['password'])
        ]
        );
        if ($user->role == 'admin')
            {
                $token = $user->createToken("$user->name token",  ['Actions on Post','Actions on Category','Actions on User']);
                return response()->json([
                    'user' => $user,
                    'token' => $token->plainTextToken,
                    'abilities' => $user->currentAccessToken()->abilities
                ],200);
            }
        $token = $user->createToken("$user->name toke", []);
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
            'abilities' => $user->currentAccessToken()->abilities
        ],200);
        
        

    }
    public function logout(Request $request){
        $token = $request->user()->currentAccesstoken()->delete();
        return response()->json([
            'message' => 'user logged out'
        ], 204);
    }
}

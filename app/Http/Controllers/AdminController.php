<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Category;

class AdminController extends Controller
{
    public function index(){
         $roles = ['admin', 'superAdmin'];    
        if(in_array(auth()->user()->role,$roles)){
            $users = User::all();
            $users_count = $users->count();
            $categories = Category::all();
            $categories_count = $categories->count();
            return view('dashboard',compact('categories','categories_count','users','users_count'));
        }
        }
    
    public function makeAdmin(Request $request , User $user){
        if (Auth::user()->role =='admin'){
            $user->update(['role'=>'admin']);
        return redirect()->route('/admin/dashboard')->with('success', "user $user->name is now $user->role!");
        }
    }
    
    public function deleteAdmin(Request $request, User $user)
    {
        if ($request->user()->role =='admin'){
            $user->update(['role'=> 'user']);
        }
        return redirect()->route('/admin/dashboard')->with('success',"user $user->name is no longer admin!");
    }

    public function deleteUser(Request $request, User $user){
        $roles = ['admin, superAdmin'];

        if (in_array($request->user()->role, $roles) && $user->role =='user'){
            $user->delete();
        }
        return redirect()->route('/admin/dashboard')->with('success',"user $user->name is deleted!");
    }
    public function addUser(Request $request){
    $roles = ['admin', 'superAdmin'];    
        if(in_array(auth()->user()->role,$roles)){

        $validated= $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' =>['required','confirmed',Rules\Password::defaults()]
        ]);
        $user =User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        return redirect()->route('/admin/dasboard');

    }
    }
}

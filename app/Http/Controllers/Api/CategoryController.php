<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $categories = Category::all();
       return response()->json($categories ,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->role =='admin'){
        $validated = $request->validate(
            [
                'category_name' => "required|string|unique",
            ]
        );
        $validated['category_name'] = ucwords($validated['category_name']);
        Category::create($validated);
        return response()->json([
            'message' =>'category created!'
        ],201);
        }
        else{
            return response()->json([
                'message' => 'Unauthorized!'

            ],403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $category->load(['posts:id,title,user_id,category_id','posts.user:id,name']);
       // $category_posts = $category->posts()->with(['user:id,name'])->get();
        $formated_category =[
             'id' => $category->id,   
             'category name' => $category->category_name,
             
             'posts' =>$category->posts->map(function($post){
                return [
                'title' => $post->title,
                'id' => $post->id,
                'author' =>[
                    'id' => $post->user_id,
                    'name' =>$post->user->name
                ]
             ];
             })
             ];
        
        return response()->json($formated_category,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($request->user()->role == 'admin'){
        $validated = $request->validate(
            [
                'category_name' => 'required|unique'   
            ]
        );
        $post->update($validated);
        return response()->json([
               'message' => 'category updated!',
        ],204);
        }
        return response()->json([
            'message' => 'unauthorized!'
        ],403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Post $post)
    {
        if (Auth::user()->role =='admin'){
        $post->delete();
        return response()->json([
               'message' => 'category deleted !',
        ],201);
        }
        return response()->json([
            'message' => 'unauthorized!'
        ],403);
    }
}

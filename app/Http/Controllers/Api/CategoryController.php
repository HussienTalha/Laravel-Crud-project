<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

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
        $validated = $request->validate(
            [
                'category_name' => "required|string|unique",
            ]
        );
        $validated['category_name'] = ucwords($validated['category_name']);
        Category::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $category->load(['posts:title,id,user_id','posts.user:name']);
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
             ];})
             ];
        
        return response()->json($formated_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate(
            [
                'category_name' => 'required|unique'   
            ]
        );
        $post->update($validated);
        return response()->json([
               'message' => 'category updated!',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
               'message' => 'category deleted !',
        ],200);
    }
}

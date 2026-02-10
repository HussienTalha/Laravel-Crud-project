<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $posts = Post::with(['user:name','categories:category_name'])->get();
        return $posts; 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|',
                'post' => 'required|string',
                'category_id' => 'required',
            ]);

        auth()->user()->posts()->create($validated + ['status' => 'created']);

                
        return redirect('/')->with('success','post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
       {
        $post =  $post->load(['user:name,email','category:category_name']);
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $posts)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update',$post);
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'post' => 'required|string',
                'category' => 'required'
            ]
        );
        $post->update($validated + ['status' => 'edited']);
        return redirect('/')->with('success','post updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize( 'destroy',$post);
        $post->delete();
        return redirect('/')->with('success', 'post deleted');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user:id,name', 'category:id,category_name'])->latest()->paginate(9);
        $categories = Category::all();

        return view('home', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate(
            [
                'title' => 'required|string|',
                'post' => 'required|string',
                'image' => 'image',
                'category_id' => 'required',
            ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store(options: 'public');

        }

        auth()->user()->posts()->create($validated + ['status' => 'created']);

        return redirect('/')->with('success', 'post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $post->load(['user:id,name,email', 'category:id,category_name']);
        $categories = Category::all();

        return view('post', compact('post', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $posts) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'post' => 'required|string',
                'category_id' => 'required',
            ]
        );
        $post->update($validated + ['status' => 'edited']);

        return redirect('/')->with('success', 'post updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);
        // if ($post->user->role == 'admin'|| auth()->user()->id == $post->user_id);
        $post->delete();

        return redirect('/')->with('success', 'post deleted');
    }
}

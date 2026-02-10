<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user:id,name','category:id,category_name'])->get();
        $formantted_posts = $posts->map(function ($post){
            return [
                'title' => $post->title,
                'content' => $post->post,
                'user_id' => $post->user_id,
                'category' => [
                  'name' => $post->category->category_name,
                  'id' =>  $post->category_id
                ],
                'author' =>[
                    'name' => $post->user->name,
                    'id' => $post->user_id
                ]

            ];
        });
        return response()->json($formantted_posts,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
           $validated = $request->validate(
            [
                'title' => 'required|string',
                'post' => 'required|string',
                'category_id' =>'required|int|exists:categories,id',
                
            ],
            [
                'title.required' => 'title is required',
                'post.required' => 'post is required',
                'category_id.required' => 'choose category for the post',
                'category_id.exists' => 'the category you chose does not exist',
            ]
           );
        }
        catch(ValidationException $e){
            return response()->json(
                [
                    'message' => 'validation failed',
                    'erros' => $e->errors()
                ], 422);
        }
         $post =  Post::create($validated + [
           'user_id' => $request->user()->id, 
           'status' => 'created'
           ]);
        return response()->json([
            'post' => $post->id,
            'message' => 'post created',
            
        ],201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $post->load(['user:id,name','category:id,category_name']);
        return response()->json(
            [
                'title' => $post->title,
                'post' => $post->post,
                'author' => [
                    'id' => $post->user_id,
                    'name' =>$post->user->name
                ],
                'category' => [
                'category_id' => $post->category_id,
                'category_name' => $post->category->category_name
            ]
            ]
            ,200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (! $request->user()->id == $post->user_id){
            return response()->json([

                'message' => 'unauthorized!'
            ],403);
        }
           $validated = $request->validate(
            [
                'title' => 'required|string',
                'post' => 'required|string',
                'category_id' =>'required|int|exists:categories,id',
            ],
            [
                'title.required' => 'title is required',
                'post.required' => 'post is required',
                'category_id.required' => 'choose category for the post',
                'category_id.exists' => 'the category you chose does not exist',
            ]
           );
        $post = $post->update($validated + ['status' => 'edited']);
        return response()->json([
                'message' => 'post edited!'
        ],201);
    }

        //
    public function delete(Post $post)
    {
        if (! Auth::user()->id == $post->user_id || Auth::user()->role == 'admin'){
            return response()->json([

                'message' => 'unauthorized!'
            ],403);
        }
        $post->delete();
        return response()->json(
            [
                'message' => 'post deleted!'
            ],
        201);
    }
}

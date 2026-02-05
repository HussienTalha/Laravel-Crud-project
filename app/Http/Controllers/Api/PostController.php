<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user:name','category:category_name'])->get();
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
                'category_id' =>'required|int',
                'user_id' => 'required|int'
            ],
            [
                'title.required' => 'title is required',
                'post.required' => 'post is required',
                'category_id.required' => 'choose category for the post',
                'category_id.exists' => 'the category you chose does not exist',
                'user_id.required' => 'the use id is required',
                'user_id.exists' => 'this user is not registered'
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
           Post::create($validated + ['status' => 'created']);
        return response()->json([
            'message' => 'post created',
            
        ],200);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $post->load(['user:name,id','categories:category_name'])->get();
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
                'category_name' => $post->category_name
            ]
            ]
            ,200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try{
           $validated = $request->validate(
            [
                'title' => 'required|string',
                'post' => 'required|string',
                'category_id' =>'required|int|exists:posts,category_id',
                'user_id' => 'required|int|exists:posts,user_id'
            ],
            [
                'title.required' => 'title is required',
                'post.required' => 'post is required',
                'category_id.required' => 'choose category for the post',
                'category_id.exists' => 'the category you chose does not exist',
                'user_id.required' => 'the use id is required',
                'user_id.exists' => 'this user is not registered'
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
        $post->update($validated + ['status' => 'edited']);
        return Response()->json([
                'message' => 'post edited!'
        ]
        );
    }

        //
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(
            [
                'message' => 'post deleted!'
            ],
        204);
    }
}

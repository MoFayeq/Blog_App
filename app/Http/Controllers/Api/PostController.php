<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, Category $category)
    {
        $post = Post::create($request->validated());

        return response()->json([
            'post' => $post,
            'message' => 'created successfully',
            'status' => Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category, Post $post)
    {
        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Category $category , Post $post)
    {
        $post->update($request->validated());

        return response()->json([
            'post' => $post,
            'message' => 'updated successfully',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Post $post)
    {
        $post->delete();

        return response()->json([
           'message' => 'deleted successfully',
           'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::with(['category'])->where('is_published', true)->get();

        return PostResource::collection($posts);
    }

    public function show(Post $post): PostResource
    {
        $post->loadMissing(['category', 'author']);

        return PostResource::make($post);
    }
}

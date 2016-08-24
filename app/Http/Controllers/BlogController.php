<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class BlogController extends Controller
{
    //
    public function index()
    {
        $posts = Post::where('published_at','<=',Carbon::now())
            ->orderBy('published_at','desc')
            ->paginate(config('blog.posts_per_page'));

        return view('blog.index', compact(('posts')));
    }

    /**
     * @api {get} /blog/{slug}
     * @apiName showPost
     * @apiGroup blog
     * @apiDescription 展示索引{slug}的博客
     */
    public function showPost($slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        return view('blog.post')->withPost($post);
    }
}

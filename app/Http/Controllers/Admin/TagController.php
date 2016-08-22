<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    //
    protected $fields = [
        'tag' => '',
        'title' => '',
        'subtitle' => '',
        'page_image' => '',
        'meta_description' => '',
        'layout' => 'blog.layouts.index',
        'reverse_direction' => 0,
    ];
    //替换index方法如下
    public function index()
    {
        $tags = Tag::all();
        return view('admin.tag.index')->withTags($tags);
    }

    //替换create() 方法如下
    /**
     * Show form for creating new tag
     */
    public function create()
    {

    }
}

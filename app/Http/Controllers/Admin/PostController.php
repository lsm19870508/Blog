<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\PostFormFields;
use App\Models\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.post.index')
            ->withPosts(Post::all());
    }

    /**
     * Show the post form
     */
    public function create()
    {
        $data = $this->dispatch(new PostFormFields());

        return view('admin.post.create',$data);
    }

    /**
     * Store a newly created Post
     *
     * @param PostCreateRequest $request
     */
    public function store(Requests\Admin\Blog\PostCreateRequest $request)
    {
        $post = Post::create($request->postFillData());
        $post->syncTags($request->get('tags',[]));

        return redirect()->route('admin.post.index')->withSuccess('New Post Successfully Created.');
    }

    /**
     * Show the post edit form
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = $this->dispatch(new PostFormFields($id));

        return view('admin.post.edit',$data);
    }

    /**
     * Update the Post
     *
     * @param PostUpdateRequest $request
     * @param int $id
     */
    public function update(Requests\Admin\Blog\PostUpdateRequest $request,$id)
    {
        $post = Post::findOrFail($id);
        $post->fill($request->postFillData());
        $post->save();
        $post->syncTags($request->get('tags',[]));

        if ($request->action === 'continue') {
            return redirect()
                        ->back()
                        ->withSuccess('Post saved.');
        }

        return redirect()
                        ->route('admin.post.index')
                        ->withSuccess('Post saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        return redirect()
                        ->route('admin.post.index')
                        ->withSuccess('Post deleted.');
    }
}

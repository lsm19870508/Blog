<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\TagCreateRequest;

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

    /**
     * @api {get} /admin/tag/index
     * @apiName index
     * @apiGroup tag
     * @apiDescription 展示Tag的默认展示页
     */
    public function index()
    {
        $tags = Tag::all();
        return view('admin.tag.index')->withTags($tags);
    }

    /**
     * @api {get} /admin/tag/create
     * @apiName create
     * @apiGroup tag
     * @apiDescription 创建Tag的页面展示
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field,$default);
        }

        return view('admin.tag.create',$data);
    }

    /**
     * @api {post} /admin/tag/store
     * @apiName store
     * @apiGroup tag
     * @apiDescription 创建Tag的页面展示
     * @apiParam {String} Tag 标签名.
     * @apiParam {String} Title 标签标题.
     * @apiParam {String} subtitle 标签子标题.
     * @apiParam {String} meta_description 标签描述.
     * @apiParam {String} page_image 标签页图片链接.
     * @apiParam {String} page_image 标签页模板.
     * @apiParam {Number} reverse_direction 标签方向.
     * @apiSuccess {String} success 对应标签名创建成功
     */
    public function store(TagCreateRequest $request)
    {
        $tag = new Tag();
        foreach (array_keys($this->fields) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();

        return redirect('/admin/tag')
                    ->withSuccess("The tag '$tag->tag' was created.");
    }

    /**
     * @api {get} /admin/tag/edit
     * @apiName edit
     * @apiGroup tag
     * @apiDescription Tag的编辑页面展示
     * @apiParam {Number} id 标签id.
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field,$tag->$field);
        }

        return view('admin.tag.edit',$data);
    }

    /**
     * @api {get} /admin/tag/update
     * @apiName update
     * @apiGroup tag
     * @apiDescription Tag的编辑更新api
     * @apiParam {String[]} Request 请求用数组.
     * @apiParam (Request){String} Tag 标签名.
     * @apiParam (Request){String} Title 标签标题.
     * @apiParam (Request){String} subtitle 标签子标题.
     * @apiParam (Request){String} meta_description 标签描述.
     * @apiParam (Request){String} page_image 标签页图片链接.
     * @apiParam (Request){String} page_image 标签页模板.
     * @apiParam {Number} id 标签id.
     * @apiSuccess {String} success 对应标签名更新成功
     */
    public function update(Requests\Admin\Tag\TagUpdateRequest $request,$id)
    {
        $tag = Tag::findOrFail($id);

        foreach (array_keys(array_except($this->fields,['tag'])) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();

        return redirect("/admin/tag/$id/edit")
            ->withSuccess("Changes saved.");
    }

    /**
     * @api {get} /admin/tag/destroy
     * @apiName destroy
     * @apiGroup tag
     * @apiDescription 根据id删除Tag
     * @apiParam {Number} id 标签id.
     * @apiSuccess {String} success 对应标签删除成功
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect('admin/tag')
            ->withSuccess("The '$tag->tag' tag has been deleted.");
    }
}


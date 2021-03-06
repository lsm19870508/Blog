<?php

namespace App\Http\Requests\Admin\Blog;

use App\Http\Requests\Request;
use Carbon\Carbon;

class PostUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Return the fields and values to create a new post from
     * @Description 添加了一个 postFillData() 方法，使用该方法可以轻松从请求中获取数据填充 Post 模型。
     */
    public function postFillData()
    {
        $published_at = new Carbon(
            $this->publish_date . ' ' . $this->publish_time
        );
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'page_image' => $this->page_image,
            'content_raw' => $this->get('content'),
            'meta_description' => $this->meta_description,
            'is_draft' => (bool)$this->is_draft,
            'published_at' => $published_at,
            'layout' => $this->layout,
        ];
    }
}

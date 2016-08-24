<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag','title','subtitle','meta_description','page_image','layout','reverse_direction'];

    /**
     * 定义文章与标签之间多对多的关联关系
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post','post_tag_pivot');
    }

    /**
     * Add any tags needed from the list
     *
     * @param array $tags List of tags to check/add
     */
    public static function addNeededTags(array $tags)
    {
        if (count($tags) === 0) {
            return ;
        }

        $found = static::whereIn('tag',$tags)->lists('tag')->all();

        foreach (array_diff($tags,$found) as $tag) {
            static::create(['tag' => $tag,
                            'title' => $tag,
                            'subtitle' => 'Subtitle for '.$tag,
                            'page_image' => '',
                            'meta_description' => '',
                            'reverse_direction' => false,
            ]);
        }
    }
}

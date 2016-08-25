<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/23
 * Time: 10:49
 */

/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024,$factor)) . @$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/**
 * Return "checked" if true
 */
function checked($value)
{
    return $value ? 'checked' : '';
}

/**
 * Return image url for headers
 */
function page_image($value = null)
{
    if (empty($value)) {
        $value = config('blog.page_image');
    }

    //starts_with 函数判断给定字符串是否以给定值开头：
    if (! starts_with($value, 'http') && $value[0] !== '/') {
        $value = config('blog.uploads.webpath') . '/' . $value;
    }

    return $value;
}
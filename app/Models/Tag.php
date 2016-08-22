<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag','title','subtitle','meta_description','page_image','layout','reverse_direction'];
}

<?php

namespace App\Models;

class ImageThumb extends BaseModel
{
    protected $table = 'image_thumbs';

    protected $fillable = [
        'item_id',
        'image',
        'type',
        'is_avatar',
    ];
}

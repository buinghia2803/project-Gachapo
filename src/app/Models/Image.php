<?php

namespace App\Models;

class Image extends BaseModel
{
    protected $table = 'images';

    protected $fillable = [
        'item_id',
        'image',
        'type',
        'is_avatar',
    ];
}

<?php

namespace App\Models;

class Page extends BaseModel
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'status',
        'type',
    ];

    public $sortable = [
        'id',
        'status',
    ];
}

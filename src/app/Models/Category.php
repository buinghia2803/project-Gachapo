<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public $sortable = [
        'id',
        'created_at',
    ];
}

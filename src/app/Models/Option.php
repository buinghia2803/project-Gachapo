<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Option extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value'
    ];
}

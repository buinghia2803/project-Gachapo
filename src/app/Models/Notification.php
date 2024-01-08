<?php

namespace App\Models;

class Notification extends BaseModel
{
    protected $table = 'notifies';

    protected $fillable = [
        'title',
        'content',
        'start_time',
        'end_time',
        'type',
        'status',
    ];

    public $sortable = [
        'id',
        'name'
    ];
}

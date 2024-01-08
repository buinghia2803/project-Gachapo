<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_type',
        'email',
        'phone',
        'inquiry_type',
        'content'
    ];

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
    ];

    public $selectable = [
        '*',
    ];
}

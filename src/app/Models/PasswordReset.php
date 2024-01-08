<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $primaryKey = 'email';

    const UPDATED_AT = NULL;

    public $selectable = [
        '*',
    ];

    protected $fillable = [
        'id',
        'email',
        'secret_key',
        'expire_time'
    ];
}

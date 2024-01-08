<?php

namespace App\Models;

class UserRole extends BaseModel
{
    protected $table = 'user_role';

    protected $fillable = [
        'user_id',
        'role_id'
    ];
}

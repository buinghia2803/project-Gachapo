<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    public function getName()
    {
        return $this->name ?? null;
    }

    public function getImage()
    {
        return asset($this->attachment);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Banner extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'link',
        'attachment',
        'type',
    ];

    public function getImage()
    {
        return asset($this->attachment);
    }

    public function getName()
    {
        return $this->title ?? null;
    }

    public function getLink()
    {
        return $this->link ?? null;
    }

    public function getDisplayText()
    {
        return __(config('options.banner_type_show')[$this->type_show]);
    }
}

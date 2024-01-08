<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    protected $softDelete = true;

    protected $fillable = [
        'name',
        'gacha_id',
        'quantity',
        'attachment',
        'reward_percent',
        'reward_type',
        'reward_status',
        'status'
    ];

    public $sortable = [
        'name',
        'quantity',
        'reward_percent',
    ];

    /**
     * Relation with gacha.
     */
    public function gacha()
    {
        return $this->belongsTo(Gacha::class);
    }

    /*
    * get image url
     */
    public function getImage()
    {
        if ($this->attachment) {
            if (str_contains($this->attachment, 'http') == false) {
                return asset(\App\Helpers\UploadHelper::getUrlImage($this->attachment));
            } else {
                return asset($this->attachment);
            }
        }
        return asset('images/image-default.png');
    }
}

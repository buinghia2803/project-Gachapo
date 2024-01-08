<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gacha extends BaseModel
{
    use HasFactory;

    protected $softDelete = true;

    protected $fillable = [
        'name',
        'category_id',
        'company_id',
        'selling_price',
        'discounted_price',
        'discounted_percent',
        'postage',
        'status_apply_discounts',
        'status_operation',
        'status',
        'period_start',
        'period_end',
        'description',
        'recommend',
        'reject_reason'
    ];

    public $sortable = [
        'id',
        'name',
        'period_start',
        'orders_count',
        'period_end',
        'created_at',
        'updated_at',
    ];
    public $selectable = [
        '*'
    ];

    /**
     * Relation with product.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relation with category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation with company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation with gachapo_image
     */
    public function images()
    {
        return $this->hasMany(GachaImage::class);
    }

    /**
     * Relation with order
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relation with favorites
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Relation with user
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getThumb()
    {
        $thumb = $this->images->first();
        if ($thumb != null) {
            if (str_contains($thumb->attachment, 'http') == false) {
                return asset(\App\Helpers\UploadHelper::getUrlImage($thumb->attachment));
            } else {
                return asset($thumb->attachment);
            }
        }

        return asset('images/image-default.png');
    }

    public function getOperationStatus()
    {
        $curentTime = time();
        if (strtotime($this->period_start) > $curentTime || $curentTime > strtotime($this->period_end)) {
            return GACHA_OPERATION_STOP_SALE;
        }
        return $this->status_operation;
    }
}

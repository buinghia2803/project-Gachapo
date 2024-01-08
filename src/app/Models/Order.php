<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'gacha_id',
        'user_id',
        'coupon_id',
        'coupon_price',
        'quantity',
        'gacha_price',
        'address_delivery',
        'status_deliver',
        'date_of_shipment',
    ];

    public $sortable = [
        'id',
        'created_at',
        'date_of_shipment',
        'status_deliver',
    ];
    public $selectable = [
        '*'
    ];

    /**
     * Relation with review.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Relation with gacha.
     */
    public function gacha()
    {
        return $this->belongsTo(Gacha::class);
    }

    public function getAmount()
    {
        return ($this->gacha_price * $this->quantity) - $this->coupon_price;
    }

    /**
     * Relation with order detail.
    */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Relation with user.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation with coupon.
    */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}

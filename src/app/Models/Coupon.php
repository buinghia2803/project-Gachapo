<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'discount_amount',
        'discount_rate',
        'type_discount',
        'period_start',
        'period_end',
    ];

    public $sortable = [
        'id',
        'created_at',
    ];

    /**
     * Relation with order.
    */
    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'status_receiving',
        'updated_at',
        'created_at',
    ];

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
    ];
    public $selectable = [
        '*'
    ];

    /**
     * Relation with product.
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relation with order.
    */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $softDelete = true;

    protected $fillable = [
        'order_id',
        'content',
        'rating',
        'content_reply',
        'date_reply',
        'status',
        'user_id'
    ];

    public $sortable = [
        'id',
        'status',
        'rating',
        'created_at',
        'updated_at',
    ];

    /**
     * Relation with order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCreditCard extends Model
{
    use HasFactory;

    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_number',
        'stripe_card_id',
        'card_name',
        'fingerprint',
        'date_of_expiry',
    ];

    /**
     * The attributes that can be order by.
     *
     * @var array
     */
    public $sortable = [
        'date_of_expiry',
        'card_name'
    ];

    public $selectable = [
        '*',
    ];
}

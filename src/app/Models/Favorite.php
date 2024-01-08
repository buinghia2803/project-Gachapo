<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $softDelete = true;

    protected $fillable = [
        'user_id',
        'gacha_id'
    ];

    public $sortable = [
        'id',
        'user_id',
        'gacha_id',
        'created_at',
        'updated_at',
    ];
    public $selectable = [
        'id',
        'user_id',
        'gacha_id'
    ];

    /**
     * Relation with gacha.
     */
    public function gachas()
    {
        return $this->belongsToMany(Gacha::class);
    }
}

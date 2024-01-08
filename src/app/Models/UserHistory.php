<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    use HasFactory;

    protected $table = 'user_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'gacha_id'
    ];

    /**
     * The attributes that can be order by.
     *
     * @var array
     */
    public $sortable = [
        'id',
        'email',
        'status'
    ];

    public $selectable = [
        '*',
    ];

    public function gacha()
    {
        return $this->belongsTo(Gacha::class);
    }
}

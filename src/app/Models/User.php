<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $guard_name = 'api';

    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'name_furigana',
        'customer_id',
        'birthday',
        'phone',
        'category_id',
        'gender',
        'profession',
        'address_first',
        'address_second',
        'address_type',
        'status',
        'status_two_step_verification',
        'status_notifice',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

    public function creditCard()
    {
        return $this->hasOne(UserCreditCard::class);
    }

    public function histories()
    {
        return $this->hasMany(UserHistory::class);
    }
}

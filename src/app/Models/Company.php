<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Authenticatable
{
    use SoftDeletes;

    protected $guard = ROLE_COMPANY;

    protected $fillable = [
        'company',
        'company_furigana',
        'person_manager',
        'person_manager_furigana',
        'phone',
        'email',
        'password',
        'company_information',
        'site_url',
        'company_address',
        'registered_copy_attachment',
        'consent_document',
        'bank_name',
        'branch_name',
        'bank_code',
        'branch_code',
        'bank_type',
        'bank_number',
        'bank_holder',
        'commission',
        'status_two_step_verification',
        'status_notifice',
        'status',
        'status_approve',
    ];

    public $sortable = [
        'id',
        'status',
        'status_approve',
        'created_at',
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
     * Relation with gachas
     */
    public function gachas()
    {
        return $this->hasMany(Gacha::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'shop_name',
        'slug',
        'owner_name',
        'email',
        'phone',
        'nic',
        'address',
        'district',
        'province',
        'bank_name',
        'branch_name',
        'account_name',
        'account_number',
        'logo',
        'banner',
        'nic_front',
        'nic_back',
        'business_registration',
        'approved_at',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
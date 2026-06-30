<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\VendorEarning;
use App\Models\VendorCommission;

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
        'status',
        'description',
        'found_year'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }


    public function earnings()
    {
        return $this->hasMany(VendorEarning::class);
    }

    public function commissions()
    {
        return $this->hasMany(VendorCommission::class);
    }
}
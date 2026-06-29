<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        // prevent duplicate insert
        if (Vendor::where('id', 1)->exists()) {
            return;
        }

        Vendor::create([
            'id' => 1,

            'shop_name'   => 'Autoparthubsl',
            'slug'        => Str::slug('Autoparthubsl'),

            'owner_name'  => 'Kasthuri Dhananjaya',
            'email'       => 'ruwindi2819@gmail.com',
            'phone'       => '0716316143',
            'nic'         => '200073203633',

            'address'     => 'Ridigama',
            'district'    => 'Kurunegala',
            'province'    => 'North Western',

            'bank_name'   => null,
            'branch_name' => null,
            'account_name'=> null,
            'account_number' => null,

            'logo'        => null,
            'banner'      => null,
            'nic_front'   => null,
            'nic_back'    => null,
            'business_registration' => null,

            'password'    => Hash::make('12345678'),

            'status'      => 'Approved',
            'approved_at' => now(),
        ]);
    }
}
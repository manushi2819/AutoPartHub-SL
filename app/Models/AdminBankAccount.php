<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminBankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'branch',
        'account_name',
        'account_number',
        'is_default',
        'notes',
    ];

    public function admin()
    {
        return $this->belongsTo(AdminUser::class);
    }
}
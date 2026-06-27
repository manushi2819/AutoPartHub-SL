<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {

            $table->id();

            $table->string('shop_name');
            $table->string('slug')->unique();
            $table->string('owner_name');

            $table->string('email')->unique();
            $table->string('phone');
            $table->string('nic')->unique();

            $table->text('address');
            $table->string('district');
            $table->string('province');

            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();

            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            $table->string('nic_front')->nullable();
            $table->string('nic_back')->nullable();
            $table->string('business_registration')->nullable();

            $table->enum('status', ['Pending','Approved','Rejected','Suspended'])
                  ->default('Pending');

            $table->timestamp('approved_at')->nullable();

            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
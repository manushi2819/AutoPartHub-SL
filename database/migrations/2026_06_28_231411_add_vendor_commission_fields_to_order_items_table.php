<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            $table->decimal('vendor_percentage', 5, 2)
                  ->nullable()
                  ->after('vendor_id');

            $table->decimal('vendor_commission_amount', 12, 2)
                  ->nullable()
                  ->after('vendor_percentage');

            $table->decimal('vendor_earning_amount', 12, 2)
                  ->nullable()
                  ->after('vendor_commission_amount');

            $table->string('status')->default('pending')->after('subtotal');
            $table->string('payment_status')->default('pending')->after('status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            $table->dropColumn([
                'vendor_percentage',
                'vendor_commission_amount',
                'vendor_earning_amount',
            ]);

        });
    }
};
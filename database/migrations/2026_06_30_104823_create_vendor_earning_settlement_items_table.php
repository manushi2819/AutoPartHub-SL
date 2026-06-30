<?php
// create_vendor_earning_settlement_items_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vendor_earning_settlement_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id')->constrained('vendor_earning_settlements')->cascadeOnDelete();
            $table->foreignId('vendor_earning_id')->constrained('vendor_earnings')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(
                ['settlement_id', 'vendor_earning_id'],
                'vesi_settle_vendor_unique'
            );
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_earning_settlement_items');
    }
};
<?php
// create_vendor_commission_settlement_items_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vendor_commission_settlement_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id')->constrained('vendor_commission_settlements')->cascadeOnDelete();
            $table->foreignId('vendor_commission_id')->constrained('vendor_commissions')->cascadeOnDelete();
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_commission_settlement_items');
    }
};
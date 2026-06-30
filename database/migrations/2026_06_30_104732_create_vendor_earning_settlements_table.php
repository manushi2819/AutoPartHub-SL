<?php
// create_vendor_earning_settlements_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vendor_earning_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->decimal('total_amount', 12, 2);
            $table->string('transfer_reference')->nullable();
            $table->string('payment_slip')->nullable(); 
            $table->date('period_start');
            $table->date('period_end');
            $table->unsignedBigInteger('paid_by'); 
            $table->timestamp('paid_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_earning_settlements');
    }
};
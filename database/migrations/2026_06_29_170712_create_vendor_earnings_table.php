<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendor_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('order_item_id')->unique()->constrained('order_items')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            $table->string('payment_method'); // snapshot: 'card' or 'cod' at time of order
            $table->decimal('earning_amount', 10, 2);

            // pending        = card order, admin still needs to bank transfer this to vendor
            // paid           = admin has transferred this earning to vendor
            // self_collected = COD order, vendor already collected the cash themselves
            // cancelled      = order/item was cancelled or payment failed
            $table->enum('status', ['pending', 'paid', 'self_collected', 'cancelled'])->default('pending');

            $table->timestamp('paid_at')->nullable();
            $table->unsignedBigInteger('paid_by')->nullable(); // admin user id who made the transfer
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['vendor_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_earnings');
    }
};
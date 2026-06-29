<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendor_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('order_item_id')->unique()->constrained('order_items')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            $table->string('payment_method'); // snapshot: 'card' or 'cod' at time of order
            $table->decimal('commission_amount', 10, 2);

            // pending      = COD order, vendor still needs to pay this commission to admin
            // paid         = vendor has settled this commission with admin
            // not_applicable = card order, admin already retained commission, nothing owed
            // cancelled    = order/item was cancelled or payment failed
            $table->enum('status', ['pending', 'paid', 'not_applicable', 'cancelled'])->default('pending');

            $table->timestamp('paid_at')->nullable();
            $table->unsignedBigInteger('settled_by')->nullable(); // admin user id who marked it settled
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['vendor_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_commissions');
    }
};
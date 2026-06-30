<?php
// create_vendor_commission_settlements_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vendor_commission_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->enum('payment_method', ['card', 'cod']); // which commission page this belongs to
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_slip')->nullable(); // required for cod, null for card bookkeeping
            $table->string('transfer_reference')->nullable();

            // card: admin marks 'paid' directly, no review step
            // cod : vendor submits ('submitted') -> admin reviews -> 'paid' or 'rejected'
            $table->enum('status', ['submitted', 'paid', 'rejected'])->default('paid');

            $table->date('period_start');
            $table->date('period_end');

            $table->unsignedBigInteger('submitted_by')->nullable(); // vendor user id (cod only)
            $table->timestamp('submitted_at')->nullable();

            $table->unsignedBigInteger('reviewed_by')->nullable(); // admin user id
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_commission_settlements');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            $table->enum('item_type', ['vehicle', 'product']);
            $table->unsignedBigInteger('item_id');

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->decimal('starting_price', 10, 2);
            $table->decimal('bid_increment', 10, 2);

            $table->enum('status', ['upcoming', 'active', 'ended'])->default('upcoming');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};

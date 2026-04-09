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
        Schema::create('auction_notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('auction_id');
            $table->unsignedBigInteger('customer_id');

            $table->enum('type', ['winner', 'outbid', 'general']);
            $table->dateTime('sent_at')->nullable();

            $table->timestamps();

            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_notifications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_winners', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('auction_id');
            $table->unsignedBigInteger('winner_id'); // customer_id
            $table->unsignedBigInteger('winner_bid_id');

            $table->decimal('winner_price', 12, 2);

            $table->enum('status', [
                'pending_admin_approval',
                'approved',
                'rejected'
            ])->default('pending_admin_approval');

            $table->timestamps();

            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade');
            $table->foreign('winner_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('winner_bid_id')->references('id')->on('auction_bids')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_winners');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auction_notifications', function (Blueprint $table) {

            // change ENUM to support all required notification types
            $table->enum('type', [
                'auction_ended',
                'winner_selected',
                'winner_approved',
                'outbid',
                'general'
            ])->change();

        });
    }

    public function down(): void
    {
        Schema::table('auction_notifications', function (Blueprint $table) {

            // rollback to old structure
            $table->enum('type', [
                'winner',
                'outbid',
                'general'
            ])->change();

        });
    }
};
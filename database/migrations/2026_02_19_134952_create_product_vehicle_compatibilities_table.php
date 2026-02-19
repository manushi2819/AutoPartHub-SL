<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_vehicle_compatibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('year_from')->nullable();
            $table->integer('year_to')->nullable();
            $table->string('engine_type')->nullable();
            $table->integer('engine_cc')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_vehicle_compatibilities');
    }
};

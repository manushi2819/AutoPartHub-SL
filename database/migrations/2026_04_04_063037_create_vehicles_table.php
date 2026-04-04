<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();

            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->decimal('price', 12, 2);

            $table->integer('mileage')->nullable();
            $table->string('condition')->default('used'); // new, used, reconditioned

            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();
            $table->integer('engine_cc')->nullable();
            $table->string('body_type')->nullable();
            $table->string('color')->nullable();

            // Location
            $table->string('district')->nullable();
            $table->string('city')->nullable();

            $table->text('description')->nullable();

            $table->boolean('status')->default(1); // 1 = active, 0 = inactive

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
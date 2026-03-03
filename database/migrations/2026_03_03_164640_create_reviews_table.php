<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->tinyInteger('rating')->default(5);
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });

        Schema::create('review_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->string('image'); // filename
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('review_images');
        Schema::dropIfExists('reviews');
    }
};
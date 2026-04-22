<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // remove old column
            $table->dropForeign(['vehicle_type_id']);
            $table->dropColumn('vehicle_type_id');

            // add new json column
            $table->json('vehicle_type_ids')->nullable()->after('brand_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn('vehicle_type_ids');

            $table->foreignId('vehicle_type_id')
                ->nullable()
                ->constrained('vehicle_types')
                ->after('brand_id');
        });
    }
};
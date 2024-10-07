<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('heavy_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code');
            $table->string('register_no');
            $table->string('name');
            $table->string('type');
            $table->string('year_of_purchase');
            $table->string('status');
            $table->string('status_pembelian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heavy_equipment');
    }
};

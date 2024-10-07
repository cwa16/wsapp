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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('heavy_equipment_id')->constrained('heavy_equipment')->cascadeOnDelete();
            $table->string('nik');
            $table->string('activity');
            $table->string('from');
            $table->string('to');
            $table->datetime('start_hour');
            $table->datetime('finish_hour');
            $table->integer('total_hour');
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};

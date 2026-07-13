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
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('adjustment_type');
            $table->integer('approves')->nullable();
            $table->enum('status', ['PENDING', 'COMPLETED', 'CANCELLED', 'STORNOED', 'STORNO'])->default('PENDING');
            $table->timestamps();

            $table->foreign('adjustment_type')->references('adjustment_type')->on('adjustment_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
    }
};

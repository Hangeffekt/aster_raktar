<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrivals', function (Blueprint $table) {
            $table->id("arrival_id");
            $table->uuid('uuid');
            $table->integer('approves')->nullable();
            $table->integer('suplier_id');
            $table->date('arrival_date');
            $table->date('payment_date')->nullable();
            $table->string('suplier_note_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->enum('arrival_status', ['PENDING', 'COMPLETED', 'CANCELLED', 'STORNOED', 'STORNO'])->default('PENDING');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('approves')->references('id')->on('users');
            $table->foreign('suplier_id')->references('suplier_id')->on('supliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrivals');
    }
};

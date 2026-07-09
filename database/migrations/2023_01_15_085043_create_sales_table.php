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
        Schema::create('sales', function (Blueprint $table) {
            $table->id("sale_id");
            $table->uuid('uuid');
            $table->integer('approves')->nullable();
            $table->integer('customer_code')->nullable();
            $table->integer('payment_type')->nullable();
            $table->enum('sale_status', ['PENDING', 'COMPLETED', 'CANCELLED', 'STORNOED', 'STORNO'])->default('PENDING');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('approves')->references('id')->on('users');
            $table->foreign('payment_type')->references('payment_id ')->on('payment_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};

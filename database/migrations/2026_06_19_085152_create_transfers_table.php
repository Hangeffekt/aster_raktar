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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id('transfer_id');
            $table->uuid('uuid');
            $table->foreignId('suplier_id');
            $table->enum('status', ['PENDING', 'COMPLETED', 'STORNOED', 'STORNO'])->default('PENDING');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('suplier_id')->references('suplier_id')->on('supliers');

            $table->index('transfer_id');
        });

        

        Schema::drop('carts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
};

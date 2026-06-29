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
        Schema::create('modul_locations', function (Blueprint $table) {
            $table->id('modul_location_id');
            $table->uuid('uuid');
            $table->foreignId('modul_id');
            $table->foreignId('product_id');
            $table->integer('qty');
            $table->integer('faces')->default(1);
            $table->integer('order');
            $table->boolean('is_active')->default(0);
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('modul_id')->references('modul_id')->on('moduls');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modul_locatoins');
    }
};

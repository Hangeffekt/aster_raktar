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
        Schema::create('shops', function (Blueprint $table) {
            $table->id("shop_id");
            $table->uuid('uuid');
            $table->string('shop_name');
            $table->integer('shop_zip_code');
            $table->string('shop_settlement');
            $table->string('shop_address');
            $table->integer('shop_tax_number');
            $table->integer('shop_phone');
            $table->string('shop_email');
            $table->integer('tax_number');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
};

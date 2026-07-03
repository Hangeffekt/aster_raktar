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
        Schema::create('supliers', function (Blueprint $table) {
            $table->id("suplier_id");
            $table->uuid('uuid');
            $table->string('suplier_name');
            $table->string('suplier_settlement');
            $table->string('suplier_address');
            $table->integer('suplier_zip_code');
            $table->integer('suplier_tax_number');
            $table->integer('suplier_phone')->nullable();
            $table->string('suplier_email')->nullable();
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
        Schema::dropIfExists('supliers');
    }
};

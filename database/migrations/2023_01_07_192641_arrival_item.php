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
        Schema::create('arrival_items', function (Blueprint $table) {
            $table->integer("arrival_item_id")->autoIncrement();
            $table->integer('arrival_table_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('net_price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->string('qty')->nullable();
            $table->integer('finished')->nullable();
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
        Schema::dropIfExists('arrivalitems');
    }
};

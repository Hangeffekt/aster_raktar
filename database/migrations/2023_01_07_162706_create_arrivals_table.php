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
            $table->integer("arrival_id")->autoIncrement();
            $table->string('suplier_id')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('suplier_note_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->integer('total_net_value')->nullable();
            $table->string('arrival_status')->nullable();
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
        Schema::dropIfExists('arrivals');
    }
};

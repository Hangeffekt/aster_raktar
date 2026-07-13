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
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id('payment_id');
            $table->uuid('uuid');
            $table->string('payment_type');
            $table->timestamps();
        });

        Schema::create('adjustment_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('adjustment_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

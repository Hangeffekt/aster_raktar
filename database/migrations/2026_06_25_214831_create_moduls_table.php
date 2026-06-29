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
        Schema::create('moduls', function (Blueprint $table) {
            $table->id('modul_id');
            $table->uuid('uuid');
            $table->string('name');
            $table->foreignId('zone_id');
            $table->string('line', 5);
            $table->integer('modul_number');
            $table->boolean('is_active')->default(0);
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('zone_id')->references('zone_id')->on('zones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moduls');
    }
};

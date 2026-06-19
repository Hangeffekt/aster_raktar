<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_statuses', function (Blueprint $table) {
            $table->id("sale_status_id");
            $table->string('sale_status_name')->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        DB::table('sale_statuses')->insert(['sale_status_name' => 'Készpénz']);
        DB::table('sale_statuses')->insert(['sale_status_name' => 'Kártya']);
        DB::table('sale_statuses')->insert(['sale_status_name' => 'Átutalás']);
        DB::table('sale_statuses')->insert(['sale_status_name' => 'Online']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_statuses');
    }
};

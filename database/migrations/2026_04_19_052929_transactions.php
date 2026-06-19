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

        Schema::table('products', function (Blueprint $table) {

            $table->foreign('brand_id')->references('brand_id')->on('brands');
            $table->foreign('catalog_id')->references('catalog_id')->on('catalogs');
            $table->foreign('tax_id')->references('tax_id')->on('taxes');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            $table->foreignId('product_id');
            
            $table->enum('type', ['IN', 'OUT', 'SETTLE', 'TRANSFER']);
            $table->string('document_type')->nullable(); 
            $table->foreignId('inner_table_id');
            $table->enum('status', ['PENDING', 'COMPLETED', 'CANCELLED', 'STORNOED', 'STORNO'])->default('PENDING');

            $table->integer('qty');

            $table->integer('net_price');
            $table->integer('sale_price');
            
            $table->string('reference')->nullable();

            $table->timestamps();

            $table->index('product_id');
            $table->index('type');
            $table->index('created_at');
            $table->index('inner_table_id');
            
            $table->index(['product_id', 'created_at']);

            $table->foreign('product_id')->references('product_id')->on('products');
            $table->foreign('inner_table_id')->references('sale_id')->on('sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};

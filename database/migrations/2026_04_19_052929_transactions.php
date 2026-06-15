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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
        
            // Kapcsolatok
            $table->foreignId('product_id');
            $table->string('product_name');

            // Típus meghatározása (Bevétel, Kiadás, Leltárkorrekció)
            $table->enum('type', ['IN', 'OUT', 'SETTLE', 'TRANSFER']);
            $table->string('document_type')->nullable(); // pl: 'invoice', 'delivery_note', 'internal_move'
            $table->string('inner_table_id'); //pl: IN-1, OUT-54...
            $table->enum('status', ['PENDING', 'COMPLETED', 'CANCELLED'])->default('COMPLETED');

            // Mennyiség (lehet tört is, ha pl. kg-ban mérsz)
            $table->integer('qty');

            // Pénzügyi adatok (a pillanatnyi állapot rögzítése)
            $table->integer('net_price')->comment('Eladási egységár');
            $table->integer('sale_price')->comment('Beszerzési egységár a haszon számításhoz');
            
            // Megjegyzés vagy bizonylatszám (pl. számlaszám)
            $table->string('reference')->nullable();

            $table->timestamps();

            // INDEXEK a sebességért
            $table->index('product_id'); // Gyors készletszámításhoz termékenként
            $table->index('type');       // Ha csak az eladásokra (OUT) vagy kíváncsi
            $table->index('created_at'); // A napi/havi riportokhoz (WHERE created_at BETWEEN...)
            $table->index('inner_table_id');
            
            // Kombinált index a leggyakoribb lekérdezéshez: "Milyen mozgása volt ennek a terméknek ebben az időszakban?"
            $table->index(['product_id', 'created_at']);
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

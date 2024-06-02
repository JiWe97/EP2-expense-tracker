<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //TODO: DB opnieuw opstellen!
        Schema::create('crypto_currencies', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['BTC', 'ETH', 'USDT'])->default('BTC'); //TODO: enum, welke coins gaan we gebruiken?
            $table->enum('type', ['buy', 'sell'])->default('buy');
            $table->float('amount');
            $table->float('price');
            $table->float('rate');
            $table->foreignId('banking_record_id')->constrained('banking_records');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_currencies');
    }
};

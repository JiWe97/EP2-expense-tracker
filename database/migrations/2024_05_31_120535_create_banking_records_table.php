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
        Schema::create('banking_records', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_number');
            $table->foreignId('user_id')->constrained();
            $table->boolean('private')->default(false);
            $table->float('balance');
            /* $table->enum('type'); //TODO: welke types? Wat bedoelde ik met type? */
            $table->enum('valuta', ['EUR', 'USD'])->default('EUR'); //TODO: enum, welke valuta gaan we gebruiken?
            $table->float('exchange_rate'); //TODO: Hoe implementeren?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banking_records');
    }
};

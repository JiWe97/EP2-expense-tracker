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
            $table->bigint('account_number');
            $table->int('user_id');
            $table->boolean('private')->default(false);
            $table->float('balance');
            $table->enum('type');
            $table->enum('valuta');
            $table->float('exchange_rate');
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

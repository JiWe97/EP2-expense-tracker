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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->int('category_id');
            $table->int('user_id');
            $table->string('description');
            $table->enum('type');
            $table->enum('valuta');
            $table->int('recipient_id');
            $table->float('exchange_rate');
            $table->boolean('warranty');
            $table->date('warranty_date');
            $table->enum('status');
            $table->date('due_before');
            $table->int('banking_record_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

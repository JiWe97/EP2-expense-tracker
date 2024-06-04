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
            $table->foreignId('category_user_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('description')->nullable();
            $table->string('type');
            $table->enum('valuta', ['EUR', 'USD'])->default('EUR');
            $table->foreignId('recipient_id')->constrained('recipients');
            $table->float('exchange_rate')->nullable(); 
            $table->boolean('warranty')->nullable();
            $table->date('warranty_date')->nullable();
            $table->foreignId('banking_record_id')->constrained('banking_records');
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


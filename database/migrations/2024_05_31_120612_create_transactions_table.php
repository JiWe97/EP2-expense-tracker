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
            $table->date('date');
            $table->decimal('amount', 15, 2);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('description')->nullable();
            $table->foreignId('banking_record_id')->constrained('banking_records')->onDelete('cascade');
            $table->string('type');
            $table->enum('valuta', ['EUR', 'USD'])->default('EUR');
            $table->float('exchange_rate')->nullable(); 
            $table->boolean('warranty')->nullable();
            $table->date('warranty_date')->nullable();
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


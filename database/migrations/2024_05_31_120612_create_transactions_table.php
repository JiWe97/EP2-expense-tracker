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
            $table->integer('category_id');
            $table->foreignId('user_id')->constrained();
            $table->string('description')->nullable();
            $table->enum('type', ['income', 'outgoing'])->default('outgoing');
            $table->enum('valuta', ['EUR', 'USD'])->default('EUR'); // TODO: enum
            $table->foreignId('recipient_id')->nullable()->constrained('recipients');
            $table->float('exchange_rate'); //TODO: hoe pakken we dit aan?
            $table->boolean('warranty')->nullable();
            $table->date('warranty_date')->nullable();
            $table->enum('status', ['open', 'closed'])->default('closed');
            $table->date('due_before'); //TODO: is dit nodig? Dit is een transactie dus deze is al gebeurd?
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

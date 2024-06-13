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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('amount');
            $table->boolean('mail_when_completely_spent')->default(false);
            $table->boolean('mail_when_partially_spent')->default(false);
            $table->foreignId('banking_record_id')->constrained('banking_records')->onDelete('cascade');
            $table->timestamp('last_partially_spent_notification')->nullable();
            $table->timestamp('last_completely_spent_notification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};

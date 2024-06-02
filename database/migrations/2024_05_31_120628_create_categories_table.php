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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('color', ['#FF6347', '#1E90FF', '#FFD700', '#FF4500', '#32CD32', '#8B4513', '#2E8B57', '#4682B4', '#FF69B4', '#D3D3D3'])->default('#4682B4');
            $table->boolean('show')->default(true);
            $table->string('icon');
            /* $table->boolean('subcategory')->default(false);
            $table->int('parent_id')->nullable(); */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

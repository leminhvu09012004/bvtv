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
        Schema::create('disease_pesticide', function (Blueprint $table) {
            $table->foreignId('disease_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pesticide_id')->constrained()->cascadeOnDelete();
            $table->primary(['disease_id', 'pesticide_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_pesticide');
    }
};

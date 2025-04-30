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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sorteoId')->constrained('sorteos')->onDelete('cascade');
            $table->foreignId('userId')->nullable()->constrained('users')->onDelete('set null');
            $table->unsignedInteger('numeroCompra');
            $table->unique(['sorteoId', 'numeroCompra']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};

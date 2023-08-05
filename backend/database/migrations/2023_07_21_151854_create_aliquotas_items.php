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
        Schema::create('aliquotas_items', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->bigInteger('aliquota_id');
            $table->longText('descritivo')->nullable();
            $table->decimal('porcentagem')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aliquotas_items');
    }
};

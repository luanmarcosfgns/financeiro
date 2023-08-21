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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->longText('descritivo')->nullable();
            $table->boolean('ecommerce')->default(true);
            $table->double('preco')->default(0.00);
            $table->bigInteger('aliquota_id')->nullable();
            $table->bigInteger('categoria_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->bigInteger('business_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};

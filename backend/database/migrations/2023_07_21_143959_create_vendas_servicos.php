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
        Schema::create('vendas_servicos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venda_id');
            $table->bigInteger('servico_id');
            $table->decimal('preco')->default(0.00);
            $table->decimal('quantidade')->default(0.00);
            $table->decimal('desconto')->default(0.00);
            $table->json('impostos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas_servicos');
    }
};

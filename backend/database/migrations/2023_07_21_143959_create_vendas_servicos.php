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
            $table->decimal('preco')->default(null)->nullable();
            $table->decimal('desconto')->default(null)->nullable();

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

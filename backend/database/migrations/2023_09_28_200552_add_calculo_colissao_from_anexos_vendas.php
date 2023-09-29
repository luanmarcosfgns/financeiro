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
        Schema::table('anexos_vendas', function (Blueprint $table) {
            $table->decimal('porcentagem_seguradora');
            $table->decimal('porcentagem_franquiadora');
            $table->decimal('porcentagem_maxima_vendedor');
            $table->decimal('porcentagem_minima_vendedor');
            $table->decimal('valor_premio');
            $table->boolean('melhor_opcao')->default(false);
            $table->longText('descritivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anexos_vendas', function (Blueprint $table) {
            //
        });
    }
};

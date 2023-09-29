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
        Schema::table('vendas_servicos', function (Blueprint $table) {
            $table->dropColumn('comissao');
            $table->dropColumn('aliquotas_item_id');
            $table->decimal('porcentagem_seguradora')->default(0.00);
            $table->decimal('porcentagem_franquiadora')->default(0.00);
            $table->decimal('porcentagem_maxima_vendedor')->default(0.00);
            $table->decimal('porcentagem_minima_vendedor')->default(0.00);
            $table->decimal('valor_premio')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendas_servicos', function (Blueprint $table) {
            //
        });
    }
};

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
            $table->dropColumn('porcentagem_seguradora');
            $table->dropColumn('porcentagem_maxima_vendedor');
            $table->dropColumn('porcentagem_minima_vendedor');

            $table->decimal('porcentagem_corretora')->default(0.00);
            $table->decimal('porcentagem_vendedor')->default(0.00);
            $table->decimal('comissao')->default(0.00);

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

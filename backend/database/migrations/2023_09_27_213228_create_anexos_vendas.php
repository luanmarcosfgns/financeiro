<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anexos_vendas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->binary('anexo');
            $table->bigInteger('venda_id');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE anexos_vendas MODIFY anexo LONGBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anexos_vendas');
    }
};

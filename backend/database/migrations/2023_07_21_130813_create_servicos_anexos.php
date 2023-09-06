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
        Schema::create('servicos_anexos', function (Blueprint $table) {
            $table->id();
            $table->binary('anexo');
            $table->enum('tipo',['produto','imagem','documento']);
            $table->bigInteger('servico_id');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE servicos_anexos MODIFY anexo LONGBLOB");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos_anexos');
    }
};

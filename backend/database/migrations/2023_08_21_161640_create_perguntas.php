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
        Schema::create('perguntas', function (Blueprint $table) {
            $table->id();
            $table->longText('enunciado');
            $table->enum('tipo_resposta',['multipla','unica','descritiva','inteira','decimal','datada']);
            $table->integer('ordem');
            $table->json('opcoes');
            $table->bigInteger('business_id');
            $table->bigInteger('entrevista_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perguntas');
    }
};

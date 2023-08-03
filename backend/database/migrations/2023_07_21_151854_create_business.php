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
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('fantasia');
            $table->string('razao');
            $table->string('cnpj_cpf');
            $table->string('ie_rg')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero',6)->nullable();
            $table->string('cep',20)->nullable();
            $table->string('telefone',20)->nullable();
            $table->string('celular',20)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business');
    }
};

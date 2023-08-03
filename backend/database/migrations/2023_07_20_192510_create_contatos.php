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
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('nome',300);
            $table->date('nascimento')->nullable();
            $table->enum('estado_civil',['solteiro','casado','divorciado','viuvo'])->nullable();
            $table->enum('sexo',['masculino','feminino'])->nullable();
            $table->string('rg_ie',300)->nullable();
            $table->string('cnpj_cpf',18);
            $table->string('endereco',400);
            $table->string('numero',10);
            $table->string('bairro',150);
            $table->string('cidade',150);
            $table->string('cep',10);
            $table->string('telefone',30);
            $table->string('celular',30);
            $table->string('email',150);
            $table->longText('descritivo')->nullable();
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
        Schema::dropIfExists('contatos');
    }
};

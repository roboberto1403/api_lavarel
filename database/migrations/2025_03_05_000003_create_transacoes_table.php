<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('transacoes')) {
            Schema::create('transacoes', function (Blueprint $table) {
                $table->id()->primary();
                $table->string('cpf_usuario');
                $table->foreign('cpf_usuario')->references('cpf')->on('usuarios')->onDelete('cascade');
                $table->enum('tipo', ['Recebeu', 'Pagou']);
                $table->decimal('valor', 10, 2);
                $table->unsignedBigInteger('id_categoria');
                $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');;
                $table->timestamp('data')->useCurrent();
            });
        }
    }

    public function down() {
        Schema::dropIfExists('transacoes');
    }
};


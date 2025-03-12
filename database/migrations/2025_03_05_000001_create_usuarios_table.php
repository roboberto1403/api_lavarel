<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->string('cpf')->primary();
                $table->string('nome');
                $table->string('email')->unique();
                $table->string('senha');
                $table->timestamp('data_cadastro')->useCurrent();
            });
        }
    }

    public function down() {
        Schema::dropIfExists('usuarios');
    }
};

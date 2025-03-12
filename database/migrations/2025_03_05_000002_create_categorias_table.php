<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->id()->primary();
                $table->string('nome')->unique();
            });
        }
    }

    public function down() {
        Schema::dropIfExists('categorias');
    }
};

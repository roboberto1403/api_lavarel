<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Chamando seeders individuais
        $this->call([
            UsuariosSeeder::class,
            CategoriasSeeder::class,
            TransacoesSeeder::class,
        ]);
    }
}

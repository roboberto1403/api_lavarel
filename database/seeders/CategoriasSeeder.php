<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            [
                'nome' => 'Alimentação'
            ],
            [
                'nome' => 'Lazer'
            ],
            [
                'nome' => 'Aluguél'
            ]
        ]);
    }
}
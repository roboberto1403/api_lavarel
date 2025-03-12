<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'cpf' => '12345678901',
                'nome' => 'Beto',
                'email' => 'betoesperto@gamil.com',
                'senha' => 'betoeperto123',
                'data_cadastro' => now(),
            ],
            [
                'cpf' => '45678912301',
                'nome' => 'Mayrla',
                'email' => 'mayrlalegal@gamil.com',
                'senha' => 'mayrlalegal123',
                'data_cadastro' => now(),
            ],
            [
                'cpf' => '10987654302',
                'nome' => 'Stayce',
                'email' => 'staycegames@gamil.com',
                'senha' => 'staycegamer123',
                'data_cadastro' => now(),
            ]
        ]);
    }
}

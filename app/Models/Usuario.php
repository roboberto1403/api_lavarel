<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'cpf';
    public $incrementing = false;
    protected $fillable = ['cpf', 'nome', 'email', 'senha', 'data_cadastro'];
}


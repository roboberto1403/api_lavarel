<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;
    protected $table = 'transacoes';
    protected $primaryKey = 'id';
    protected $fillable = ['cpf_usuario', 'id_categoria', 'tipo', 'valor', 'data'];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'cpf_usuario', 'cpf');
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id');
    }
}


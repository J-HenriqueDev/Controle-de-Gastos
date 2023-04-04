<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
        // return $this->belongsTo(CategoriaGasto::class, 'categoria_de_gastos_id', 'id');
    }
    public function Categoria() {
        return $this->belongsTo(CategoriaGasto::class, 'categoria_de_gastos_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function usuario() {
        return $this->belongsTo(Usuarios::class, 'usuario_id', 'id');
    }

    public function categoriaGastos() {
        return $this->belongsTo(CategoriaGastos::class, 'categoria_de_gastos_id', 'id');
    }
}

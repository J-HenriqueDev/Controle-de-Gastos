<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recebedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_recebedor'
    ];
}

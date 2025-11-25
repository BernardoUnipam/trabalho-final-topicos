<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    // Esta lista diz ao Laravel quais campos podem ser preenchidos pelo formulário
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'imagem', // imagem adicionada
    ];
}
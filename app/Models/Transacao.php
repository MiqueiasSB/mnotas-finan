<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacaos'; // Nome da tabela
    protected $fillable = [
        'user_id',
        'cliente_id',
        'item',
        'quantidade',
        'valor',
        'categoria_id',
        'forma_pagamento',
        'data',
        'data_final'
    ]; // Colunas que podem ser preenchidas em massa
    protected $casts = [
        'valor' => 'decimal:2',
    ];

    ############# RELACIONAMENTOS
    // Relacionamento: Um pedido pertence a um usuário
    public function umCliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function CategoriaTransacao()
    {
        // Especifique a chave estrangeira como 'categoria_id'
        return $this->belongsTo(CategoriaTransacao::class, 'categoria_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
    use HasFactory;

    protected $table = 'clientes'; // Nome da tabela
    protected $fillable = [
        'user_id',
        'nome',
        'cpf',
        'endereco',
        'descricao',
        'telefone',
        'divida_total'
    ]; // Colunas que podem ser preenchidas em massa

    // Relacionamento: Um usuário pode ter muitos pedidos
    public function transacoes() {
        return $this->hasMany(Transacao::class);
    }
}
 
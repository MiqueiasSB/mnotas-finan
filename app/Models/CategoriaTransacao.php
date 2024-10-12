<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaTransacao extends Model {
    use HasFactory;

    protected $table = 'categoria_transacao'; // Nome da tabela
    protected $fillable = [
        'nome',
        'tipo',
        'user_id'
    ]; // Colunas que podem ser preenchidas em massa

    // Relacionamento: Um usuário pode ter muitas transações
    public function transacoes() {
        return $this->hasMany(Transacao::class)->withoutTrashed(); // Certifique-se de incluir withoutTrashed se estiver usando soft deletes
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

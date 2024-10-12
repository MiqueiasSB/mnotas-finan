<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {   
        //Categorias genêricas
        DB::table('categoria_transacao')->insert([
            [
                'id' => 1,
                'tipo' => 'Receita',
                'nome' => 'Receita',
                'user_id' => null,
            ],
            [
                'id' => 2,
                'tipo' => 'Despesa',
                'nome' => 'Despesa',
                'user_id' => null,
            ],
            [
                'id' => 3,
                'tipo' => 'A Receber',
                'nome' => 'A Receber',
                'user_id' => null,
            ],
        ]);
    }

    public function down()
    {
        // Remova os itens inseridos se necessário
        DB::table('categoria_transacao')
            ->whereIn('nome', ['Receita', 'Despesa', 'A Receber'])
            ->delete();
    }
};

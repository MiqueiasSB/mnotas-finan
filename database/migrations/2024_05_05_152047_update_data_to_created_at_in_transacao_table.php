<?php

use App\Livewire\Transacoes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Atualiza a coluna "data" com o valor da coluna "created_at"
        DB::table('transacaos')->update(['data' => DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")')]);
        
    }

    public function down() {
        // Reverta a atualização (se necessário)
      
        DB::table('transacaos')->update(['data' => null]);
    }
};

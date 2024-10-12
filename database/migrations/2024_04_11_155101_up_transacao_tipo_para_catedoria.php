<?php

use App\Models\Transacao;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Transacao::where('tipo', 'Receita')->update(['categoria_id' => 1]);
        Transacao::where('tipo', 'Despesa')->update(['categoria_id' => 2]);
        Transacao::where('tipo', 'A Receber')->update(['categoria_id' => 3]);

        Schema::table('transacaos', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }

    public function down()
    {
        Schema::table('transacaos', function (Blueprint $table) {
            $table->string('tipo')->nullable();
        });

        Transacao::where('categoria_id', 1)->update(['tipo' => 'Receita']);
        Transacao::where('categoria_id', 2)->update(['tipo' => 'Despesa']);
        Transacao::where('categoria_id', 3)->update(['tipo' => 'A Receber']);
    }
};

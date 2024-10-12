<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToTransacaosTable extends Migration{

    public function up(): void {
        Schema::table('transacaos', function (Blueprint $table) {
            // Adicione a coluna de chave estrangeira
            $table->unsignedBigInteger('cliente_id')->nullable();

            // Defina a chave estrangeira
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }


    public function down(): void {
        Schema::table('transacaos', function (Blueprint $table) {
            // Se necessário, remova a chave estrangeira e a coluna
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
        });
    }
};

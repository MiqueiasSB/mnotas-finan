<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   
    public function up(): void {
        Schema::table('transacaos', function (Blueprint $table) {
            // Adiciona a coluna 'categoria_id' como chave estrangeira
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categoria_transacao')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('transacaos', function (Blueprint $table) {
            // Remove a chave estrangeira e a coluna 'categoria_id'
            $table->dropForeign(['categoria_id']);
           $table->dropColumn('categoria_id');
        });
    }
};

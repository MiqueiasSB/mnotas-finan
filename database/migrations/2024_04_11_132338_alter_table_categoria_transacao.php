<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::table('categoria_transacao', function (Blueprint $table) {
            // Remover a coluna 'forma_pagamento'
            $table->dropColumn('forma_pagamento');

            // Adicionar a chave estrangeira da tabela 'users'
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }


    public function down(): void {
        Schema::table('categoria_transacao', function (Blueprint $table) {
            // Reverter as alterações feitas no método up()
            $table->string('forma_pagamento')->nullable();
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};

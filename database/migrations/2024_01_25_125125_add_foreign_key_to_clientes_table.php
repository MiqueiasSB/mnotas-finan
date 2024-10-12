<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToClientesTable extends Migration {

    public function up(): void {
        Schema::table('clientes', function (Blueprint $table) {
            // Adicione a coluna de chave estrangeira
            $table->unsignedBigInteger('user_id');

            // Defina a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    } 

   
    public function down(): void {
        Schema::table('clientes', function (Blueprint $table) {
            // Remova temporariamente a chave estrangeira
            $table->dropForeign(['user_id']);
            
            // Adicione a coluna de chave estrangeira
            $table->unsignedBigInteger('user_id');
    
            // Defina a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};

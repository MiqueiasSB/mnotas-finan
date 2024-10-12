<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transacaos', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Adiciona a coluna user_id como nullable
    });
}

public function down()
{
    Schema::table('transacaos', function (Blueprint $table) {
        $table->dropColumn('user_id'); // Remove a coluna se a migração for revertida
    });
}
};

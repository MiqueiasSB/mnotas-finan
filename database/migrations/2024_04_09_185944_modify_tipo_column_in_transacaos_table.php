<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('transacaos', function (Blueprint $table) {
            $table->string('tipo')->change();
        });

        DB::table('transacaos')->where('tipo', '0')->update(['tipo' => 'Despesa']);
        DB::table('transacaos')->where('tipo', '1')->update(['tipo' => 'Receita']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('transacaos', function (Blueprint $table) {
            $table->boolean('tipo')->change();
        });

        DB::table('transacaos')->where('tipo', 'Despesa')->update(['tipo' => '0']);
        DB::table('transacaos')->where('tipo', 'Receita')->update(['tipo' => '1']);
    }
};

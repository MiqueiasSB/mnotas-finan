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
        DB::table('transacaos')->where('tipo', 'Despesa')->update(['tipo' => 'A Receber']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        DB::table('transacaos')->where('tipo', 'A Receber')->update(['tipo' => 'Despesa']);
    }
};

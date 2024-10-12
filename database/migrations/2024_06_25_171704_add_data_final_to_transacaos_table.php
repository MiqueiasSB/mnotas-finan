<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataFinalToTransacaosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::table('transacaos', function (Blueprint $table) {
            $table->date('data_final')->after('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down() {
        Schema::table('transacaos', function (Blueprint $table) {
            $table->dropColumn('data_final');
        });
    }
}

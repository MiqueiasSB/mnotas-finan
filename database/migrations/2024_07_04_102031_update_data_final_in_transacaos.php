<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateDataFinalInTransacaos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('transacaos')
            ->whereNull('data_final')
            ->update(['data_final' => DB::raw('data')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Neste caso, a reversão não seria trivial, pois não sabemos qual era o valor original de data_final
        // Você pode deixar vazio ou implementar alguma lógica que faça sentido para o seu caso
    }
}

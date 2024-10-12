<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('transacaos', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->integer('quantidade')->default(1);
            $table->boolean('tipo')->default(1);
            $table->decimal('valor', 10, 2)->default('0.00'); // 10 digitos;
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transacaos');
    }
};

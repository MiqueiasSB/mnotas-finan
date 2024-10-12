<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('categoria_transacao', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome');
            $table->string('tipo');
            $table->string('forma_pagamento');
        });
    }


    public function down(): void {
        Schema::dropIfExists('categoria_transacao');
    }
};

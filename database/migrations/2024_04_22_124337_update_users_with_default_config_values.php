<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $defaultConfig = [
            'horarioDeTrabalho' => ['00:08', '18:00'],
            'theme' => 'light',
            'language' => 'pt-br',
        ];

        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $config = array_merge($defaultConfig, $user->config ?? []);
            $user->config = $config;
            $user->save();
        }
    }

    public function down()
    {
        // Não faz nada na migração reversível
    }
};

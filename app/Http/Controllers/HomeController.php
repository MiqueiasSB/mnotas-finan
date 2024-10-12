<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    public function index() {

        return view('vendas');
    }

    public function painel() {

        return view('painel');
    }
    public function categorias() {

        return view('categorias');
    }
    public function configUser() {

        return view('configUser');
    }

    // UsersController.php

    public function upEmail(Request $request) {
        $user = Auth::user();
        $newEmail = $request->input('novoEmail');

        // Verificar se o novo email é igual ao email atual
        if ($newEmail == $user->email) {
            return back()->withInfo('Você não fez nenhuma alteração no email.');
        }

        // Verificar se o novo email já existe no banco de dados
        if (User::where('email', $newEmail)->exists()) {
            return back()->withErrors(['novoEmail' => 'Este email já está em uso.']);
        }

        // Atualizar o email do usuário
        $user->email = $newEmail;
        $user->save();

        
        return back()->with('resend', true);
    }
}

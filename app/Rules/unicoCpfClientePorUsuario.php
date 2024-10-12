<?php

namespace App\Rules;

use App\Models\Cliente;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class unicoCpfClientePorUsuario implements ValidationRule {
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $clienteId;

    public function __construct($clienteId = '') {
        $this->clienteId = $clienteId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void {

        $userId = Auth::id();

        $count = Cliente::where('cpf', $value)
            ->whereNot('id', $this->clienteId)
            ->where('user_id', $userId)
            ->count();

        if ($count > 0) {
            $fail('O CPF já está em uso por outro cliente.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Rules\unicoCpfClientePorUsuario;

use App\Models\Cliente;
use App\Models\Transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller {
    public function index() {

        return view('clientes');
    }

    public function create() {

        return view('components.clientes.createCliente');
    }

    public function show($clienteId) {

        $cliente = Cliente::find($clienteId);

        return view('components.clientes.showCliente', ['cliente' => $cliente]);
    }

    

    public function store(Request $request) {
        // Validação dos dados

        $request->validate([
            'nome' => 'required|string|max:255|unique:clientes',
            'cpf' => ['nullable', 'max:14', 'formato_cpf', new unicoCpfClientePorUsuario],
            'telefone' => 'required|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
        ], $this->massageError());

        // Criação do cliente
        $cliente = Cliente::create([
            'user_id' => Auth::user()->id,
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'telefone' => $request->input('telefone'),
            'endereco' => $request->input('endereco'),
            'descricao' => $request->input('descricao'),
        ]);

        // Redireciona ou realiza outra ação, se necessário
        return redirect()->route('clientes.show', ['cliente' =>  $cliente->id]);
    }

    public function edit($cliente) {

        $cliente = Cliente::where('nome', $cliente)->first();

        // dd($cliente);
        return view('components.clientes.editCliente', ['cliente' => $cliente]);
    }

    public function update(Request $request, $clienteId) {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255|unique:clientes,nome,' . $clienteId,
            'cpf' => ['nullable', 'max:14', 'formato_cpf', new unicoCpfClientePorUsuario($clienteId)],
            'telefone' => 'required|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
        ], $this->massageError());

        // Atualização do cliente
        $cliente = Cliente::find($clienteId);

        $cliente->update([
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'telefone' => $request->input('telefone'),
            'endereco' => $request->input('endereco'),
            'descricao' => $request->input('descricao'),
        ]);

        // Redireciona ou realiza outra ação, se necessário
        return redirect()->route('clientes.show', ['cliente' =>  $cliente->id]);
    }
    public function destroy($cliente) {
        // Encontrar o cliente pelo ID no banco de dados
        $cliente = Cliente::find($cliente);

        // Verificar se o cliente foi encontrado
        if (!$cliente) {
            // Caso o cliente não seja encontrado, redirecionar ou retornar uma resposta adequada
            return redirect()->route('clientes.index')->with('error', 'Cliente não encontrado.');
        }

        // Excluir o cliente do banco de dados
        $cliente->delete();

        // Redirecionar para a lista de clientes com uma mensagem de sucesso
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso.');
    }

    public function massageError() {
        // Mensagens personalizadas
        $mensagens = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais de :max caracteres.',
            'nome.unique' => 'O nome já está em uso.',

            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.string' => 'O campo CPF deve ser uma string.',
            'cpf.max' => 'O campo CPF não pode ter mais de :max caracteres.',
            'cpf.formato_cpf' => 'O CPF informado não está em um formato válido.',
            'cpf.unique' => 'O CPF já está cadastrado.',

            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.telefone_com_ddd' => 'O telefone não está em um formato válido.',
            'telefone.string' => 'O campo telefone deve ser uma string.',
            'telefone.max' => 'O campo telefone não pode ter mais de :max caracteres.',

            'endereco.string' => 'O campo endereço deve ser uma string.',
            'endereco.max' => 'O campo endereço não pode ter mais de :max caracteres.',

            'descricao.string' => 'O campo descrição deve ser uma string.',
        ];

        return $mensagens;
    }
}

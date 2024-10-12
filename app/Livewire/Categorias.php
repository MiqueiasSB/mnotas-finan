<?php

namespace App\Livewire;

use App\Models\CategoriaTransacao;
use App\Models\Transacao;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Categorias extends Component {

    public
        $tipos = ['Receita', 'Despesa', 'A Receber'],
        $cores = ['success', 'danger', 'warning'],

        $nome,
        $tipo,
        $categoriasPorTipo,

        $categoriaView; //Armazena categoria selecionada

    protected function rules() {
        return [
            'nome' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $tipoEquivalent = $this->tipos[array_search($this->tipo, $this->cores)];
                    $exists = CategoriaTransacao::where('nome', $value)
                        ->where('tipo', $tipoEquivalent)
                        ->where('user_id', Auth::id())
                        ->exists();

                    if ($exists) {
                        $fail('Este nome já existe para o tipo selecionado.');
                    }
                }
            ]
        ];
    }

    public function mount() {
    }

    public function render() {
        $this->categoriasPorTipo = $this->constroiArrayCategorias();

        return view('livewire.categorias');
    }

    public function save() {
        $this->validate();

        CategoriaTransacao::create([
            'user_id' => Auth::user()->id,
            'nome' => $this->nome,
            //o $tipo esta retornando a classe de cores, entao eu pego o equivalente em $tipos
            'tipo' => $this->tipos[array_search($this->tipo, $this->cores)]
        ]);

        $this->nome = '';
    }



    public function update() {
        $this->validate();

        $this->categoriaView->update([
            'nome' => $this->nome,
        ]);

        $this->nome = '';

        $this->dispatch('fecharViewModal');
    }

    public function destroy() {

        // Encontrar todas as transações com a categoria_id específica
        $transacoes = Transacao::where('user_id', Auth::user()->id)->where('categoria_id', $this->categoriaView->id)->get();

        // Verificar se existem transações com a categoria_id específica
        if ($transacoes->isNotEmpty()) {
            // Iterar sobre cada transação encontrada e atualizar a categoria_id
            foreach ($transacoes as $transacao) {
                $transacao->categoria_id = array_search($this->categoriaView->tipo, $this->tipos) + 1;
                $transacao->save();
            }
        }

        $this->categoriaView->delete();

        $this->dispatch('fecharViewModal');
    }


    public function constroiArrayCategorias() {
        $arrayCategorias = [];

        foreach (CategoriaTransacao::all()->where('user_id', Auth::user()->id) as $key => $categoria) {
            $arrayCategorias[$categoria->tipo][] = $categoria;
        }

        return $arrayCategorias;
    }
    public function criaViewModal($idCategoria) {
        $this->categoriaView = CategoriaTransacao::find($idCategoria);
        $this->nome = $this->categoriaView->nome;

        $this->dispatch('criaModalView', $this->categoriaView);
    }
}

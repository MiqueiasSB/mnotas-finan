<?php

namespace App\Livewire\Graficos;

use App\Models\CategoriaTransacao;
use App\Models\Transacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GSomasPorCategoria extends Component {
    public
        $user,
        $dataAtual,
        $periodo,
        $periodoSelecionado,

        $dados = [],
        $legenda = [],
        $categorias,
        $idItemAtivo,
        $itens;

    public function mount() {
        $this->user = Auth::user();

        $this->itens = cache()->get('itens', [
            [
                'tipo' => 'Receita',
                'titulo' => 'Total de Receitas',
                'class' => 'success',
                'soma' => 0,
                'btnAtivo' => true
            ],
            [
                'tipo' => 'Despesa',
                'titulo' => 'Total de Despesas',
                'class' => 'danger',
                'soma' => 0,
                'btnAtivo' => false
            ],
            [
                'tipo' => 'A Receber',
                'titulo' => 'Total a Receber',
                'class' => 'warning',
                'soma' => 0,
                'btnAtivo' => false
            ]
        ]);

        $this->atualizaTipoGrafico();

        $this->atualizarGrafico();
    }

    public function render() {
        return view('livewire.graficos.g-somas-por-categoria');
    }

    public function ativarBtn($key) {


        // define todos com false
        $this->itens = array_map(function ($item) {
            $item['btnAtivo'] = false;
            return $item;
        }, $this->itens);


        //Define o clicado como true
        $this->itens[$key]['btnAtivo'] = true;

        cache()->put('itens', $this->itens);

        $this->atualizaTipoGrafico();

        $this->atualizarGrafico();
    }

    public function atualizaTipoGrafico() {

        //Recupera o ID do array $itens que está ATIVO
        $this->idItemAtivo = key(array_filter($this->itens, function ($item) {
            return $item['btnAtivo'] === true;
        }));

        $this->categorias = CategoriaTransacao::where('user_id', Auth::user()->id)
            ->where('tipo', $this->itens[$this->idItemAtivo]['tipo'])
            ->get();

        $this->categorias[] = CategoriaTransacao::find($this->idItemAtivo + 1);

        $this->criaLegenda();
    }

    public function atualizarGrafico() {

        //Chama uma função grafica instanciando seu nome dinamicamente
        $funcao = 'grafico' . ucfirst(strtolower($this->periodoSelecionado)); // Por exemplo, 'graficoSemana'
        call_user_func([$this, $funcao]);

        $this->itens[2]['soma'] = $this->somaTransacoesReceber();

        $this->organizaDados();//Menor para o maior

        $this->dispatch('atualizaGrafico', [
            'dados' => json_encode($this->dados),
            'legenda' => json_encode($this->legenda),
            'idAtivo' => json_encode($this->idItemAtivo)
        ]);
    }

    public function graficoDia() {


        for ($i = 0; $i < 2; $i++) {
            $this->itens[$i]['soma'] = Transacao::where('user_id', $this->user->id)
                ->whereIn('categoria_id', function ($query) use ($i) {
                    $query->select('id')
                        ->from('categoria_transacao')
                        ->where('tipo', $this->itens[$i]['tipo']);
                })
                ->whereDate('data', '=', $this->dataAtual)
                ->sum(DB::raw('quantidade * valor'));
        }

        $this->dados = [];

        foreach ($this->categorias as $key => $categoria) {

            //Percorrer cada categoria
            //somar a quantidade por dia, vou ter um array com a quantidade em cada dia dia
            //somar todos os tipos por dia
            if (!isset($this->dados[$key])) {
                $this->dados[$key] = 0;
            }

            $this->dados[$key] += Transacao::where('user_id', Auth::user()->id)
                //->where('forma_pagamento', $categoria)
                ->whereDate('data', '=', $this->dataAtual)
                ->where('categoria_id', $categoria->id)
                ->sum(DB::raw('quantidade * valor'));
        }
    }

    public function organizaDados() {
        // Combine os dois arrays em um array associativo
        $combinado = array_map(null, $this->legenda, $this->dados);

        // Ordene o array combinado baseado nos valores de dados (índice 1)
        usort($combinado, function ($a, $b) {
            return $b[1] - $a[1]; // Ordem decrescente
        });

        // Separe os arrays novamente após a ordenação
        $this->legenda = array_column($combinado, 0);
        $this->dados = array_column($combinado, 1);
    }
    public function graficoSemana() {
        $this->graficoMes();
    }
    public function graficoMes() {
        $this->dados = $this->calculaTransacoes();
        $this->itens[0]['soma'] = $this->somaTransacoes('Receita');
        $this->itens[1]['soma'] = $this->somaTransacoes('Despesa');
    }
    public function graficoAno() {
        $this->dados = $this->calculaTransacoes(true);
        $this->itens[0]['soma'] = $this->somaTransacoes('Receita', true);
        $this->itens[1]['soma'] = $this->somaTransacoes('Despesa', true);
    }
    public function criaLegenda() {
        $this->legenda = [];

        foreach ($this->categorias as $key => $categoria) {
            $this->legenda[] = $categoria->nome;
        }
    }
    public function somaTransacoes($tipo = 'Receita', $ano = false) {
        $soma = 0;

        foreach ($this->periodo as $data) {

            if ($ano) {

                $soma += Transacao::where('user_id', $this->user->id)
                    ->whereIn('categoria_id', function ($query) use ($tipo) {
                        $query->select('id')
                            ->from('categoria_transacao')
                            ->where('tipo', $tipo);
                    })
                    ->whereRaw('MONTH(data) = ? AND YEAR(data) = ?', [$data->format('m'), $data->format('Y')])
                    ->sum(DB::raw('quantidade * valor'));
            } else {

                $soma += Transacao::where('user_id', $this->user->id)
                    ->whereDate('data', '=', $data)
                    ->whereIn('categoria_id', function ($query)  use ($tipo) {
                        $query->select('id')
                            ->from('categoria_transacao')
                            ->where('tipo', $tipo);
                    })

                    ->sum(DB::raw('quantidade * valor'));
            }
        }

        return $soma;
    }

    public function calculaTransacoes($ano = false) {

        $res = [];

        if ($ano) {

            foreach ($this->categorias as $key => $categoria) {
                if (!isset($res[$key])) {
                    $res[$key] = 0;
                }

                $res[$key] += Transacao::where('user_id', Auth::user()->id)
                    ->where('categoria_id', $categoria->id)
                    ->whereYear('data', $this->periodo[0]->format('Y'))
                    ->sum(DB::raw('quantidade * valor'));
            }
        } else { //Semana e Mês

            foreach ($this->categorias as $key => $categoria) {


                //Percorrer cada categoria
                //somar a quantidade por dia, vou ter um array com a quantidade em cada dia dia
                //somar todos os tipos por dia

                foreach ($this->periodo as $data) {
                    if (!isset($res[$key])) {
                        $res[$key] = 0;
                    }

                    $res[$key] += Transacao::where('user_id', Auth::user()->id)
                        //->where('forma_pagamento', $categoria)
                        ->whereDate('data', '=', $data)
                        ->where('categoria_id', $categoria->id)
                        ->sum(DB::raw('quantidade * valor'));
                }
            }
        }

        return $res;
    }

    public function porsentagem($res) {
        $soma = array_sum($res);

        if ($soma > 0) {
            foreach ($res as $key => $valor) {
                $res[$key] = number_format(($valor / $soma) * 100, 1);
                //0.1212 -> 0.1
            }
        }


        return $res;
    }

    public function somaTransacoesReceber() {
        $somaTotalReceita = 0;
        $somaTotalReceber = 0;

        $somaTotalReceita = Transacao::where('user_id', Auth::user()->id)
            //->whereDate('created_at', '=', $data)
            ->whereNotNull('cliente_id') // CONSIDERANDO A RECEITA DE USUARIOS ESPECIFICOS
            ->whereIn('categoria_id', function ($query) {
                $query->select('id')
                    ->from('categoria_transacao')
                    ->where('tipo', 'Receita');
            })
            ->sum(DB::raw('quantidade * valor'));

        $somaTotalReceber = Transacao::where('user_id', Auth::user()->id)
            // ->whereDate('created_at', '=', $data)
            ->whereIn('categoria_id', function ($query) {
                $query->select('id')
                    ->from('categoria_transacao')
                    ->where('tipo', 'A Receber');
            })
            ->whereNotNull('cliente_id') // CONSIDERANDO A RECEITA DE USUARIOS ESPECIFICOS
            ->sum(DB::raw('quantidade * valor'));


        return abs($somaTotalReceita - $somaTotalReceber);
    }
}

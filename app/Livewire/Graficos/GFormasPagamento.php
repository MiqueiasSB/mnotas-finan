<?php

namespace App\Livewire\Graficos;

use App\Models\Transacao;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GFormasPagamento extends Component {

    public
        $dados = [],
        $legenda = [
            'Pix',
            'Cartão',
            'Dinheiro',
            'Boleto',
            'Transferência',
            'Criptomoeda',
        ],

        $nome,

        $dataAtual,
        $periodo,
        $periodoSelecionado;

    public function mount() {

        $this->atualizarGrafico();
    }

    public function render() {
        return view('livewire.graficos.gFormasPagamento');
    }

    public function atualizarGrafico() {

        //Chama uma função grafica instanciando seu nome dinamicamente
        $funcao = 'grafico' . ucfirst(strtolower($this->periodoSelecionado)); // Por exemplo, 'graficoSemana'
        call_user_func([$this, $funcao]);

        $this->dispatch('atualizaGrafico', [
            'dados' => json_encode($this->dados),
            'legenda' => json_encode($this->legenda)
        ]);
    }
    public function atualizaTipoGrafico() {

        $this->atualizarGrafico();
    }
    public function graficoDia() {


        $res = [];

        foreach ($this->legenda as $key => $formaPagamento) {
                
            $res[$key] = Transacao::where('user_id', Auth::user()->id)
                ->where('forma_pagamento', $formaPagamento)
                ->whereDate('data', '=', $this->dataAtual->format('Y-m-d'))
                ->count();
        }

        // Adiciona o novo elemento (1) no início do array
        //Para renderizar corretamente no gráfico
        //array_unshift($res, '');
        $this->dados = $this->porsentagem($res);
        
    }
    public function graficoSemana() {
        $this->dados = $this->calculaTransacoes();
    }
    public function graficoMes() {
        $this->dados = $this->calculaTransacoes();
    }
    public function graficoAno() {
        $this->dados = $this->calculaTransacoes(true);
    }

    public function calculaTransacoes($ano = false) {

        $res = [];

        if ($ano) {

            foreach ($this->legenda as $key => $formaPagamento) {
                if (!isset($res[$key])) {
                    $res[$key] = 0;
                }

                $res[$key] += Transacao::where('user_id', Auth::user()->id)
                    ->where('forma_pagamento', $formaPagamento)
                    ->whereYear('data', $this->periodo[0]->format('Y'))
                    ->count();
            }
        } else { //Semana e Mês

            foreach ($this->legenda as $key => $formaPagamento) {


                //Percorrer cada forma de pagamento
                //somar a quantidade por dia, vou ter um array com a quantidade em cada dia dia1['pix'=> 10, 'dinheiro'=>21]
                //somar todos os tipos por dia

                foreach ($this->periodo as $data) {
                    if (!isset($res[$key])) {
                        $res[$key] = 0;
                    }

                    $res[$key] += Transacao::where('user_id', Auth::user()->id)
                        ->where('forma_pagamento', $formaPagamento)
                        ->whereDate('data', '=', $data)
                        ->count();
                }
            }
        }

        return $this->porsentagem($res);
    }

    public function porsentagem($res) {
        $soma = array_sum($res);

        if($soma>0){
            foreach ($res as $key => $valor) {
                $res[$key] = number_format(($valor / $soma) * 100, 1);
                //0.1212 -> 0.1
            }
        }
        

        return $res;
    }
}

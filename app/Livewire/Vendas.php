<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Transacao;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Vendas extends Component {

    public $user;
    public $vendas;
    public $item;
    public $quantidade;
    public $valor;
    public $forma_pagamento;
    public $transacao;

    public $somaReceitas;
    public $somaDespesas;

    public $clientes;
    public $clientesArrayId;

    public $vendaTotal;

    public $dataAtual;
    public $venda;

    //------ GRÁFICO DIÁRIO 
    public $intervalo;
    public $IntervaloHorasGrafico;
    public $vendasPorIntervalo;

    protected $listeners = ['atualizarVenda' => 'upGrafico'];


    public function mount() {

        $this->user = Auth::user();
        $this->forma_pagamento = 'fa-solid fa-money-bill-wave';
        $this->dataAtual = now()->format('Y-m-d');
       
        $this->upGrafico($this->dataAtual);
    }



    public function render() {

        $this->quantidade = 1;

        $this->vendas = Transacao::where('user_id', Auth::user()->id)
            //->where('tipo', 1)
            ->whereDate('created_at', $this->dataAtual)
            ->orderBy('created_at', 'desc')
            ->get();

        
        return view('livewire.vendas');
    }

    public function somas() {


        $this->somaReceitas = Transacao::where('user_id', Auth::user()->id)
            ->whereDate('data', '=', $this->dataAtual)
            //->whereNotNull('cliente_id') // CONSIDERANDO A RECEITA DE USUARIOS ESPECIFICOS
            ->whereIn('categoria_id', function ($query) {
                $query->select('id')
                    ->from('categoria_transacao')
                    ->where('tipo', 'Receita');
            })
            ->sum(DB::raw('quantidade * valor'));


        $this->somaDespesas = Transacao::where('user_id', Auth::user()->id)
            ->whereDate('data', '=', $this->dataAtual)
            //->whereNotNull('cliente_id') // CONSIDERANDO A RECEITA DE USUARIOS ESPECIFICOS
            ->whereIn('categoria_id', function ($query) {
                $query->select('id')
                    ->from('categoria_transacao')
                    ->where('tipo', 'Despesa');
            })
            ->sum(DB::raw('quantidade * valor'));;
    }


    public function formatValor($stringNumero) {
        // Remover pontos como separadores de milhares
        $stringNumero = str_replace('.', '', $stringNumero);

        // Substituir a vírgula como separador decimal por um ponto
        $stringNumero = str_replace(',', '.', $stringNumero);

        // Converter a string para um número decimal
        $numeroDecimal = floatval($stringNumero);

        // Agora $numeroDecimal contém o valor desejado
        return $numeroDecimal;
    }


    public function updatedDataAtual() {
        $this->vendas = Transacao::where('user_id', Auth::user()->id)
            ->where('cliente_id', null)
            ->whereDate('created_at', $this->dataAtual)
            ->orderBy('created_at', 'desc')
            ->get();

        //$this->calculaVendaTotal();

        $this->upGrafico();

        $this->dispatch('recarregaLista');
    }

    public function pagamentoClassePraNome($classPagamento) {
        switch ($classPagamento) {
            case 'fa-solid fa-money-bill-wave':
                return 'dinheiro';
                break;

            case 'fa-brands fa-pix':
                return 'pix';
                break;

            case 'fa-solid fa-credit-card':
                return 'cartão';
                break;

            case 'fa-solid fa-receipt':
                return 'boleto';
                break;

            case 'fa-solid fa-arrow-right-arrow-left':
                return 'transferência';
                break;

            case 'bi bi-coin':
                return 'criptomoeda';
                break;
        }
    }

    public function pagamentoNomepraClasse($classPagamento) {
        switch ($classPagamento) {
            case 'dinheiro':

                return 'fa-solid fa-money-bill-wave';
                break;

            case 'pix':

                return 'fa-brands fa-pix';
                break;

            case 'cartão':

                return 'fa-solid fa-credit-card';
                break;

            case 'boleto':

                return 'fa-solid fa-receipt';
                break;

            case 'transferência':
                return 'fa-solid fa-arrow-right-arrow-left';

                break;

            case 'criptomoeda':
                return 'bi bi-coin';

                break;
        }
    }

    //______________________________________________ G R A F I C O __________________________
    public function upGrafico($dataAtual = null) {
        $this->dataAtual = $dataAtual;

        $this->intervalo = 60; //em minutos
        //Depois colocar para o próprio usuário definir o horario de trabalho

        $this->IntervaloHorasGrafico = $this->gerarIntervaloHoras($this->user->config['horarioDeTrabalho'][0], $this->user->config['horarioDeTrabalho'][1],   $this->intervalo);
        //Um array onde cada indice corresponde a um intervalo em horas

        $this->vendasPorIntervalo = $this->CalculaVendasPorIntervalo();
        $this->dispatch('atualizaGrafico', ['dados' =>  $this->vendasPorIntervalo]);

        $this->somas();


    }

    public function gerarIntervaloHoras($horaInicial, $horaFinal, $intervalo) {
        $res = [];

        $horaAtual = strtotime($horaInicial);

        while ($horaAtual <= strtotime($horaFinal)) {
            $res[] = date('H:i', $horaAtual);
            $horaAtual = strtotime('+' . $intervalo . ' minutes', $horaAtual);
        }

        return json_encode($res);
    }

    public function CalculaVendasPorIntervalo() {

        $horas = json_decode($this->IntervaloHorasGrafico);

        $res = [];

        foreach ($horas as $key => $hora) {
            if ($hora !== Arr::last($horas)) { //Não executa o ultimo item pois é o fim do intervalo
                $res[$key] = Transacao::where('user_id', Auth::user()->id)
                    ->whereIn('categoria_id', function ($query) {
                        $query->select('id')
                            ->from('categoria_transacao')
                            ->where('tipo', 'Receita');
                    })
                    ->whereDate('data', '=', $this->dataAtual)
                    ->whereTime('created_at', '>', $hora)
                    ->whereTime('created_at', '<=', $horas[$key + 1])
                    ->sum(DB::raw('quantidade * valor'));
            }
        }

        // Adiciona o novo elemento (1) no início do array
        //Para renderizar corretamente no gráfico
        array_unshift($res, '');

        return json_encode($res);
    }
}

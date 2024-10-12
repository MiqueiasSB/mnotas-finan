<?php

namespace App\Livewire\Graficos;

use App\Models\Transacao;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GLucro extends Component {

    public
        $nome,
        $dadosReceita,
        $dadosDespesa,
        $lucro,
        $legendas,

        $dataAtual,
        $periodo,
        $periodoSelecionado;


    public function mount() {

        $this->atualizarGrafico();
    }
    public function render() {
        return view('livewire.graficos.g-lucro');
    }


    public function atualizarGrafico() {

        //Chama uma função grafica instanciando seu nome dinamicamente
        $funcao = 'grafico' . ucfirst(strtolower($this->periodoSelecionado)); // Por exemplo, 'graficoSemana'
        call_user_func([$this, $funcao]);

        $this->dispatch('atualizaGrafico', [
            'legenda' =>  json_encode($this->legendas),
            'lucro' =>  json_encode($this->calculaLucro()),
        ]);

        $this->lucro = array_sum($this->calculaLucro());
    }

    public function calculaLucro() {
        $lucro = [];
        //  dd($this->dadosReceita);
        foreach ($this->dadosReceita as $key => $valorReceita) {
            // Certifique-se de que os valores são convertidos para números antes da subtração
            $valorReceitaNumerico = is_numeric($valorReceita) ? $valorReceita : 0;
            $despesaNumerica = isset($this->dadosDespesa[$key]) && is_numeric($this->dadosDespesa[$key]) ? $this->dadosDespesa[$key] : 0;

            // Realize a subtração dos valores numéricos
            $lucro[] = $valorReceitaNumerico - $despesaNumerica;
        }

        return $lucro;
    }

    public function atualizaTipoGrafico() {

        $this->atualizarGrafico();
    }
    public function graficoDia() {
        //dd($this->periodo );
        //Selecionar todos as transações-> tipo 1-> do usuario auth->dia 01/01/2001->de hora até hora->soma
        $this->legendas =  $this->periodo;
        $this->dadosReceita = $this->calculaTransacoesPorIntervaloHora('Receita');
        $this->dadosDespesa = $this->calculaTransacoesPorIntervaloHora('Despesa');
    }
    public function graficoSemana() {

        $this->legendas = $this->tradDiaSemana($this->periodo);
        $this->dadosReceita = $this->calculaTransacoes('Receita');
        $this->dadosDespesa = $this->calculaTransacoes('Despesa');
    }
    public function graficoMes() {
        $this->legendas = [];
        foreach ($this->periodo as $data) {
            $this->legendas[] = $data->format('d');
        }

        $this->dadosReceita = $this->calculaTransacoes('Receita');
        $this->dadosDespesa = $this->calculaTransacoes('Despesa');
    }
    public function graficoAno() {
        $this->legendas = [
            'Jan',
            'Fev',
            'Mar',
            'Abr',
            'Mai',
            'Jun',
            'Jul',
            'Ago',
            'Set',
            'Out',
            'Nov',
            'Dez'
        ];

        $this->dadosReceita = $this->calculaTransacoes('Receita', true);
        $this->dadosDespesa = $this->calculaTransacoes('Despesa', true);
    }
    public function tradDiaSemana($arrayDatas) {
        $datasTraduzidas = [];

        $tratucaoDiasdaSemana = [
            'Monday' => 'Segunda',
            'Tuesday' => 'Terça',
            'Wednesday' => 'Quarta',
            'Thursday' => 'Quinta',
            'Friday' => 'Sexta',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ];

        foreach ($arrayDatas as $data) {

            $datasTraduzidas[] = $tratucaoDiasdaSemana[$data->format('l')];
        }

        return $datasTraduzidas;
    }
    public function calculaTransacoesPorIntervaloHora($tipo) {

        $horas = $this->periodo;

        $res = [];

        foreach ($horas as $key => $hora) {
            if ($hora !== Arr::last($horas)) { //Não executa o ultimo item pois é o fim do intervalo

                $res[$key] = Transacao::where('user_id', Auth::user()->id)
                    ->whereIn('categoria_id', function ($query) use ($tipo) {
                        $query->select('id')
                            ->from('categoria_transacao')
                            ->where('tipo', $tipo);
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
        //dd($res);
        return $res;
    }
    public function calculaTransacoes($tipo, $ano = false) {

        $res = [];

        foreach ($this->periodo as $key => $data) {

            if ($ano) {

                $res[$key] = Transacao::where('user_id', Auth::user()->id)
                    ->whereIn('categoria_id', function ($query) use ($tipo) {
                        $query->select('id')
                            ->from('categoria_transacao')
                            ->where('tipo', $tipo);
                    })
                    ->whereRaw('MONTH(data) = ? AND YEAR(data) = ?', [$data->format('m'), $data->format('Y')])
                    ->sum(DB::raw('quantidade * valor'));
            } else {


                $res[$key] = Transacao::where('user_id', Auth::user()->id)
                    ->whereIn('categoria_id', function ($query) use ($tipo) {
                        $query->select('id')
                            ->from('categoria_transacao')
                            ->where('tipo', $tipo);
                    })
                    ->whereDate('data', '=', $data)
                    ->sum(DB::raw('quantidade * valor'));
            }
        }

        return $res;
    }
}

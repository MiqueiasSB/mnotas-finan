<?php

namespace App\Livewire;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Painel extends Component {


    public
        $user,
        $dataAtual,
        $periodoSelecionado,
        $periodo,

        $graficoLegendas = [],
        $graficoValores,
        $diaInicioSemana,

        $diasAtivos,

        $dataInicial,
        $dataFinal,
        $statusNavegData = 0, // Para quando chamar updatedPeriodoSelecionado() resetar se for 0
        $dados = [],

        $variaveisCache = [
            //NOME => VALOR PADRÃO
            'diaInicioSemana' => 'Sunday',
            'periodoSelecionado' => 'Semana',
            'diasAtivos' => [
                'Monday' => true,
                'Tuesday' => true,
                'Wednesday' => true,
                'Thursday' => true,
                'Friday' => true,
                'Saturday' => true,
                'Sunday' => true,
            ]
           
        ];



    public function mount() {

        $this->user = Auth::user();
        $this->dataAtual = now();
        //$this->diaInicioSemana = 'Sunday';
        $this->defineCache();

        $this->updatedPeriodoSelecionado();
    }
 
    public function render() {

        return view('livewire.painel');
    }

    public function defineCache(){
        foreach ($this->variaveisCache as $nome => $valorPadrao) {
            //dd($nome, $valorPadrao);
            $this->$nome = cache()->get($nome, $valorPadrao);

        }
        //dd($this->diasAtivos);
       
    }

    public function updatedPeriodoSelecionado() {
        cache()->put('periodoSelecionado', $this->periodoSelecionado);

        if (!$this->statusNavegData) {
            $this->dataAtual = now();
        }

        switch ($this->periodoSelecionado) {
            case 'Dia':
                //$this->diasAtivos[$this->dataAtual->format('l')] = true;
                $this->periodo = $this->gerarIntervaloHoras($this->user->config['horarioDeTrabalho'][0], $this->user->config['horarioDeTrabalho'][1], '60');

                $this->defineIntervaloData('d/m/Y');

                break;
            case 'Semana':
                $this->periodo = $this->getSemana();

                $this->defineIntervaloData('d/m/Y');

                break;
            case 'Mes':
                $this->periodo = $this->getMes();

                $this->defineIntervaloData('M - Y');

                break;
            case 'Ano':
                $this->periodo = $this->getMesesDoAno();
                $this->defineIntervaloData('Y');

                break;

            default:

                break;
        }


        //$this->dispatch('atualizarGraficos');

    }

    public function defineIntervaloData($formato) {
        if ($this->periodoSelecionado != 'Semana') {

            $this->dataInicial = $this->dataAtual->format($formato);
            $this->dataFinal = null;
        } else if (!empty($this->periodo)) {

            $this->dataInicial = Arr::first($this->periodo)->format($formato);
            $this->dataFinal = Arr::last($this->periodo)->format($formato);
        }
    }

    public function updatedDiasAtivos() {
        cache()->put('diasAtivos', $this->diasAtivos);
        $this->updatedPeriodoSelecionado();
    }
    
    public function updatedDiaInicioSemana() {
        cache()->put('diaInicioSemana', $this->diaInicioSemana);
        $this->updatedPeriodoSelecionado();
    }


    //########################################## Datas
    public function gerarIntervaloHoras($horaInicial, $horaFinal, $intervalo) {
        $res = [];

        $horaAtual = strtotime($horaInicial);

        while ($horaAtual <= strtotime($horaFinal)) {
            $res[] = date('H:i', $horaAtual);
            $horaAtual = strtotime('+' . $intervalo . ' minutes', $horaAtual);
        }

        return $res;
    }
    public function getSemana() {
        $datas = [];
        $hoje = clone $this->dataAtual;
        
         // Verifica se o início da semana está no passado
         
        if ($hoje->format('N') < Carbon::createFromFormat('l', $this->diaInicioSemana)->format('N') ||
            $hoje->format('N') == Carbon::createFromFormat('l', $this->diaInicioSemana)->format('N')+5) {
            $hoje->modify('-1 week');
           // dd($hoje->format('N') , Carbon::createFromFormat('l', $this->diaInicioSemana)->format('N'), '-------');
        }

        $inicioDaSemana = $hoje->startOfWeek()->modify("next $this->diaInicioSemana")->toDateString();
        // Determina a data do fim da semana com base no início da semana
        $dataFinal = (new DateTime($inicioDaSemana))->modify('+6 days');
        $fimDaSemana = $dataFinal->format('Y-m-d');

       
        $dataAtual = new DateTime($inicioDaSemana);
        $dataFinal = new DateTime($fimDaSemana);

        while ($dataAtual <= $dataFinal) {
            if ($this->diasAtivos[$dataAtual->format('l')]) {
                $datas[] = clone $dataAtual;
            }
            $dataAtual->modify('+1 day');
        }

        return $datas;
    }
    public function getMes() {

        $datasAtivasMes = [];
        $mesAtual = $this->dataAtual->format('m');
        $anoAtual = $this->dataAtual->format('Y');
        $totalDiasMes = cal_days_in_month(CAL_GREGORIAN, $mesAtual, $anoAtual); // Total de dias no Mes

        for ($dia = 1; $dia <= $totalDiasMes; $dia++) {
            $data = clone  new DateTime("$anoAtual-$mesAtual-$dia");
            //$diaDaSemana = $data->format('w'); // Dia da semana (0 = Domingo, 1 = Segunda, ..., 6 = Sábado)
            // Nome completo do dia da semana em inglês = ->format('l')
            if ($this->diasAtivos[$data->format('l')]) {
                $datasAtivasMes[] = $data;
            }
        }

        return $datasAtivasMes;
    }
    public function navegData($sentido) {

        $this->statusNavegData = 1;

        switch ($this->periodoSelecionado) {
            case 'Dia':
                $this->dataAtual->modify($sentido . '1 day');
                break;

            case 'Semana':
                $this->dataAtual->modify($sentido . '1 week');
                break;

            case 'Mes':
                $this->dataAtual->modify($sentido . '1 month');
                break;

            case 'Ano':
                $this->dataAtual->modify($sentido . '1 year');
                break;
        }

        $this->updatedPeriodoSelecionado();
    }
    public function getMesesDoAno() {

        $datasMesesAnoAtual = [];
        $anoAtual = $this->dataAtual->format('Y'); // Ano atual

        for ($mes = 1; $mes <= 12; $mes++) {
            $data = new DateTime("$anoAtual-$mes-01");
            $datasMesesAnoAtual[] = $data;
        }

        return $datasMesesAnoAtual;
    }
    //########################################## Tradutor de datas

}

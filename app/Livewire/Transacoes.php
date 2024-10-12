<?php

namespace App\Livewire;

use App\Models\CategoriaTransacao;
use App\Models\Cliente;
use App\Models\Transacao;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class Transacoes extends Component {

    public
        $user,
        $clientes,
        $cliente,
        $clientesArrayId,
        $dividaTotal,

        $transacoes,
        $transacao,

        $transacoesPeriodo = [],

        $somaTransacoesAnteriores,
        $item,
        $quantidade,
        $valor,
        $forma_pagamento,

        $dataAtual,
        $dataInicial,
        $dataFinal,

        $tipoPeriodo = 'Diário',
        $filtro,
        $filtroModelo, // Corresponde ao valor padrão, no caso sem filtro
        $idsTipoSemCategorias,// Serve para guardar os ids especificos para colocar em destaque as transaçõs sem categoria
        $categorias, //Todas as categorias cadastradas
        $categoriaSelecionada = 'Receita',
        $tipoSelecionado = 0,
        $tiposDeCategorias = ['Receita', 'Despesa', 'A Receber'],

        $topCategorias = [
            0 => ['Receita', 'bi bi-arrow-up-right-circle-fill', 'success'],
            2 => ['A Receber', 'bi bi-hourglass-split', 'warning']
        ];

    public function mount($cliente = null, $dataAtual = null) {

        $this->user = Auth::user();
        // O refresh não passa por aqui
        $this->forma_pagamento = 'fa-solid fa-money-bill-wave';
        $this->cliente = $cliente;


        if (empty($this->cliente)) {
            $this->topCategorias = [
                0 => ['Receita', 'bi bi-arrow-up-right-circle-fill', 'success'],
                1 => ['Despesa', 'bi bi-arrow-down-right-circle-fill', 'danger'],
            ];
        }


        $this->quantidade = 1;
        $this->dataAtual = now()->format('Y-m-d');
        $this->categorias = CategoriaTransacao::where('user_id', $this->user->id)->orWhere('user_id', null)->get();
        $this->defineVariavelFiltro();
        $this->defineIdsTipoSemCategorias();
        $this->nomeIdClientes(); //clientesArrayId
        $this->updatedTipoPeriodo();
    }

    public function render() {

        // $this->cliente->divida_total = Cliente::find($this->cliente->id)->divida_total;
        //$transacoes = Transacao::were
        if (!empty($this->cliente)) { //No Painel Cliente
            $this->transacoes = Transacao::where('cliente_id', $this->cliente->id)
                //->whereDate('data', $this->dataAtual)
                ->orderBy('created_at', 'desc')
                ->get();

            $this->dividaTotal = $this->calculaDivida();
        } else {

            //Aplica filtro se tiver
            $this->transacoes = $this->filtrarTransacoes();

            switch ($this->tipoPeriodo) {
                case 'Diário':
                    $this->transacoes = $this->transacoes
                        ->whereDate('data', $this->dataAtual)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    break;

                case 'Mensal':
                    // Extrair ano e mês da variável
                    list($year, $month) = explode('-', $this->dataAtual);
                    $this->transacoes = $this->transacoes
                        ->whereYear('data', $year)
                        ->whereMonth('data', $month)
                        ->whereYear('data_final', $year)
                        ->whereMonth('data_final', $month)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    break;

                case 'Anual':
                    // Extrair ano e mês da variável
                    //list($year, $month) = explode('-', $this->dataAtual);
                    $this->transacoes = $this->transacoes
                        ->whereYear('data', $this->dataAtual)
                        ->orderBy('created_at', 'desc')
                        ->paginate(200);
                    break;

                case 'Personalizado':
                    $this->transacoes = $this->transacoes
                        ->whereDate('data', '>=', $this->dataInicial)
                        ->whereDate('data_final', '<=', $this->dataFinal)
                        ->orderBy('created_at', 'desc')
                        ->get();

                    break;
            }

            $this->transacoesPeriodo =   $this->filtrarTransacoes()
                ->whereDate('data', '<= ', $this->dataFinal)
                ->whereDate('data_final', '>= ', $this->dataInicial)
                ->orderBy('created_at', 'desc')
                ->get();

            // Ordenar transações por período mais longo
            $this->transacoes = $this->transacoes->sortByDesc(function ($transacao) {
                $dataInicio = new DateTime($transacao->data);
                $dataFinal = new DateTime($transacao->data_final);
                return $dataInicio->diff($dataFinal)->days;
            });

            $this->transacoesPeriodo = $this->transacoesPeriodo->sortByDesc(function ($transacao) {
                $dataInicio = new DateTime($transacao->data);
                $dataFinal = new DateTime($transacao->data_final);
                return $dataInicio->diff($dataFinal)->days;
            });


            // Filtrar transaçõesPeriodo para remover as transações que já estão em transacoes
            $this->transacoesPeriodo = $this->transacoesPeriodo->reject(function ($transacao) {
                return $this->transacoes->contains('id', $transacao->id);
            });
        }

        return view('livewire.Transacoes');
    }

    private function defineVariavelFiltro() {
        $this->filtro = [
            'tipo' => [
                'Receita' => [
                    'status' => true,
                    'categorias' => []
                ],
                'Despesa' => [
                    'status' => true,
                    'categorias' => []
                ],
            ]
        ];

        foreach (['Receita', 'Despesa'] as $tipo) {
            $categorias =  $this->categorias->where('tipo', $tipo)->sortBy('nome');;

            foreach ($categorias as $categoria) {

                $this->filtro['tipo'][$tipo]['categorias'][] = [
                    'id' => $categoria->id,
                    'nome' => $categoria->nome,
                    'status' => true,
                ];
            }
        }
        //Seta para corresponder a um valor padrão, um modelo para comparar modificações e saber se tem um filtro aplicado
        $this->filtroModelo = $this->filtro;
    }
    public function defineIdsTipoSemCategorias() {

        $this->idsTipoSemCategorias = ['Receita' => '', 'Despesa' => ''];

        foreach (['Receita', 'Despesa'] as $key => $tipo) {
            $categorias = $this->filtro['tipo'][$tipo]['categorias'];
           
            foreach ($categorias as $key => $categoria) {
                if ($categoria['nome'] == $tipo) {
                    $this->idsTipoSemCategorias[$tipo] = $key;
                }
            }
        }
            
    
    }

    public function limparFiltro() {
        $this->filtro = $this->filtroModelo;
    }

    private function filtrarTransacoes() {
        $query = Transacao::where('user_id', auth()->id()); // ou $this->user->id se você tiver acesso ao usuário

        foreach (['Receita', 'Despesa'] as $tipo) {
            $status = $this->filtro['tipo'][$tipo]['status'];

            if ($status) { //Mostra esse tipo
                $categorias = $this->filtro['tipo'][$tipo]['categorias'];

                // Filtra os itens onde o status é true
                $idsNaoSelecionados = array_column(array_filter($categorias, function ($item) {
                    return $item['status'] === false; // Verifica se o status é true
                }), 'id'); // Extrai os IDs


                //Filtro por categorias específicas
                $query->whereHas('CategoriaTransacao', function ($query) use ($idsNaoSelecionados) {
                    $query->whereNotIn('id', $idsNaoSelecionados);
                });
            } else { //Esconte esse Tipo
                $query->whereHas('CategoriaTransacao', function ($query) use ($tipo) {
                    $query->whereNot('tipo', $tipo);
                });
            }
        }

        return $query;
    }

    public function updatedTipoPeriodo() {

        /*
            Estou usando a DataAtual apenas para mostrar o formato correto na view, 
            Enquanto a DataInicial vai ser usada para ser armazendad no BD.
            Algumas vezes elas vão ser iguais...
        */

        switch ($this->tipoPeriodo) {
            case 'Diário':
                $this->dataAtual = now()->format('Y-m-d');

                $this->dataInicial = $this->dataAtual;
                $this->dataFinal = $this->dataAtual;
                break;

            case 'Mensal':
                $this->dataAtual = now()->format('Y-m');
                $data = new DateTime($this->dataAtual);

                $this->dataInicial = $data->modify('first day of this month')->format('Y-m-d');
                $this->dataFinal = $data->modify('last day of this month')->format('Y-m-d');
                break;

            case 'Anual':
                $this->dataAtual = now()->format('Y');
                $data = new DateTime($this->dataAtual);

                $this->dataInicial = $data->modify('first day of January this year')->format('Y-m-d');
                $this->dataFinal = $data->modify('last day of December this year')->format('Y-m-d');
                break;

            case 'Personalizado':
                //Não precisa usar a Data Atual
                $this->dataInicial = now()->format('Y-m-d');
                $this->dataFinal = now()->format('Y-m-d');

                break;
        }
    }

    public function updatedDataInicial() {
        //Serve para evitar que a data final seje anterior a data inicial
        $inicial = new DateTime($this->dataInicial);
        $final = new DateTime($this->dataFinal);

        if ($this->tipoPeriodo == 'Personalizado' && $inicial > $final) {
            $this->dataFinal = $inicial;
            $this->dataFinal = $this->dataFinal->modify('+1 day')->format('Y-m-d');
        }
    }

    public function save() {
        /*
            Categorias Genêricas

            Abrange totos os usuários

            id - 1 - Receita
            id - 2 - Despesa
            id - 3 - A Receber
        
        */
        $saveFormaPagamento = $this->pagamentoClassePraNome($this->forma_pagamento);

        if ($this->tiposDeCategorias[$this->tipoSelecionado] == 'A Receber') {
            $saveFormaPagamento = null;
        }

        Transacao::create([
            'item' => $this->item,
            'valor' => $this->formatValor($this->valor),
            'quantidade' => $this->quantidade,
            'categoria_id' => $this->idCategoria(),
            'cliente_id' => ($this->cliente->id ?? null),
            'user_id' => $this->user->id,
            'forma_pagamento' =>  $saveFormaPagamento,
            'data' => $this->dataInicial,
            'data_final' => $this->dataFinal
        ]);


        //Reseta os Campos
        $this->item = '';
        $this->quantidade = 1;
        $this->valor = '';

        $this->atualizarVenda();

        $this->dispatch('fecharFormModal');
    }
    public function nomeIdClientes() {
        //Serve para facilitar a chamada do id de cada venda e relacionar com seu usuario

        $this->clientes = Cliente::where('user_id', $this->user->id)->get();

        foreach ($this->clientes as $cliente) {
            $this->clientesArrayId[$cliente->id] = $cliente;
        }
    }
    public function idCategoria() {

        return CategoriaTransacao::where(function ($query) {
            $query->where('user_id', $this->user->id)
                ->orWhereNull('user_id');
        })
            ->where('tipo', $this->tiposDeCategorias[$this->tipoSelecionado])
            ->where('nome', $this->categoriaSelecionada)
            ->first()->id;
    }

    public function view($transacaoId) {
        //$this->dispatch('abrirViewModal');

        //Resgata dados da transacao selecionada
        $this->transacao = Transacao::where('id', $transacaoId)->first();
        $categoriaTransacao = CategoriaTransacao::find($this->transacao->categoria_id);

        //Insere valores no formulário
        $this->quantidade =  $this->transacao->quantidade;
        $this->item =  $this->transacao->item;
        $this->categoriaSelecionada =  $categoriaTransacao->nome;
        $this->tipoSelecionado = array_search($categoriaTransacao->tipo, $this->tiposDeCategorias = ['Receita', 'Despesa', 'A Receber']);
        $this->forma_pagamento =  $this->pagamentoNomepraClasse($this->transacao->forma_pagamento);
        $this->valor = number_format($this->transacao->valor, 2, ',', '.');

        $this->dispatch('abrirViewModal');
        $this->dispatch('noneBtnPlus');
    }

    public function limparModal() {
        $this->quantidade =  1;
        $this->item =  '';
        $this->categoriaSelecionada =  'Receita';
        $this->tipoSelecionado = 0;
        $this->forma_pagamento =  $this->pagamentoNomepraClasse('dinheiro');
        $this->valor =  '';
    }

    public function up() {

        $this->transacao->update([
            'item' => $this->item,
            'valor' =>  $this->formatValor($this->valor),
            'quantidade' => $this->quantidade,
            'categoria_id' => $this->idCategoria(),
            'cliente_id' => ($this->cliente->id ?? null),
            'user_id' => $this->user->id,
            'forma_pagamento' =>  $this->pagamentoClassePraNome($this->forma_pagamento)
        ]);

        $this->dispatch('fecharViewModal');
    }

    public function destroy() {



        Transacao::find($this->transacao->id)->delete();
        //dd($transacao = Transacao::find($this->transacao->id));
        // Atualização da divida total do cliente
        $this->transacao = null;

        $this->atualizarVenda();

        $this->dispatch('fecharViewModal');
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

    public function navegDatas($sentido) {


        switch ($this->tipoPeriodo) {
            case 'Diário':
                $this->dataAtual = new DateTime($this->dataAtual);
                $this->dataAtual->modify($sentido . '1 day');
                $this->dataAtual = $this->dataAtual->format('Y-m-d');

                $this->dataInicial = $this->dataAtual;
                $this->dataFinal = $this->dataAtual;

                break;

            case 'Mensal':
                $this->dataAtual = new DateTime($this->dataAtual);
                $this->dataAtual->modify($sentido . '1 month');
                $this->dataAtual = $this->dataAtual->format('Y-m');

                $data = new DateTime($this->dataAtual);

                $this->dataInicial = $data->modify('first day of this month')->format('Y-m-d');
                $this->dataFinal = $data->modify('last day of this month')->format('Y-m-d');
                break;

            case 'Anual':
                $this->dataAtual = new DateTime($this->dataAtual . '-01-01');

                $this->dataAtual->modify($sentido . '1 year');
                $data = new DateTime($this->dataAtual->format('Y-m-d'));

                // Definir as datas inicial e final do ano
                $this->dataInicial = $data->modify('first day of January this year')->format('Y-m-d');
                $this->dataFinal = $data->modify('last day of December this year')->format('Y-m-d');

                // Atualizar a data atual para o formato 'Y'
                $this->dataAtual = $data->format('Y');

                break;
            case 'Personalizado':
                //Não precisa usar a Data Atual
                $this->dataInicial = now()->format('Y-m-d');
                $this->dataFinal = now()->format('Y-m-d');

                break;
        }

        $this->atualizarVenda();
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

            case '':
                return null;
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

    public function atualizarVenda() {


        $this->dispatch('atualizarVenda', $this->dataAtual);
    }

    public function calculaDivida() {

        $somaReceitas = Transacao::where('user_id', Auth::user()->id)
            ->where('cliente_id', $this->cliente->id)
            ->whereIn('categoria_id', function ($query) {
                $query->select('id')
                    ->from('categoria_transacao')
                    ->where('tipo', 'Receita');
            })
            ->sum(DB::raw('quantidade * valor'));

        $somaAReceber = Transacao::where('user_id', Auth::user()->id)
            ->where('cliente_id', $this->cliente->id)
            ->whereIn('categoria_id', function ($query) {
                $query->select('id')
                    ->from('categoria_transacao')
                    ->where('tipo', 'A Receber');
            })
            ->sum(DB::raw('quantidade * valor'));

        return  $somaAReceber - $somaReceitas;
    }

    public function corItem($tipo) {
        $cor = null;
        $corContraste = '#000';

        switch ($tipo) {
            case 'Receita':
                $cor = '#10b981';
                $corContraste = '#094430';
                break;

            case 'Despesa':
                $cor = '#dc2626';
                break;

            default:
                $cor = '#F59E0B';
                break;
        }

        return "background: linear-gradient(90deg, {$cor} 10%, {$corContraste} 50%, {$cor} 90%);";
    }
}

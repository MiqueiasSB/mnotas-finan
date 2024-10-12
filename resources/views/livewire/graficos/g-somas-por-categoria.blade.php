<div style=" transition: all 0.2s ease;">
    <div class="row g-2 mb-2">

        @foreach ($itens as $key => $item)
            <div class="col" wire:key="itemSoma_{{ $key }}">
                <button wire:click="ativarBtn({{ $key }})" style=" transition: all 0.2s ease;"
                    class="w-100 h-100 bg-white p-sm-3 border {{ $item['btnAtivo'] ? 'rounded-top border-' . $item['class'] . ' shadow-lg-' . $item['class'] : 'rounded shadow-sm border-gray-400' }} ">
                    <small>{{ $item['titulo'] }}</small>
                    <br>
                    <span class="text-{{ $item['class'] }} fw-bold">
                        R$ {{ number_format($item['soma'], 2, ',', '.') }}
                    </span>
                </button>
            </div>
        @endforeach
    </div>


    <div class="row g-2 {{ $this->idItemAtivo == 2 ? 'd-none' : '' }}">
        <div class="col-12">
            <div class="w-100 bg-white p-sm-3 shadow shadow-sm border border-gray-400 rounded-bottom">
                <div class="row justify-content-center">
                    <div class="col-11 d-none d-sm-block">
                        <div class="w-100" id="piechartDesktop" style="height: 30em;"></div>
                    </div>
                    <div class="col-11 d-block d-sm-none">
                        <div class="w-100" id="piechartMobile" style="height: 20em;"></div>
                    </div>

                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                    @script
                        <script type="text/javascript">
                            // Evento disparado pelo Livewire para atualizar o gráfico com novos dados
                            $wire.on('atualizaGrafico', function(dados) {

                                // Função para gerar uma paleta de cores verdes suaves
                                function gerarVerde(size) {
                                    var colors = [];
                                    for (var i = 0; i < size; i += 1.5) {
                                        var greenValue = 255 - Math.floor((i * (255 / size))); // Calcula o valor do verde
                                        colors.push(`rgb(0, ${greenValue}, 80)`); // Adiciona a cor à paleta
                                    }
                                    return colors;
                                }

                                // Função para gerar uma paleta de cores vermelhas suaves
                                function gerarVermelho(size) {
                                    var colors = [];
                                    for (var i = 0; i < size; i += 1.5) {
                                        var redValue = 255 - Math.floor((i * (255 / size))); // Calcula o valor do vermelho
                                        colors.push(`rgb(${redValue}, 50, 50)`); // Adiciona a cor à paleta
                                    }
                                    return colors;
                                }

                                // Parse dos dados recebidos
                                legendaSC = JSON.parse(dados[0].legenda); // Lê as categorias da legenda
                                dataSC = JSON.parse(dados[0].dados); // Lê os valores dos dados
                                idAtivoSC = JSON.parse(dados[0].idAtivo); // Lê o ID ativo para determinar a cor

                                // Carrega a biblioteca do Google Charts
                                google.charts.load('current', {
                                    'packages': ['corechart']
                                });

                                // Define a função de callback para desenhar o gráfico após carregar a biblioteca
                                google.charts.setOnLoadCallback(drawChart);

                                // Função para desenhar o gráfico
                                function drawChart() {
                                    var categories = legendaSC; // Obtém as categorias
                                    var values = dataSC; // Obtém os valores

                                    // Cria um array de dados para o gráfico
                                    var dataArray = [
                                        ['Categoria', 'Valor']
                                    ];
                                    for (var i = 0; i < categories.length; i++) {
                                        dataArray.push([categories[i], values[
                                            i]]); // Adiciona as categorias e valores ao array de dados
                                    }

                                    var data = google.visualization.arrayToDataTable(
                                        dataArray); // Converte o array de dados para o formato do Google Charts

                                    // Formata os números do gráfico
                                    var formatter = new google.visualization.NumberFormat({
                                        prefix: '',
                                        negativeColor: 'red',
                                        negativeParens: true
                                    });
                                    formatter.format(data, 1);

                                    // Gera a paleta de cores com base no ID ativo
                                    var colors;
                                    if (idAtivoSC) { // Se o ID ativo for verdadeiro, usa a paleta vermelha
                                        colors = gerarVermelho(categories.length);
                                    } else { // Caso contrário, usa a paleta verde
                                        colors = gerarVerde(categories.length);
                                    }

                                    // Define as opções do gráfico
                                    var options = {
                                        pieSliceText: 'value',
                                        colors: colors,
                                        chartArea: {
                                            top: 7,
                                            width: '90%',
                                            height: '90%'
                                        },
                                        legend: {
                                            position: 'none',
                                            textStyle: {
                                                fontSize: 12
                                            }
                                        }
                                    };

                                    // Cria uma visão de dados para o gráfico
                                    var view = new google.visualization.DataView(data);
                                    view.setColumns([{
                                        calc: function(dt, row) {
                                            return dt.getValue(row, 0); // Calcula o valor da coluna 'Categoria'
                                        },
                                        type: 'string',
                                        label: 'Categoria'
                                    }, 1]);


                                    if ($('#piechartDesktop').is(':visible')) {
                                        var chart = new google.visualization.PieChart(document.getElementById('piechartDesktop'));
                                    } else if ($('#piechartMobile').is(':visible')) {
                                        var chart = new google.visualization.PieChart(document.getElementById('piechartMobile'));
                                    }
                                    // Desenha o gráfico de pizza
                                  
                                    chart.draw(view, options);

                                    // Adiciona event listeners aos itens da legenda
                                    categories.forEach((category, index) => {
                                        const legendItem = document.querySelector(`.legend-item-${index}`);
                                        const legendGeral = document.querySelectorAll(`.legend-geral`);
                                        const colorItem = document.querySelector(`.color-item-${index}`);
                                        const colorGeral = document.querySelectorAll(
                                            '.color-geral'); // Seleciona todos os elementos com a classe 'color-geral'

                                        // Adiciona cor de fundo ao item da legenda
                                        colorItem.style.background = colors[index];

                                        // Adiciona um listener de clique ao item da legenda
                                        legendItem.addEventListener('click', () => {
                                            const selection = chart.getSelection(); // Obtém a seleção atual do gráfico
                                            if (selection.length > 0 && selection[0].row === index) {
                                                chart.setSelection([]); // Desseleciona se já estiver selecionado
                                                // Remove a borda de todos os elementos
                                                colorGeral.forEach(elemento => {
                                                    elemento.style.border = 'none';
                                                });
                                                // Remove o sublinhado de todos os itens da legenda
                                                legendGeral.forEach(item => {
                                                    item.classList.remove('underline');
                                                });
                                            } else {
                                                chart.setSelection([{
                                                    row: index
                                                }]); // Seleciona o item clicado
                                                // Remove a borda de todos os elementos
                                                colorGeral.forEach(elemento => {
                                                    elemento.style.border = 'none';
                                                });
                                                // Remove o sublinhado de todos os itens da legenda
                                                legendGeral.forEach(item => {
                                                    item.classList.remove('underline');
                                                });
                                                // Adiciona o sublinhado ao item da legenda selecionado
                                                legendItem.classList.add('underline');
                                                // Adiciona a borda ao item da cor correspondente
                                                colorItem.style.border = 'solid black 1px';
                                            }
                                        });

                                        /*
                                        legendItem.addEventListener('mouseover', () => {
                                            chart.setSelection([{
                                                row: index
                                            }]);
                                        });
                                        legendItem.addEventListener('mouseout', () => {
                                            chart.setSelection([]);
                                        });
                                        */
                                    });
                                }
                            });
                        </script>
                    @endscript
                </div>

                <div class="row mb-1 px-md-3 px-sm-3 px-3">
                    <div class="d-flex align-content-start justify-content-center flex-wrap text-center overflow-y-scroll rounded"
                        style="max-height: 10em; box-shadow: inset 1px 1px 5px rgba(185, 185, 185, 0.2);">
                        @foreach ($this->dados as $key => $dado)
                            @if ($dado != 0)
                                <div
                                    class="p-3  d-flex align-items-center cursor-pointer legend-geral legend-item-{{ $loop->index }}">
                                    <div class="rounded-circle me-1 color-geral color-item-{{ $loop->index }}"
                                        style="width: 1em; height: 1em;"></div>
                                    <span class="text-capitalize fw-bold"
                                        style="font-size: 0.7em">{{ $this->legenda[$key] }}: </span>
                                    <span class=""
                                        style="font-size: 0.7em">R${{ number_format($dado, 2, ',', '.') }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>




</div>

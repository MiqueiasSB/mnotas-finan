<x-caixa loading="true" class="p-2">
    <div class="row align-items-end mx-1">
        <h3 class="col">Receitas e Despesas</h3>
    </div>

    <div >
        <canvas wire:ignore.self height="200" id="{{ $nome }}"></canvas>
    </div>



   





    @script
        <script>
            let chart;

            $wire.on('atualizaGrafico', function(dados) {

                legenda = JSON.parse(dados[0].legenda);
                dadosReceita = JSON.parse(dados[0].dadosReceita);
                dadosDespesa = JSON.parse(dados[0].dadosDespesa);

                // Destrói o gráfico existente se ele já foi criado
                if (chart) {
                    chart.destroy();
                }


                const ctx = document.getElementById("{{ $nome }}");


                chart = new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        labels: legenda,
                        datasets: [{
                                type: 'bar',
                                label: 'Receita',
                                data: dadosReceita,
                                borderWidth: 1,
                                fill: true,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgb(75, 192, 192)',

                            },
                            {
                                type: 'line',
                                label: 'Despesas',
                                data: dadosDespesa,
                                fill: false,
                                borderColor: '#DC2626',
                                tension: 0.3
                            },
                        ]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                    }
                });
            });
        </script>
    @endscript

</x-caixa>

<x-caixa>
    <small>Total de Lucro</small>
    <div class="row">
        <div class="col-12">
            <span class="display-6 fw-bold text-primary">
                R$ {{ number_format($lucro, 2, ',', '.') }}
            </span>
        </div>
        <div class="col-12">


            <canvas wire:ignore.self width="800" height="500" id="{{ $nome }}"></canvas>


        </div>
    </div>

    @script
        <script>
            let chart;

            $wire.on('atualizaGrafico', function(dados) {

                legenda = JSON.parse(dados[0].legenda);
                lucro = JSON.parse(dados[0].lucro);

                // Destrói o gráfico existente se ele já foi criado
                if (chart) {
                    chart.destroy();
                }


                const ctx = document.getElementById("{{ $nome }}");


                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: legenda,
                        datasets: [{
                            label: 'Lucro',
                            data: lucro,
                            borderWidth: 1,
                            fill: true,
                            backgroundColor: '#2564eb86',
                            borderColor: '#2563eb',
                            tension: 0.3,
                            //pointStyle: 'hidden' // Oculta os pontos do gráfico de linha
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        scales: {
                            x: {
                                display: true, // Exibir o eixo X
                                grid: {
                                    display: false // Remover a grade do eixo X
                                }
                            },
                            y: {
                            
                                display: true, // Exibir o eixo Y
                                grid: {
                                    display: true // Remover a grade do eixo Y
                                }
                            }
                        }
                    }
                })
            });
        </script>
    @endscript
</x-caixa>

<x-caixa>
    <span>Formas de pagamento <small>%</small></span>

    <div class="mt-4">
        <canvas id="{{ $nome }}"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @script
        <script>
            let chart;

            $wire.on('atualizaGrafico', function(dados) {

                legenda = JSON.parse(dados[0].legenda);
                dados = JSON.parse(dados[0].dados);

                // Destrói o gráfico existente se ele já foi criado
                if (chart) {
                    chart.destroy();
                }

                const ctx = document.getElementById("{{ $nome }}");

                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: legenda,
                        datasets: [{
                            label: '',
                            data: dados,
                            borderWidth: 1,
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                '#2563eb',
                                '#dc2626',
                                '#10b981'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true, // Mantém a legenda visível
                                position: 'bottom', // Você pode alterar a posição conforme necessário (top, bottom, left, right)
                            },
                            tooltip: {
                                enabled: true, // Mantém o tooltip sempre visível
                            }
                        }
                    }
                });
            });
        </script>
    @endscript

</x-caixa>

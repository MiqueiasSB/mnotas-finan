<div class="row">
    <div class="col-12 d-none d-sm-block">
        <canvas x-show="true" class="" wire:key="graficoDiaDesktop" wire:ignore.self width="6" height="1" id="myChartDesktop"></canvas>
    </div>
    <div class="col-12 d-block d-sm-none">
        <canvas x-show="true" class="" wire:key="graficoDiaMobile" wire:ignore.self width="5" height="3" id="myChartMobile"></canvas>
    </div>
</div>

@script
<script>
    let myChart; // Declare a variável fora do escopo da função para que seja acessível em todas as chamadas

    $wire.on('atualizaGrafico', function(dados) {
        dados = JSON.parse(dados[0].dados);

        let ctx;
        if ($('#myChartDesktop').is(':visible')) {
            ctx = $('#myChartDesktop');
            console.log('DESK');
        } else if ($('#myChartMobile').is(':visible')) {
            ctx = $('#myChartMobile');
            console.log('MOB');
        }

        
        // Destrói o gráfico existente se ele já foi criado
        if (myChart) {
            myChart.destroy();
        }

        // Cria uma nova instância do gráfico com os dados atualizados
        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $this->IntervaloHorasGrafico !!},
                datasets: [{
                    label: 'Venda Diária',
                    data: dados,
                    borderWidth: 1,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        display: false, // Configuração para ocultar a grade do eixo Y
                    },
                    x: {
                        //display: false, // Configuração para ocultar a grade do eixo Y
                    }
                }
            }
        });
    });
</script>

@endscript

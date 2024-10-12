<div class="col-12">
    <div class="row">

        <div class="col text-center">
            <x-caixa>
                <small class="text-start">Total de Receitas</small>
                <h4 class="m-0 text-success fw-bold">
                    R$ {{ number_format($this->somaReceitas, 2, ',', '.') }}
                </h4>

            </x-caixa>
        </div>

        <div class="col text-center">
            <x-caixa>
                <small class="text-start">Total de Despesas</small>
                <h4 class="m-0 text-danger fw-bold">
                    R$ {{ number_format($this->somaDespesas, 2, ',', '.') }}
                </h4>
            </x-caixa>
        </div>

    </div>
</div>

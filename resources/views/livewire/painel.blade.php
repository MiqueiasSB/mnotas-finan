<div class="row gx-3">

  
    <div class="col-lg-9">   
        
     
        <div class="row mb-3">
            
            <livewire:graficos.gSomasPorCategoria
                key="{{ 'gSomasPorCategoria' . now() }}"
                :dataAtual="$dataAtual"
                :periodo="$periodo"
                :periodoSelecionado="$periodoSelecionado"
            ></livewire:graficos.gSomasPorCategoria>
          
        </div>

        <div class="row g-2">

            <div class="col-12">

                <livewire:graficos.gVendasPorPeriodo key="{{ 'gVendasPorPeriodo_' . now() }}" nome="VendasPorPeriodo"
                    :dataAtual="$dataAtual" :periodo="$periodo" :periodoSelecionado="$periodoSelecionado"></livewire:graficos.gVendasPorPeriodo>

            </div>

            <div class="col-12">
                <livewire:graficos.gLucro key="{{ 'gLucro_' . now() }}" nome="gLucro" :dataAtual="$dataAtual"
                    :periodo="$periodo" :periodoSelecionado="$periodoSelecionado">
                </livewire:graficos.gLucro>
            </div>

        </div>

    </div>

    <div class="col-lg-3 ">
        <div class="row gy-3">

            <div class="col-12 d-lg-block d-none">
                <x-painel.filtro></x-painel.filtro>
            </div>

            <div class="d-lg-none d-block">
                <x-painel.filtroSm></x-painel.filtroSm>
            </div>

            <div class="col-12">
                <livewire:graficos.gFormasPagamento key="{{ 'gFormaPagamento_' . now() }}" nome="formaPagamento"
                    :dataAtual="$dataAtual" :periodo="$periodo" :periodoSelecionado="$periodoSelecionado">
                </livewire:graficos.gFormasPagamento>
            </div>
        </div>

    </div>
</div>

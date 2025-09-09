<div class="mt-2">
    @php
    //$this->transacoes = $this->transacoes->paginate($this->quantPaginas);
    @endphp
    <x-transacao.viewTransacao></x-transacao.viewTransacao>

    <div class="row gy-2">
        @if (empty($this->cliente))
        <x-transacao.filtroIndex></x-transacao.filtroIndex>
        @endif

        @if (count($this->transacoes) !== 0){{-- Verifica se objeto é vazio --}}

        @foreach ($this->transacoes as $transacao)
        <div class="d-none d-sm-block">
            <x-transacao.itemLista :item="$transacao"></x-transacao.itemLista>
        </div>
        <div class="d-block d-sm-none">
            <x-transacao.itemListaMobile :item="$transacao"></x-transacao.itemListaMobile>
        </div>
        @endforeach
        @else
        <span class="text-center opacity-25 my-4">Nenhum item...</span>
        @endif


        @if (count($this->transacoesPeriodo) !== 0){{-- Verifica se objeto é vazio --}}
        <div class="accordion accordion-flush mt-5 mb-4 " id="accordionFlushExample">
            <div class="accordion-item ">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-light rounded collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true"
                        aria-controls="flush-collapseOne">
                        Percorre o Período
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse show"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body row gy-2 px-0">

                        @foreach ($this->transacoesPeriodo as $transacaoP)
                        <div class="d-none d-sm-block">
                            <x-transacao.itemLista :item="$transacaoP"></x-transacao.itemLista>
                        </div>
                        <div class="d-block d-sm-none">
                            <x-transacao.itemListaMobile :item="$transacaoP"></x-transacao.itemListaMobile>
                        </div>
                        @endforeach

                    </div>
                </div>


            </div>

        </div>
        @endif



    </div>

</div>

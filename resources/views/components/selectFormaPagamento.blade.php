<div x-data="{
    open: false,
    ativo: @entangle('forma_pagamento'),
    itens: [
        ['Dinheiro', 'fa-solid fa-money-bill-wave'],
        ['PIX', 'fa-brands fa-pix'],
        ['Cartão', 'fa-solid fa-credit-card'],
        ['Boleto', 'fa-solid fa-receipt'],
        ['Transferência', 'fa-solid fa-arrow-right-arrow-left'],
        ['Criptomoeda', 'bi bi-coin']
    ]
}" x-on:click.away="open = false" class="h-100 d-flex">

    <button x-bind:disabled="tipoSelecionado == 2" x-on:click="open = !open" type="button" class=" btn btn-light w-100 h-100">
        <i x-bind:class="ativo"></i>
    </button>
    
    <div class="position-absolute bg-light my-2 p-3 rounded row row-cols-2 z-1 mt-5" x-show="open">

        <template x-for="(item, index) in itens" :key="index">

            <button type="button" x-on:click="ativo = item[1], open = false" class="btn btn-light">
                <i x-bind:class="item[1]"></i>
                <small x-text="item[0]"></small>
            </button>
            
        </template>

    </div>
    
</div>

<div x-data="{
    ativo: @entangle('forma_pagamento'),
    itens: [
        ['Dinheiro', 'fa-solid fa-money-bill-wave'],
        ['PIX', 'fa-brands fa-pix'],
        ['Cartão', 'fa-solid fa-credit-card'],
        ['Boleto', 'fa-solid fa-receipt'],
        ['Transferência', 'fa-solid fa-arrow-right-arrow-left'],
        ['Criptomoeda', 'bi bi-coin']
    ]
}" class=" row row-cols-3 g-2">

    <template x-for="(item, index) in itens" :key="index">
        <div class="col">
            <button
                type="button"
                x-on:click="ativo = item[1]"
                class="btn w-100 h-100 pt-3"
                :class="ativo === item[1] ? 'btn-primary text-white' : 'btn-outline-primary text-primary'">
                <div class="d-flex flex-column align-items-center">
                    <i x-bind:class="item[1]" class="fs-4 mb-1"></i>
                    <small x-text="item[0]"></small>
                </div>
            </button>
        </div>
    </template>
</div>

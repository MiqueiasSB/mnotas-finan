<form wire:submit.prevent="save" x-data="{
    tipoSelecionado: @entangle('tipoSelecionado'),
}">
    <div class="row align-items-center gy-md-2 gy-3 my-1">
        <div class=" col-lg-1 col-md-3 col-6 order-md-1 order-2">
            <input id="inputQuantidade" type="number" class="form-control @error('quantidade') is-invalid @enderror"
                wire:model="quantidade">
            @error('quantidade')
                <span class="invalid-feedback">Minimo 1</span>
            @enderror
        </div>

        <div class="col-lg-4 col-md-9 col-12 order-md-2 order-1">

            <input id="inputItem" required type="text"
                class="form-control text-capitalize @error('item') is-invalid @enderror" placeholder="Item"
                wire:model="item">

            @error('item')
                <span class="invalid-feedback">Descrição Obrigatória</span>
            @enderror
        </div>

        <div class="col-lg-3 col-md-4 col-12 order-md-2 order-1">
            <x-transacao.selectCategoria></x-transacao.selectCategoria>
        </div>

        <div class="col-lg-1 col-md-4 col-12 order-md-2 order-1">
            <x-selectFormaPagamento></x-selectFormaPagamento>
        </div>

        <div class="col-lg-2 col-md-4 col-6 order-md-3 order-3">
            <div class="input-group">
                <div class="input-group-text">R$</div>
                <input id="inputValor" x-mask:dynamic="$money($input, ',', '.')" placeholder="0,00" required
                    type="text" class="form-control @error('valor') is-invalid @enderror" wire:model="valor">
            </div>
            @error('valor')
                <span class="invalid-feedback">Valor menor ou igual a 0</span>
            @enderror
        </div>

        <template x-if="!view">
            <div id="btnPlus" class="mt-sm-2 mt-5 col-lg-1 col-md-12 col-12 order-md-4 order-4">
                <button type="submit" @if(!Auth::user()->subscription('default')) disabled @endif
                    class="btn btn-light text-primary w-100">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </template>
    </div>
</form>

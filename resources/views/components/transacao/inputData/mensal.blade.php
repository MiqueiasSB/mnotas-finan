{{-- INPUT DATA DIÁRIO --}}

<div class="input-group input-group-lg">
    <button class="btn btn-light h-100 z-0" wire:click="navegDatas('-')">
        <i class="bi bi-caret-left-fill"></i>
    </button>
    <input
        class="form-control fw-bold text-light text-center text-capitalize {{ $this->dataAtual == now()->format('Y-m') ? 'bg-success' : 'bg-warning' }}"
            type="month" wire:model.lazy="dataAtual">

    <button class="btn btn-light z-0" wire:click="navegDatas('+')">
        <i class="bi bi-caret-right-fill"></i>
    </button>
</div>

{{-- INPUT DATA ANUAL --}}

<div class="input-group input-group-lg d-flex">
    <button class="btn btn-light z-0" wire:click="navegDatas('-')">
        <i class="bi bi-caret-left-fill"></i>
    </button>

    <div class="btn text-light fw-bold flex-fill z-0 {{ $this->dataAtual == now()->format('Y') ? 'bg-success' : 'bg-warning' }}">
        {{ $this->dataAtual }}
    </div>

    <button class="btn btn-light z-0" wire:click="navegDatas('+')">
         <i class="bi bi-caret-right-fill"></i>
    </button>
</div> 

{{-- INPUT DATA DIÁRIO --}}


<div class="input-group input-group-lg ">
    <button class="btn btn-light z-0" wire:click="navegDatas('-')"> 
        <i class="bi bi-caret-left-fill"></i>
    </button>

    <input
        class="form-control fw-bold text-light text-center {{ $this->dataAtual == now()->format('Y-m-d') ? 'bg-success' : 'bg-warning' }}"
         type="date" wire:model.live="dataAtual" {{-- max="{{ now()->format('Y-m-d') }}" --}}>

    <button class="btn btn-light z-0" wire:click="navegDatas('+')">
         <i class="bi bi-caret-right-fill"></i>
    </button> 

</div> 
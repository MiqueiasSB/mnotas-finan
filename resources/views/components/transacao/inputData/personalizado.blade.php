{{-- INPUT DATA PERSONALIZADO --}}
<div class="input-group input-group-lg ">
    <input
        class="form-control fw-bold text-light text-center bg-info "
         type="date" wire:model.live="dataInicial">

    <input
         class="form-control fw-bold text-light text-center bg-info"
          type="date" wire:model.live="dataFinal"  min="{{ $this->dataInicial }}">
 

</div> 

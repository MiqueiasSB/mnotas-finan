<div class="col-12">
    <div class="d-flex flex-sm-row flex-column gap-3 my-1 justify-content-sm-between justify-content-center">
      
        <div class="d-flex"> 
            <div class="form-floating me-2">
                <select class="form-select" wire:model.live="tipoPeriodo" aria-label="tipoPeriodo">
                    <option value="Diário">Diário</option>
                    <option value="Mensal">Mensal</option>
                    <option value="Anual">Anual</option>
                    <option value="Personalizado">Personalizado</option>
                </select>
                <label for="floatingSelectGrid ">Período</label>
            </div>

           <x-transacao.filtroTipo></x-transacao.filtroTipo>
        </div>
        

        <div class="">
            @switch($this->tipoPeriodo)
                @case('Diário')
                    <x-transacao.inputData.diario></x-transacao.inputData.diario>
                @break

                @case('Mensal')
                    <x-transacao.inputData.mensal></x-transacao.inputData.mensal>
                @break

                @case('Anual')
                    <x-transacao.inputData.anual></x-transacao.inputData.anual>
                @break

                @case('Personalizado')
                    <x-transacao.inputData.personalizado></x-transacao.inputData.personalizado>
                @break
            @endswitch
        </div>

    </div>
</div>

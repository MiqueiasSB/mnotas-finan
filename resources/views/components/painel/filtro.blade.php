<x-caixa class="px-3">
    <h3 class="row">
        <span class="p-0"><i class="m2 bi bi-funnel-fill"></i> Filtro</span>
    </h3>

    <div class="row mt-2">
        <select wire:model.live="periodoSelecionado" wire:change="$set('statusNavegData', 0)" class="form-select"
            aria-label="periodo">
            <option value="Dia">Dia</option>
            <option value="Semana">Semana</option>
            <option value="Mes">Mês</option>
            <option value="Ano">Ano</option>
        </select>
    </div>

    <div class="row mt-2 form-floating">

        <select id="floatingSelect" wire:model.live="diaInicioSemana" class="form-select" aria-label="periodo">
            <option value="Monday">Segunda-feria</option>
            <option value="Tuesday">Terça-feria</option>
            <option value="Wednesday">Quarta-feria</option>
            <option value="Thursday">Quinta-feria</option>
            <option value="Friday">Sexta-feria</option>
            <option value="Saturday">Sábado</option>
            <option value="Sunday">Domingo</option>
        </select>
        <label for="floatingSelect">Inicio da Semana</label>
    </div>

    <div class="row mt-2 text-center align-items-center">
        <div class="btn-group p-0" role="group" aria-label="Basic example">
            <button type="button" class="col-2 btn btn-light" wire:click="navegData('-')">
                <i class="bi bi-caret-left-fill"></i>
            </button>
            <button type="button" class="col btn btn-light disabled">
                <small>
                    {{ $this->dataInicial . (!empty($this->dataFinal) ? ' - ' . $this->dataFinal : '') }}
                </small>
            </button>
            <button type="button" class="col-2 btn btn-light" wire:click="navegData('+')">
                <i class="bi bi-caret-right-fill"></i>
            </button>
        </div>
    </div>

    @php
        $diasDaSemana = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'];
    @endphp

    <div class="mt-2">
        @foreach ($this->diasAtivos as $dia => $valor)
            <div class="row mt-1 ">
                <div class="col">
                    <label class="form-check-label"
                        for="dia_{{ $dia }}">{{ $diasDaSemana[$loop->iteration - 1] }}
                    </label>
                </div>
                <div class="col text-end">
                    <input class="form-check-input"
                        {{ $this->periodoSelecionado == 'Dia' || $this->periodoSelecionado == 'Ano' ? 'disabled' : '' }}
                        type="checkbox" wire:model.live="diasAtivos.{{ $dia }}" id="dia_{{ $dia }}"
                        wire:loading.attr="disabled">
                </div>
            </div>
        @endforeach
    </div>
</x-caixa>
